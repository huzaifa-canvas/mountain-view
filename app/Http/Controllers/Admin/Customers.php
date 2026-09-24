<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\LoyaltyTransaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Registered members (the customer guard), as opposed to one-off guests who
 * book without an account. Read-only: the admin looks members up, it does not
 * edit them, since members manage their own profile from the front end.
 */
class Customers extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $query = Customer::query()
            // Primary key, not created_at: it is indexed, so paging stays cheap
            // however many members sign up.
            ->orderByDesc('id')
            ->withCount('orders')
            ->withSum(
                ['orders as total_spent' => fn ($q) => $q->where('payment_status', 'paid')],
                'grand_total'
            );

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('first_name', 'like', $like)
                  ->orWhere('last_name', 'like', $like)
                  ->orWhere('email', 'like', $like)
                  ->orWhere('phone', 'like', $like)
                  ->orWhere('city', 'like', $like);
            });
        }

        $summary = [
            'count'  => (clone $query)->count(),
            'points' => (float) Customer::sum('loyalty_points'),
        ];

        $customers = $query->paginate(15);

        $general_setting = DB::table('general_setting')->where('general_setting_id', '1')->first();
        $currency = $general_setting->currency ?? 'CAD';

        return view('admin.customers.index', compact('customers', 'currency', 'search', 'summary'));
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);

        $orders = Order::with('items')
            ->where('customer_id', $customer->id)
            ->orderByDesc('id')
            ->get();

        // ID proofs are uploaded per booking at checkout, not on the profile,
        // so a member can have several — newest first.
        $idProofs = $orders->filter(fn ($order) => !empty($order->guest_id_proof));

        $transactions = LoyaltyTransaction::where('customer_id', $customer->id)
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        $stats = [
            'bookings'    => $orders->count(),
            'paid'        => $orders->where('payment_status', 'paid')->count(),
            'spent'       => (float) $orders->where('payment_status', 'paid')->sum('grand_total'),
            'nights'      => (int) $orders->flatMap->items->sum('nights'),
            'earned'      => (float) $transactions->where('type', 'earned')->sum('points'),
            'redeemed'    => (float) $transactions->where('type', 'redeemed')->sum('points'),
            'last_stay'   => $orders->flatMap->items->max('check_out'),
        ];

        $general_setting = DB::table('general_setting')->where('general_setting_id', '1')->first();
        $currency = $general_setting->currency ?? 'CAD';

        return view('admin.customers.show', compact('customer', 'orders', 'idProofs', 'transactions', 'stats', 'currency'));
    }
}
