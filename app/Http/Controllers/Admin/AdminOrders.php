<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminOrders extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'items'])->orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($cq) use ($search) {
                      $cq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('payment_status', $request->status);
        }

        // Stay Filter — confirmed -> checked_in -> checked_out
        if ($request->has('stay') && !empty($request->stay)) {
            $settled = ['checked_in', 'checked_out', 'cancelled'];

            if (in_array($request->stay, $settled, true)) {
                $query->where('checkout_status', $request->stay);
            } elseif ($request->stay === 'no_show') {
                // Never checked in and every night of the stay is in the past
                $query->whereNotIn('checkout_status', $settled)
                      ->whereHas('items')
                      ->whereDoesntHave('items', function ($q) {
                          $q->whereDate('check_out', '>=', now()->toDateString());
                      });
            } elseif ($request->stay === 'arriving') {
                // Still upcoming or in progress, so not a no-show yet
                $query->whereNotIn('checkout_status', $settled)
                      ->whereHas('items', function ($q) {
                          $q->whereDate('check_out', '>=', now()->toDateString());
                      });
            }
        }

        // Room/Listing Filter
        if ($request->has('listing_id') && !empty($request->listing_id)) {
            $query->whereHas('items', function($q) use ($request) {
                $q->where('listings_id', $request->listing_id);
            });
        }

        // Date-wise Filter (on check_in date)
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereHas('items', function($q) use ($request) {
                $q->whereDate('check_in', '>=', $request->start_date);
            });
        }
        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereHas('items', function($q) use ($request) {
                $q->whereDate('check_in', '<=', $request->end_date);
            });
        }

        // Totals for the current filter set, not just the visible page
        $summary = [
            'count'   => (clone $query)->count(),
            'revenue' => (float) (clone $query)->where('payment_status', 'paid')->sum('grand_total'),
        ];

        $orders = $query->paginate(15);
        $listings = \App\Models\Listing::all();
        $general_setting = DB::table('general_setting')->where('general_setting_id', '1')->first();
        $currency = $general_setting ? $general_setting->currency : 'CAD';

        return view('admin.orders.index', compact('orders', 'currency', 'listings', 'summary'));
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'items.listing', 'changes'])->findOrFail($id);
        $general_setting = DB::table('general_setting')->where('general_setting_id', '1')->first();
        $currency = $general_setting ? $general_setting->currency : 'CAD';

        return view('admin.orders.show', compact('order', 'currency'));
    }

    public function calendar()
    {
        $listings = \App\Models\Listing::all();
        return view('admin.orders.calendar', compact('listings'));
    }

    public function calendarEvents(Request $request)
    {
        $query = OrderItem::with('order.customer');

        // Room/Listing Filter
        if ($request->has('listing_id') && !empty($request->listing_id)) {
            $query->where('listings_id', $request->listing_id);
        }

        $items = $query->get();

        // Harmonious distinctive colors for different rooms
        $colors = [
            '#1E3A8A', // Deep Blue
            '#0D9488', // Teal
            '#7C3AED', // Purple
            '#B91C1C', // Crimson Red
            '#C2410C', // Orange
            '#0284C7', // Sky Blue
            '#4F46E5', // Indigo
            '#059669', // Emerald Green
            '#DB2777', // Pink
            '#78350F', // Brown
        ];

        // Map listings to colors dynamically
        $allListings = \App\Models\Listing::pluck('listings_id')->toArray();
        $colorMap = [];
        foreach ($allListings as $index => $id) {
            $colorMap[$id] = $colors[$index % count($colors)];
        }

        $events = [];
        foreach ($items as $item) {
            $customerName = $item->order->customer_id
                ? ($item->order->customer->first_name . ' ' . $item->order->customer->last_name)
                : $item->order->guest_name;

            // Get mapped color for this listing
            $eventColor = isset($colorMap[$item->listings_id]) ? $colorMap[$item->listings_id] : '#4F46E5';

            $events[] = [
                'id' => $item->id,
                'title' => $item->listing_name . ' - ' . ($customerName ?: 'Guest') . ' (' . $item->rooms . ' Room)',
                'start' => $item->check_in,
                'end' => \Carbon\Carbon::parse($item->check_out)->addDay()->format('Y-m-d'), // FullCalendar end is exclusive
                'url' => route('admin.orders.show', $item->order_id),
                'backgroundColor' => $eventColor,
                'borderColor' => $eventColor,
                'textColor' => '#ffffff'
            ];
        }

        return response()->json($events);
    }

    /**
     * Cancel a booking. The reason is required because it is the only record
     * of why the stay was called off, and it is shown on the order timeline.
     */
    /**
     * The form for a guest who turns up at the desk without booking online.
     */
    public function create()
    {
        $settings = DB::table('general_setting')->where('general_setting_id', '1')->first();

        return view('admin.orders.create', [
            'listings'  => \App\Models\Listing::where('listings_status', 1)->orderBy('listings_name')->get(),
            'settings'  => $settings,
            'currency'  => $settings->currency ?? 'CAD',
            'customers' => \App\Models\Customer::orderBy('first_name')->get(['id', 'first_name', 'last_name', 'email']),
        ]);
    }

    /**
     * Record a walk-in booking.
     *
     * Priced the way the website prices a booking, so a room sold at the desk
     * and the same room sold online come to the same figure. The room limit is
     * checked here too: the desk must not be able to oversell a night the
     * website has already filled.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'listings_id'    => ['required', 'exists:listings,listings_id'],
            'check_in'       => ['required', 'date', 'after_or_equal:today'],
            'check_out'      => ['required', 'date', 'after:check_in'],
            'rooms'          => ['required', 'integer', 'min:1', 'max:100'],
            'guest_name'     => ['required', 'string', 'max:255'],
            'guest_email'    => ['nullable', 'email', 'max:255'],
            'guest_phone'    => ['nullable', 'string', 'max:50'],
            'guest_address'  => ['nullable', 'string', 'max:255'],
            'guest_city'     => ['nullable', 'string', 'max:120'],
            'guest_province' => ['nullable', 'string', 'max:120'],
            'guest_postal_code'    => ['nullable', 'string', 'max:30'],
            'guest_vehicle_number' => ['nullable', 'string', 'max:60'],
            'id_proof'       => ['nullable', 'file', 'max:5120'],
            'customer_id'    => ['nullable', 'exists:customers,id'],
            'pets'           => ['nullable', 'integer', 'min:0', 'max:20'],
            'laundry_qty'    => ['nullable', 'integer', 'min:0', 'max:50'],
            'booking_type'   => ['nullable', 'string', 'max:60'],
            'payment_status' => ['required', 'in:paid,pending'],
            'notes'          => ['nullable', 'string', 'max:2000'],
        ], [
            'check_out.after'      => 'The check-out date has to be after the check-in date.',
            'check_in.after_or_equal' => 'A booking cannot start on a date that has already passed.',
            'listings_id.required' => 'Please choose which room the guest is taking.',
        ]);

        $listing = \App\Models\Listing::where('listings_id', $validated['listings_id'])->firstOrFail();
        $rooms   = (int) $validated['rooms'];

        if (!\App\Support\RoomAvailability::canFit($listing, $validated['check_in'], $validated['check_out'], $rooms)) {
            $left = \App\Support\RoomAvailability::remaining($listing, $validated['check_in'], $validated['check_out']);

            return back()->withInput()->with('error', $left > 0
                ? 'Only ' . $left . ' ' . \Illuminate\Support\Str::plural('room', $left) . ' of ' . $listing->listings_name . ' are free for those dates.'
                : $listing->listings_name . ' is fully booked for those dates.');
        }

        $settings    = DB::table('general_setting')->where('general_setting_id', '1')->first();
        $taxRate     = $settings->tax_rate ?? 15.00;
        $petFeeRate  = $settings->pet_fee ?? 25.00;
        $laundryRate = $settings->laundry_fee ?? 25.00;

        $checkIn  = \Carbon\Carbon::parse($validated['check_in'])->startOfDay();
        $checkOut = \Carbon\Carbon::parse($validated['check_out'])->startOfDay();
        $nights   = (int) $checkIn->diffInDays($checkOut) ?: 1;

        $pets       = (int) ($validated['pets'] ?? 0);
        $laundryQty = (int) ($validated['laundry_qty'] ?? 0);

        $roomSubtotal    = $listing->listings_price * $rooms * $nights;
        $petFeeTotal     = $pets * $petFeeRate;
        $laundryFeeTotal = $laundryQty * $laundryRate;

        $subtotal = $roomSubtotal + $petFeeTotal + $laundryFeeTotal;
        $tax      = $subtotal * ($taxRate / 100);
        $total    = $subtotal + $tax;

        $idProofPath = null;
        if ($request->hasFile('id_proof')) {
            $file = $request->file('id_proof');
            $filename = time() . '_id_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/id_proofs/'), $filename);
            $idProofPath = 'storage/id_proofs/' . $filename;
        }

        $customerId  = $validated['customer_id'] ?? null;
        $checkingIn  = $request->boolean('check_in_now');

        $order = DB::transaction(function () use (
            $validated, $listing, $rooms, $checkIn, $checkOut, $nights, $pets, $laundryQty,
            $roomSubtotal, $petFeeTotal, $laundryFeeTotal, $subtotal, $tax, $total,
            $idProofPath, $customerId, $checkingIn, $settings
        ) {
            // The check above can be passed by two requests at the same moment,
            // and both would then write. Locking this listing's row makes them
            // queue, so the second one re-counts after the first has committed.
            DB::table('listings')->where('listings_id', $listing->listings_id)->lockForUpdate()->first();

            if (!\App\Support\RoomAvailability::canFit($listing, $validated['check_in'], $validated['check_out'], $rooms)) {
                return null;
            }

            $order = Order::create([
                'order_number'     => 'ORD-' . strtoupper(uniqid()),
                'customer_id'      => $customerId,
                'guest_name'       => $validated['guest_name'],
                'guest_email'      => $validated['guest_email'] ?? null,
                'guest_phone'      => $validated['guest_phone'] ?? null,
                'guest_address'    => $validated['guest_address'] ?? null,
                'guest_city'       => $validated['guest_city'] ?? null,
                'guest_province'   => $validated['guest_province'] ?? null,
                'guest_postal_code'    => $validated['guest_postal_code'] ?? null,
                'guest_vehicle_number' => $validated['guest_vehicle_number'] ?? null,
                'guest_id_proof'   => $idProofPath,
                'subtotal'         => $subtotal,
                'tax_amount'       => $tax,
                'loyalty_discount' => 0,
                'pet_fee_total'    => $petFeeTotal,
                'laundry_fee_total' => $laundryFeeTotal,
                'grand_total'      => $total,
                'payment_status'   => $validated['payment_status'],
                // 'confirmed' is what an online booking starts as, and the
                // column is NOT NULL, so a walk-in starts the same way.
                'checkout_status'  => $checkingIn ? 'checked_in' : 'confirmed',
                'checked_in_at'    => $checkingIn ? now() : null,
                'booking_type'     => $validated['booking_type'] ?? 'Walk-in',
                'notes'            => $validated['notes'] ?? null,
            ]);

            OrderItem::create([
                'order_id'     => $order->id,
                'listings_id'  => $listing->listings_id,
                'listing_name' => $listing->listings_name,
                'check_in'     => $checkIn->toDateString(),
                'check_out'    => $checkOut->toDateString(),
                'rooms'        => $rooms,
                'pets'         => $pets,
                'laundry'      => $laundryQty > 0 ? 'Yes' : 'No',
                'price_per_night' => $listing->listings_price,
                'nights'       => $nights,
                'item_total'   => $roomSubtotal,
            ]);

            // A member who books at the desk earns the points they would have
            // earned online. Nothing is redeemed here: spending points stays a
            // decision the guest makes at checkout.
            if ($customerId && $settings && $settings->loyalty_enabled && $validated['payment_status'] === 'paid') {
                $earned = floor($total * ($settings->loyalty_points_per_dollar ?: 0.2));

                if ($earned > 0) {
                    $customer = \App\Models\Customer::find($customerId);
                    $customer->loyalty_points += $earned;
                    $customer->save();

                    \App\Models\LoyaltyTransaction::create([
                        'customer_id' => $customerId,
                        'order_id'    => $order->id,
                        'points'      => $earned,
                        'type'        => 'earned',
                        'description' => 'Earned from Order ' . $order->order_number,
                    ]);
                }
            }

            return $order;
        });

        if ($order === null) {
            return back()->withInput()->with(
                'error',
                $listing->listings_name . ' was taken for those dates while this booking was being saved. Nothing has been charged.'
            );
        }

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Walk-in booking created for ' . $validated['guest_name'] . '.');
    }

    /**
     * What every room type has free over a date range, for the walk-in form.
     *
     * The form asks for dates first and then offers the rooms, so this answers
     * for all listings at once rather than making the page ask room by room.
     */
    public function availability(Request $request)
    {
        $request->validate([
            'check_in'  => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $rooms = \App\Models\Listing::where('listings_status', 1)
            ->orderBy('listings_name')
            ->get()
            ->map(function ($listing) use ($request) {
                $remaining = \App\Support\RoomAvailability::remaining($listing, $request->check_in, $request->check_out);

                return [
                    'id'        => $listing->listings_id,
                    'name'      => $listing->listings_name,
                    'price'     => (float) $listing->listings_price,
                    'total'     => \App\Support\RoomAvailability::totalRooms($listing),
                    'remaining' => $remaining,
                    'sold_out'  => $remaining !== null && $remaining < 1,
                ];
            })
            ->values();

        $nights = \Carbon\Carbon::parse($request->check_in)->startOfDay()
            ->diffInDays(\Carbon\Carbon::parse($request->check_out)->startOfDay());

        return response()->json([
            'nights' => (int) $nights,
            'rooms'  => $rooms,
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);

        if (!$order->canCancel()) {
            return redirect()->back()->with('error', $order->stayState() === 'cancelled'
                ? 'This booking is already cancelled.'
                : 'A booking that has already been checked out cannot be cancelled.');
        }

        $validated = $request->validate([
            'cancellation_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'cancellation_reason.required' => 'Please give a reason for cancelling this booking.',
            'cancellation_reason.min'      => 'Please give a little more detail about why this booking is being cancelled.',
        ]);

        $order->checkout_status = 'cancelled';
        $order->cancelled_at = now();
        $order->cancellation_reason = $validated['cancellation_reason'];
        $order->save();

        // Any refund is handled in Stripe; payment_status is left untouched so
        // the record still shows what was actually collected.
        return redirect()->back()->with('success', 'Booking cancelled. The reason has been added to the timeline.');
    }

    /**
     * Record the guest's arrival. A stay must be checked in before it can be
     * checked out, so this is the only way into the "checked_in" state.
     */
    public function markCheckedIn(Request $request, $id)
    {
        $order = Order::with('items')->findOrFail($id);

        if (!$order->canCheckIn()) {
            return redirect()->back()->with('error', [
                'cancelled'   => 'This booking is cancelled and cannot be checked in.',
                'checked_out' => 'This booking has already been checked out.',
                'checked_in'  => 'This booking is already checked in.',
                'no_show'     => 'This stay has already ended and the guest never arrived, so it cannot be checked in.',
            ][$order->stayState()]);
        }

        $order->checkout_status = 'checked_in';
        $order->checked_in_at = now();
        $order->save();

        return redirect()->back()->with('success', 'Guest checked in. You can mark the booking as checked out when they leave.');
    }

    /**
     * Mark an order as checked out and send Thank You + Feedback email to guest.
     */
    public function markCheckedOut(Request $request, $id)
    {
        $order = Order::with(['customer', 'items'])->findOrFail($id);

        // Checking out without a recorded arrival would leave a gap in the
        // timeline, so the guest must be checked in first.
        if (!$order->canCheckOut()) {
            return redirect()->back()->with('error', [
                'cancelled'   => 'This booking is cancelled and cannot be checked out.',
                'checked_out' => 'This booking has already been checked out.',
                'no_show'     => 'The guest never checked in for this stay, so it cannot be checked out.',
                'awaiting'    => 'Check the guest in before marking the booking as checked out.',
            ][$order->stayState()]);
        }

        $order->checkout_status = 'checked_out';
        $order->checked_out_at = now();
        $order->save();

        // Send Thank You email to guest
        try {
            $guestEmail = $order->customer_id ? $order->customer->email : $order->guest_email;
            if ($guestEmail) {
                \Mail::to($guestEmail)->send(new \App\Mail\GuestThankYou($order));
            }
        } catch (\Exception $e) {
            \Log::error('Thank You email failed for order ' . $order->order_number . ': ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Order marked as Checked Out. Thank you & feedback email sent to guest.');
    }

    /**
     * Send a booking reminder email to the guest.
     */
    public function sendReminder($id)
    {
        $order = Order::with(['customer', 'items'])->findOrFail($id);

        try {
            $guestEmail = $order->customer_id ? $order->customer->email : $order->guest_email;
            if ($guestEmail) {
                \Mail::to($guestEmail)->send(new \App\Mail\BookingReminder($order));
            }
        } catch (\Exception $e) {
            \Log::error('Reminder email failed for order ' . $order->order_number . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to send reminder email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Booking reminder email sent successfully to guest.');
    }

    /**
     * Display guest feedbacks list for admin.
     */
    public function feedbacks(Request $request)
    {
        $query = \App\Models\Feedback::orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%")
                  ->orWhere('order_number', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        $feedbacks = $query->paginate(15);
        return view('admin.orders.feedbacks', compact('feedbacks'));
    }
}
