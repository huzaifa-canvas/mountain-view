<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerAuth extends Controller
{
    public function showLogin()
    {
        return view('front.customer.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $oldSessionId = $request->session()->getId();
        $cartCount = \App\Models\Cart::where('session_id', $oldSessionId)->count();
        
        if (Auth::guard('customer')->attempt($credentials)) {
            // Migrate cart items if session ID changed
            $newSessionId = $request->session()->getId();
            if ($cartCount > 0 && $oldSessionId !== $newSessionId) {
                \App\Models\Cart::where('session_id', $oldSessionId)->update(['session_id' => $newSessionId]);
            }

            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }

            if ($cartCount > 0) {
                return redirect()->to('/checkout');
            }
            return redirect()->intended('/my-account');
        }

        if ($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Invalid email or password.']);
        }
        return back()->with('error', 'Invalid email or password.');
    }

    public function showRegister()
    {
        return view('front.customer.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()]);
            }
            return back()->withErrors($validator)->withInput();
        }

        $oldSessionId = $request->session()->getId();
        $cartCount = \App\Models\Cart::where('session_id', $oldSessionId)->count();

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
        ]);

        Auth::guard('customer')->login($customer);

        // Migrate cart items if session ID changed
        $newSessionId = $request->session()->getId();
        if ($cartCount > 0 && $oldSessionId !== $newSessionId) {
            \App\Models\Cart::where('session_id', $oldSessionId)->update(['session_id' => $newSessionId]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        if ($cartCount > 0) {
            return redirect()->to('/checkout')->with('success', 'Registration successful!');
        }
        return redirect('/my-account')->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        
        // Don't invalidate entire session, just log out customer
        
        return redirect('/');
    }

    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $orders = $customer->orders()->with('items')->orderBy('created_at', 'desc')->get();

        $general_setting = \DB::table('general_setting')->where('general_setting_id', '1')->first();
        $currency = $general_setting ? $general_setting->currency : 'CAD';
        $redemption_rate = $general_setting ? $general_setting->loyalty_points_redemption_rate : 0.10;

        $points_value = $customer->loyalty_points * $redemption_rate;

        // Only settled money counts as "spent", and only a stay still ahead of
        // the guest counts as upcoming — a cancelled one is neither.
        $paid = $orders->where('payment_status', 'paid');

        $upcoming = $orders->filter(fn ($order) => in_array($order->stayState(), ['awaiting', 'checked_in'], true))
            ->sortBy(fn ($order) => $order->items->min('check_in'))
            ->values();

        $stats = [
            'bookings'    => $orders->count(),
            'upcoming'    => $upcoming->count(),
            'nights'      => (int) $paid->sum(fn ($order) => (int) $order->items->sum('nights')),
            'total_spent' => (float) $paid->sum('grand_total'),
        ];

        $nextStay = $upcoming->first();

        return view('front.customer.dashboard', compact(
            'customer', 'orders', 'currency', 'points_value', 'stats', 'upcoming', 'nextStay'
        ));
    }

    /** One booking in full, scoped so a guest can only ever open their own. */
    public function booking($orderNumber)
    {
        $customer = Auth::guard('customer')->user();

        $order = $customer->orders()
            ->with('items')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        $general_setting = \DB::table('general_setting')->where('general_setting_id', '1')->first();
        $currency = $general_setting ? $general_setting->currency : 'CAD';

        return view('front.customer.booking', compact('customer', 'order', 'currency'));
    }

    /**
     * Let a guest cancel a stay they have not arrived for yet.
     *
     * The reason is required because it is what the front desk sees in the
     * booking timeline; without it a cancellation is unexplainable after the
     * fact. Money is not touched here — any refund is raised in Stripe by
     * staff, so payment_status keeps showing what was actually collected.
     */
    public function cancelBooking(Request $request, $orderNumber)
    {
        $customer = Auth::guard('customer')->user();

        $order = $customer->orders()
            ->with('items')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        if (!$order->canCustomerCancel()) {
            $state = $order->stayState();

            $message = match ($state) {
                'cancelled'   => 'This booking has already been cancelled.',
                'checked_in'  => 'You have already checked in, so please speak to the front desk about ending this stay.',
                'checked_out' => 'This stay has already finished and cannot be cancelled.',
                default       => 'These dates have passed, so this booking can no longer be cancelled online. Please contact us.',
            };

            return redirect()->route('customer.booking.show', $order->order_number)->with('error', $message);
        }

        $validated = $request->validate([
            'cancellation_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ], [
            'cancellation_reason.required' => 'Please tell us why you are cancelling this booking.',
            'cancellation_reason.min'      => 'Please give us a little more detail about why you are cancelling.',
        ]);

        $order->checkout_status = 'cancelled';
        $order->cancelled_at = now();
        $order->cancellation_reason = 'Cancelled by guest: ' . $validated['cancellation_reason'];
        $order->save();

        return redirect()->route('customer.booking.show', $order->order_number)
            ->with('success', 'Your booking has been cancelled. If you have already paid, our team will be in touch about your refund.');
    }

    public function updateProfile(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
        ]);

        $customer->first_name = $request->first_name;
        $customer->middle_name = $request->middle_name;
        $customer->last_name = $request->last_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->state = $request->state;
        $customer->zip_code = $request->zip_code;

        $customer->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $customer->password)) {
            return redirect()->back()->with('error', 'Current password does not match.');
        }

        $customer->password = Hash::make($request->password);
        $customer->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
