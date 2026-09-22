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

        $orders = $query->paginate(15);
        $listings = \App\Models\Listing::all();
        $general_setting = DB::table('general_setting')->where('general_setting_id', '1')->first();
        $currency = $general_setting ? $general_setting->currency : 'CAD';

        return view('admin.orders.index', compact('orders', 'currency', 'listings'));
    }

    public function show($id)
    {
        $order = Order::with(['customer', 'items.listing'])->findOrFail($id);
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
     * Mark an order as checked out and send Thank You + Feedback email to guest.
     */
    public function markCheckedOut(Request $request, $id)
    {
        $order = Order::with(['customer', 'items'])->findOrFail($id);

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
