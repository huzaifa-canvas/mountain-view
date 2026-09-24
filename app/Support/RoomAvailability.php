<?php

namespace App\Support;

use App\Models\Listing;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * How many rooms of a listing are still free over a set of dates.
 *
 * A stay from check-in to check-out occupies the nights in [check_in, check_out),
 * so two stays clash when `a.check_in < b.check_out && b.check_in < a.check_out`.
 * Occupancy is counted per night and the busiest night in the requested range
 * decides what is left — a listing with 6 rooms can take a 3-night booking only
 * if all three of those nights have a room spare.
 *
 * Only paid, uncancelled bookings hold rooms. Other people's shopping carts do
 * not: a cart is not a reservation, and abandoned ones would otherwise lock up
 * inventory indefinitely.
 */
class RoomAvailability
{
    /** Total rooms on a listing, or null when no limit has been configured. */
    public static function totalRooms(Listing $listing): ?int
    {
        $total = $listing->listings_number_of_rooms;

        if ($total === null || $total === '' || !is_numeric($total)) {
            return null;
        }

        $total = (int) $total;

        return $total > 0 ? $total : null;
    }

    /**
     * The most rooms taken on any single night of the requested range.
     *
     * @param int|null $ignoreOrderId an order to leave out, so re-checking an
     *                                existing booking does not clash with itself
     */
    public static function bookedRooms(int $listingId, $checkIn, $checkOut, ?int $ignoreOrderId = null): int
    {
        $nights = self::nights($checkIn, $checkOut);

        if ($nights->isEmpty()) {
            return 0;
        }

        $rangeStart = $nights->first();
        $rangeEnd   = $nights->last()->copy()->addDay();

        $items = OrderItem::query()
            ->where('listings_id', $listingId)
            ->whereDate('check_in', '<', $rangeEnd->toDateString())
            ->whereDate('check_out', '>', $rangeStart->toDateString())
            ->whereHas('order', function ($q) {
                $q->where('payment_status', 'paid')
                  ->where('checkout_status', '!=', 'cancelled');
            })
            ->when($ignoreOrderId, fn ($q) => $q->where('order_id', '!=', $ignoreOrderId))
            ->get(['check_in', 'check_out', 'rooms']);

        if ($items->isEmpty()) {
            return 0;
        }

        $busiest = 0;

        foreach ($nights as $night) {
            $taken = 0;

            foreach ($items as $item) {
                $itemIn  = Carbon::parse($item->check_in)->startOfDay();
                $itemOut = Carbon::parse($item->check_out)->startOfDay();

                // A same-day row still occupies the night it starts on
                if ($itemOut->lessThanOrEqualTo($itemIn)) {
                    $itemOut = $itemIn->copy()->addDay();
                }

                if ($night->greaterThanOrEqualTo($itemIn) && $night->lessThan($itemOut)) {
                    $taken += (int) $item->rooms;
                }
            }

            $busiest = max($busiest, $taken);
        }

        return $busiest;
    }

    /** Rooms still bookable over the range, or null when the listing has no limit. */
    public static function remaining(Listing $listing, $checkIn, $checkOut, ?int $ignoreOrderId = null): ?int
    {
        $total = self::totalRooms($listing);

        if ($total === null) {
            return null;
        }

        return max(0, $total - self::bookedRooms($listing->listings_id, $checkIn, $checkOut, $ignoreOrderId));
    }

    /** Whether the requested number of rooms fits over the whole range. */
    public static function canFit(Listing $listing, $checkIn, $checkOut, int $rooms, ?int $ignoreOrderId = null): bool
    {
        if ($rooms < 1) {
            return false;
        }

        $remaining = self::remaining($listing, $checkIn, $checkOut, $ignoreOrderId);

        return $remaining === null || $rooms <= $remaining;
    }

    /**
     * Free rooms for every night in a window, for the date picker.
     *
     * Built from a single query and one pass over the bookings rather than a
     * lookup per day, so a year-long calendar stays cheap.
     *
     * @return array<string, array{free:int, full:bool, listings:array<int,int>}>
     *         keyed by Y-m-d
     */
    public static function calendar($from, $to): array
    {
        $start = Carbon::parse($from)->startOfDay();
        $end   = Carbon::parse($to)->startOfDay();

        if ($end->lessThanOrEqualTo($start)) {
            $end = $start->copy()->addDay();
        }

        $listings = Listing::where('listings_status', 1)->get();

        // Per listing: total rooms, and null for the ones with no limit set
        $totals = [];
        $hasUnlimited = false;

        foreach ($listings as $listing) {
            $total = self::totalRooms($listing);
            $totals[$listing->listings_id] = $total;
            $hasUnlimited = $hasUnlimited || $total === null;
        }

        if (empty($totals)) {
            return [];
        }

        $items = OrderItem::query()
            ->whereIn('listings_id', array_keys($totals))
            ->whereDate('check_in', '<', $end->toDateString())
            ->whereDate('check_out', '>', $start->toDateString())
            ->whereHas('order', function ($q) {
                $q->where('payment_status', 'paid')
                  ->where('checkout_status', '!=', 'cancelled');
            })
            ->get(['listings_id', 'check_in', 'check_out', 'rooms']);

        // Walk each booking once, adding its rooms to every night it covers
        $booked = [];

        foreach ($items as $item) {
            $itemIn  = Carbon::parse($item->check_in)->startOfDay();
            $itemOut = Carbon::parse($item->check_out)->startOfDay();

            if ($itemOut->lessThanOrEqualTo($itemIn)) {
                $itemOut = $itemIn->copy()->addDay();
            }

            // Copy explicitly: Carbon's max() hands back one of the two
            // instances, and the loop below mutates what it is given.
            $night = $itemIn->greaterThan($start) ? $itemIn->copy() : $start->copy();

            for (; $night->lessThan($itemOut) && $night->lessThan($end); $night->addDay()) {
                $key = $night->toDateString();
                $booked[$key][$item->listings_id] = ($booked[$key][$item->listings_id] ?? 0) + (int) $item->rooms;
            }
        }

        $calendar = [];

        for ($night = $start->copy(); $night->lessThan($end); $night->addDay()) {
            $key = $night->toDateString();
            $perListing = [];
            $free = 0;

            foreach ($totals as $listingId => $total) {
                if ($total === null) {
                    continue; // no cap, so it never runs out
                }

                $listingFree = max(0, $total - ($booked[$key][$listingId] ?? 0));
                $perListing[$listingId] = $listingFree;
                $free += $listingFree;
            }

            $calendar[$key] = [
                'free'     => $free,
                'full'     => !$hasUnlimited && $free === 0,
                'listings' => $perListing,
            ];
        }

        return $calendar;
    }

    /**
     * Every night covered by a stay, as start-of-day Carbon dates.
     *
     * @return Collection<int, Carbon>
     */
    private static function nights($checkIn, $checkOut): Collection
    {
        if (empty($checkIn) || empty($checkOut)) {
            return collect();
        }

        try {
            $start = Carbon::parse($checkIn)->startOfDay();
            $end   = Carbon::parse($checkOut)->startOfDay();
        } catch (\Throwable) {
            return collect();
        }

        // A booking that checks out on the day it checks in still uses one night
        if ($end->lessThanOrEqualTo($start)) {
            $end = $start->copy()->addDay();
        }

        $nights = collect();

        for ($night = $start->copy(); $night->lessThan($end); $night->addDay()) {
            $nights->push($night->copy());
        }

        return $nights;
    }
}
