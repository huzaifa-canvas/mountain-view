<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Http;
class Ecommerce extends Controller
{
    public function booking_cart(Request $request,$id){
        $data = $request->all();
        $validate = \Validator::make($data, [
            'laundry' => 'required',
            'pets' => 'required',
            'room' => 'required|numeric|min:1',
        ]);

        if($validate->fails()){
            if($request->ajax()) {
                return response()->json(['success' => false, 'errors' => $validate->errors()]);
            }
            flash()->error($validate->errors());
            return redirect()->back();
        }

        // A listing can only be reserved up to the rooms it actually has free
        // on every night of the requested stay.
        $listing = \App\Models\Listing::find($id);

        if (!$listing) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'This room is no longer available.'], 404);
            }
            flash()->error('This room is no longer available.');
            return redirect()->back();
        }

        $requestedRooms = (int) $data['room'];
        $remaining = \App\Support\RoomAvailability::remaining(
            $listing,
            $request->get('checkin'),
            $request->get('checkout')
        );

        if ($remaining !== null && $requestedRooms > $remaining) {
            $message = $remaining === 0
                ? 'Sorry, ' . $listing->listings_name . ' is fully booked for those dates.'
                : 'Only ' . $remaining . ' ' . \Str::plural('room', $remaining) . ' left in ' . $listing->listings_name . ' for those dates.';

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $message, 'remaining' => $remaining], 422);
            }
            flash()->error($message);
            return redirect()->back();
        }

        // Check if already in cart
        $cart = Cart::where('listings_id', $id)->where('session_id', $request->session()->getId())->first();
        if(!$cart) {
            $cart = new Cart();
            $cart->session_id = $request->session()->getId();
            $cart->listings_id = $id;
        }

        $laundryQty = ($data['laundry'] === 'Yes') ? max(1, intval($request->get('laundry_qty', 1))) : 0;
        $cart->cart_laundry = ($data['laundry'] === 'Yes') ? "Yes ({$laundryQty} load" . ($laundryQty > 1 ? "s" : "") . ")" : "No";
        $cart->cart_laundry_qty = $laundryQty;
        $cart->cart_pets = $data['pets'];
        $cart->cart_rooms = $data['room'];
        $cart->cart_check_in = $request->get('checkin');
        $cart->cart_check_out = $request->get('checkout');
        $cart->save();

        if($request->ajax()) {
            $cartCount = Cart::where('session_id', $request->session()->getId())->count();
            return response()->json(['success' => true, 'message' => 'Room reserved successfully!', 'cartCount' => $cartCount]);
        }

        flash()->success('Room reserved successfully! You can continue browsing or proceed to checkout.');
        return redirect()->back();
    }

    public function remove_cart(Request $request, $id){
        $cart = Cart::where('cart_id', $id)->where('session_id', $request->session()->getId())->first();
        if($cart){
            $cart->delete();
            flash()->success('Room removed from cart.');
        }
        return redirect()->back();
    }

    public function remove_cart_listing(Request $request, $id){
        $cart = Cart::where('listings_id', $id)->where('session_id', $request->session()->getId())->first();
        if($cart){
            $cart->delete();
        }
        if($request->ajax()) {
            $cartCount = Cart::where('session_id', $request->session()->getId())->count();
            return response()->json(['success' => true, 'message' => 'Room removed from cart.', 'cartCount' => $cartCount]);
        }
        flash()->success('Room removed from cart.');
        return redirect()->back();
    }

    /**
     * Rooms still free per listing for a set of dates, for the booking page.
     * With no dates it falls back to each listing's total room count.
     */
    public function availability(Request $request)
    {
        $checkIn  = $request->query('check_in');
        $checkOut = $request->query('check_out');

        $listings = [];

        foreach (\App\Models\Listing::where('listings_status', 1)->get() as $listing) {
            $total = \App\Support\RoomAvailability::totalRooms($listing);

            $remaining = ($checkIn && $checkOut)
                ? \App\Support\RoomAvailability::remaining($listing, $checkIn, $checkOut)
                : $total;

            $listings[$listing->listings_id] = [
                'total'     => $total,
                'remaining' => $remaining,
            ];
        }

        return response()->json(['listings' => $listings]);
    }

    /**
     * Free rooms per night for the date picker, so the calendar can show what
     * is left and grey out nights where nothing is available.
     */
    public function calendarAvailability(Request $request)
    {
        $from = $request->query('from');
        $to   = $request->query('to');

        $start = $from ? \Carbon\Carbon::parse($from)->startOfDay() : now()->startOfDay();
        $end   = $to ? \Carbon\Carbon::parse($to)->startOfDay() : $start->copy()->addYear();

        // Keep the window sane whatever the caller asks for
        if ($end->greaterThan($start->copy()->addYear())) {
            $end = $start->copy()->addYear();
        }

        return response()->json([
            'dates' => \App\Support\RoomAvailability::calendar($start, $end),
        ]);
    }

    /**
     * Re-checks every line in the cart against live availability.
     *
     * Rooms can sell out between adding to the cart and paying, so this runs
     * again at payment time rather than trusting the check made at add-to-cart.
     *
     * @return string|null the problem to show the guest, or null if all fits
     */
    private function unavailableCartMessage($cartItems): ?string
    {
        foreach ($cartItems as $cart) {
            $listing = \App\Models\Listing::find($cart->listings_id);

            if (!$listing) {
                return 'One of the rooms in your cart is no longer available.';
            }

            $remaining = \App\Support\RoomAvailability::remaining(
                $listing,
                $cart->cart_check_in,
                $cart->cart_check_out
            );

            if ($remaining !== null && (int) $cart->cart_rooms > $remaining) {
                return $remaining === 0
                    ? $listing->listings_name . ' is fully booked for your dates. Please choose different dates.'
                    : 'Only ' . $remaining . ' ' . \Str::plural('room', $remaining) . ' left in ' . $listing->listings_name
                      . ' for your dates. Please update your booking.';
            }
        }

        return null;
    }

    public function applyLoyalty(Request $request)
    {
        $checkout = Cart::where('session_id', $request->session()->getId())
                        ->join('listings', 'cart.listings_id', '=', 'listings.listings_id')
                        ->get();

        if ($checkout->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty'], 400);
        }

        $general_setting = \DB::table('general_setting')->where('general_setting_id', '1')->first();
        $tax_rate = $general_setting ? $general_setting->tax_rate : 15.00;
        $pet_fee_rate = $general_setting && isset($general_setting->pet_fee) ? $general_setting->pet_fee : 25.00;
        $laundry_fee_rate = $general_setting && isset($general_setting->laundry_fee) ? $general_setting->laundry_fee : 25.00;

        $roomSubtotal = 0;
        $pet_fee_total = 0;
        $laundry_fee_total = 0;

        foreach($checkout as $cart) {
            $checkIn = \Carbon\Carbon::parse($cart->cart_check_in);
            $checkOut = \Carbon\Carbon::parse($cart->cart_check_out);
            $nights = $checkIn->diffInDays($checkOut) ?: 1;
            $roomSubtotal += ($cart->listings_price * $cart->cart_rooms * $nights);

            if ($cart->cart_pets > 0) {
                $pet_fee_total += ($cart->cart_pets * $pet_fee_rate);
            }
            if (!empty($cart->cart_laundry_qty) && $cart->cart_laundry_qty > 0) {
                $laundry_fee_total += ($cart->cart_laundry_qty * $laundry_fee_rate);
            }
        }

        $subtotal = $roomSubtotal + $pet_fee_total + $laundry_fee_total;
        $tax = $subtotal * ($tax_rate / 100);
        $total = $subtotal + $tax;

        $loyalty_discount = 0;
        $apply = $request->input('apply_loyalty', false);

        if ($apply && \Auth::guard('customer')->check()) {
            $customer = \Auth::guard('customer')->user();
            $redemption_rate = $general_setting ? $general_setting->loyalty_points_redemption_rate : 0.10;
            $max_points_value = $customer->loyalty_points * $redemption_rate;
            $loyalty_discount = min($max_points_value, $total);
            $total -= $loyalty_discount;

            $request->session()->put('applied_loyalty_discount', $loyalty_discount);
            $request->session()->put('applied_loyalty_points', $loyalty_discount / $redemption_rate);
        } else {
            $request->session()->forget(['applied_loyalty_discount', 'applied_loyalty_points']);
        }

        return response()->json([
            'success' => true,
            'loyalty_discount' => $loyalty_discount,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);
    }

    public function createPaymentIntent(Request $request)
    {
        $checkout = Cart::where('session_id', $request->session()->getId())
                        ->join('listings', 'cart.listings_id', '=', 'listings.listings_id')
                        ->get();
                        
        if ($checkout->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        if ($problem = $this->unavailableCartMessage($checkout)) {
            return response()->json(['success' => false, 'error' => $problem, 'message' => $problem], 409);
        }

        $general_setting = \DB::table('general_setting')->where('general_setting_id', '1')->first();
        $tax_rate = $general_setting ? $general_setting->tax_rate : 15.00;
        $currency = $general_setting ? $general_setting->currency : 'CAD';
        $pet_fee_rate = $general_setting && isset($general_setting->pet_fee) ? $general_setting->pet_fee : 25.00;
        $laundry_fee_rate = $general_setting && isset($general_setting->laundry_fee) ? $general_setting->laundry_fee : 25.00;

        $roomSubtotal = 0;
        $pet_fee_total = 0;
        $laundry_fee_total = 0;

        foreach($checkout as $cart) {
            $checkIn = \Carbon\Carbon::parse($cart->cart_check_in);
            $checkOut = \Carbon\Carbon::parse($cart->cart_check_out);
            $nights = $checkIn->diffInDays($checkOut);
            $nights = $nights > 0 ? $nights : 1;
            
            $roomSubtotal += ($cart->listings_price * $cart->cart_rooms * $nights);

            if ($cart->cart_pets > 0) {
                $pet_fee_total += ($cart->cart_pets * $pet_fee_rate);
            }
            if (!empty($cart->cart_laundry_qty) && $cart->cart_laundry_qty > 0) {
                $laundry_fee_total += ($cart->cart_laundry_qty * $laundry_fee_rate);
            }
        }

        $subtotal = $roomSubtotal + $pet_fee_total + $laundry_fee_total;
        $tax = $subtotal * ($tax_rate / 100);
        $total = $subtotal + $tax;
        
        // Apply loyalty discount if requested
        $loyalty_discount = 0;
        if ($request->has('apply_points') && $request->apply_points && \Auth::guard('customer')->check()) {
            $customer = \Auth::guard('customer')->user();
            $redemption_rate = $general_setting ? $general_setting->loyalty_points_redemption_rate : 0.10;
            $max_points_value = $customer->loyalty_points * $redemption_rate;
            
            // Can't discount more than total
            $loyalty_discount = min($max_points_value, $total);
            $total -= $loyalty_discount;
            
            $request->session()->put('applied_loyalty_discount', $loyalty_discount);
            $request->session()->put('applied_loyalty_points', $loyalty_discount / $redemption_rate);
        } else {
            $request->session()->forget(['applied_loyalty_discount', 'applied_loyalty_points']);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret') ?: env('STRIPE_SECRET'));

        // Build customer metadata for Stripe
        $customer_name = null;
        $customer_email = null;
        if (\Auth::guard('customer')->check()) {
            $loggedCustomer = \Auth::guard('customer')->user();
            $customer_name = trim($loggedCustomer->first_name . ' ' . $loggedCustomer->last_name);
            $customer_email = $loggedCustomer->email;
        }

        $amount = max(50, round($total * 100));

        try {
            $existingPiId = $request->session()->get('stripe_payment_intent_id');

            if ($existingPiId) {
                // Try to update existing PaymentIntent instead of creating a new one
                try {
                    $paymentIntent = \Stripe\PaymentIntent::retrieve($existingPiId);
                    
                    // Only update if it hasn't been confirmed/succeeded yet
                    if (in_array($paymentIntent->status, ['requires_payment_method', 'requires_confirmation', 'requires_action'])) {
                        $updateData = ['amount' => $amount];
                        
                        if ($customer_name || $customer_email) {
                            $updateData['metadata'] = [
                                'customer_name' => $customer_name,
                                'customer_email' => $customer_email,
                            ];
                        }

                        $paymentIntent = \Stripe\PaymentIntent::update($existingPiId, $updateData);
                    } else {
                        // Old PI is in a terminal state, create a new one
                        $existingPiId = null;
                    }
                } catch (\Exception $e) {
                    // If retrieval fails, create a new one
                    $existingPiId = null;
                }
            }

            if (!$existingPiId) {
                $createData = [
                    'amount' => $amount,
                    'currency' => strtolower($currency),
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                ];

                if ($customer_name || $customer_email) {
                    $createData['metadata'] = [
                        'customer_name' => $customer_name,
                        'customer_email' => $customer_email,
                    ];
                    $createData['description'] = 'Booking by ' . ($customer_name ?: $customer_email);
                    $createData['receipt_email'] = $customer_email;
                }

                $paymentIntent = \Stripe\PaymentIntent::create($createData);
                $request->session()->put('stripe_payment_intent_id', $paymentIntent->id);
            }

            return response()->json([
                'success' => true,
                'clientSecret' => $paymentIntent->client_secret,
                'total' => $total,
                'discount' => $loyalty_discount
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function processPayment(Request $request)
    {
        $paymentIntentId = $request->input('payment_intent');
        
        if (!$paymentIntentId) {
            return redirect()->route('checkout')->with('error', 'Payment information missing.');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret') ?: env('STRIPE_SECRET'));
        
        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            
            if ($paymentIntent->status !== 'succeeded') {
                return redirect()->route('checkout')->with('error', 'Payment was not successful.');
            }
            
            // Create Order
            $cartItems = Cart::where('session_id', $request->session()->getId())
                            ->join('listings', 'cart.listings_id', '=', 'listings.listings_id')
                            ->get();
                            
            if ($cartItems->isEmpty()) {
                return redirect()->route('checkout')->with('error', 'Your cart is empty.');
            }

            // Someone else may have taken the last room while this guest paid.
            // Stop before writing the order; the payment needs refunding in Stripe.
            if ($problem = $this->unavailableCartMessage($cartItems)) {
                \Log::warning('Booking oversold after payment for intent ' . $paymentIntent->id . ': ' . $problem);

                return redirect()->to('/checkout')->with(
                    'error',
                    $problem . ' Your payment has not been used for a booking — please contact us and we will refund it.'
                );
            }

            $general_setting = \DB::table('general_setting')->where('general_setting_id', '1')->first();
            $tax_rate = $general_setting ? $general_setting->tax_rate : 15.00;
            $pet_fee_rate = $general_setting && isset($general_setting->pet_fee) ? $general_setting->pet_fee : 25.00;
            $laundry_fee_rate = $general_setting && isset($general_setting->laundry_fee) ? $general_setting->laundry_fee : 25.00;

            $roomSubtotal = 0;
            $pet_fee_total = 0;
            $laundry_fee_total = 0;

            foreach($cartItems as $cart) {
                $checkIn = \Carbon\Carbon::parse($cart->cart_check_in);
                $checkOut = \Carbon\Carbon::parse($cart->cart_check_out);
                $nights = $checkIn->diffInDays($checkOut) ?: 1;
                $roomSubtotal += ($cart->listings_price * $cart->cart_rooms * $nights);

                if ($cart->cart_pets > 0) {
                    $pet_fee_total += ($cart->cart_pets * $pet_fee_rate);
                }
                if (!empty($cart->cart_laundry_qty) && $cart->cart_laundry_qty > 0) {
                    $laundry_fee_total += ($cart->cart_laundry_qty * $laundry_fee_rate);
                }
            }

            $subtotal = $roomSubtotal + $pet_fee_total + $laundry_fee_total;
            $tax = $subtotal * ($tax_rate / 100);
            $total = $subtotal + $tax;
            
            $loyalty_discount = $request->session()->get('applied_loyalty_discount', 0);
            $loyalty_points_used = $request->session()->get('applied_loyalty_points', 0);
            $final_total = $total - $loyalty_discount;
            
            $customer_id = \Auth::guard('customer')->check() ? \Auth::guard('customer')->id() : null;
            $order_number = 'ORD-' . strtoupper(uniqid());

            // Handle ID Proof Upload
            $idProofPath = null;
            if ($request->hasFile('id_proof')) {
                $file = $request->file('id_proof');
                $filename = time() . '_id_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/id_proofs/'), $filename);
                $idProofPath = 'storage/id_proofs/' . $filename;
            }

            $firstName = $request->input('first_name');
            $lastName = $request->input('last_name');
            $fullName = trim($firstName . ' ' . $lastName);
            if (empty($fullName)) {
                $fullName = $request->input('name');
            }
            
            $order = \App\Models\Order::create([
                'order_number' => $order_number,
                'customer_id' => $customer_id,
                'guest_name' => $customer_id ? null : $fullName,
                'guest_first_name' => $customer_id ? null : $firstName,
                'guest_last_name' => $customer_id ? null : $lastName,
                'guest_email' => $customer_id ? null : $request->input('email'),
                'guest_phone' => $customer_id ? null : $request->input('phone'),
                'guest_address' => $request->input('address'),
                'guest_city' => $request->input('city'),
                'guest_province' => $request->input('province'),
                'guest_postal_code' => $request->input('postal_code'),
                'guest_vehicle_number' => $request->input('vehicle_number'),
                'guest_id_proof' => $idProofPath,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'loyalty_discount' => $loyalty_discount,
                'pet_fee_total' => $pet_fee_total,
                'laundry_fee_total' => $laundry_fee_total,
                'grand_total' => $final_total,
                'stripe_payment_intent_id' => $paymentIntent->id,
                'stripe_charge_id' => $paymentIntent->latest_charge,
                'payment_status' => 'paid',
                'booking_type' => $request->input('booking_type', 'Personal')
            ]);
            
            foreach($cartItems as $cart) {
                $checkIn = \Carbon\Carbon::parse($cart->cart_check_in);
                $checkOut = \Carbon\Carbon::parse($cart->cart_check_out);
                $nights = $checkIn->diffInDays($checkOut) ?: 1;
                $itemTotal = $cart->listings_price * $cart->cart_rooms * $nights;
                
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'listings_id' => $cart->listings_id,
                    'listing_name' => $cart->listings_name,
                    'check_in' => $cart->cart_check_in,
                    'check_out' => $cart->cart_check_out,
                    'rooms' => $cart->cart_rooms,
                    'pets' => $cart->cart_pets,
                    'laundry' => $cart->cart_laundry,
                    'price_per_night' => $cart->listings_price,
                    'nights' => $nights,
                    'item_total' => $itemTotal
                ]);
            }
            
            // Handle Loyalty Points
            if ($customer_id && $general_setting && $general_setting->loyalty_enabled) {
                $customer = \App\Models\Customer::find($customer_id);
                
                // Deduct used points
                if ($loyalty_points_used > 0) {
                    $customer->loyalty_points -= $loyalty_points_used;
                    \App\Models\LoyaltyTransaction::create([
                        'customer_id' => $customer_id,
                        'order_id' => $order->id,
                        'points' => $loyalty_points_used,
                        'type' => 'redeemed',
                        'description' => 'Redeemed for Order ' . $order_number
                    ]);
                }
                
                // Award new points based on final total paid
                $points_per_dollar = $general_setting->loyalty_points_per_dollar ?: 0.2;
                $earned_points = floor($final_total * $points_per_dollar);
                
                if ($earned_points > 0) {
                    $customer->loyalty_points += $earned_points;
                    \App\Models\LoyaltyTransaction::create([
                        'customer_id' => $customer_id,
                        'order_id' => $order->id,
                        'points' => $earned_points,
                        'type' => 'earned',
                        'description' => 'Earned from Order ' . $order_number
                    ]);
                }
                
                $customer->save();
            }
            
            // Clear cart
            Cart::where('session_id', $request->session()->getId())->delete();
            $request->session()->forget(['applied_loyalty_discount', 'applied_loyalty_points', 'stripe_payment_intent_id']);
            
            // Send Emails
            try {
                $customer_email = $customer_id ? \Auth::guard('customer')->user()->email : $request->input('email');
                if ($customer_email) {
                    \Mail::to($customer_email)->send(new \App\Mail\BookingConfirmation($order));
                }
                
                $admin_email = $general_setting ? $general_setting->general_setting_email : env('MAIL_FROM_ADDRESS');
                if ($admin_email) {
                    \Mail::to($admin_email)->send(new \App\Mail\AdminNewBooking($order));
                }
            } catch (\Exception $e) {
                // Log email error but don't fail checkout
                \Log::error('Email sending failed for order ' . $order_number . ': ' . $e->getMessage());
            }

            return redirect()->route('checkout.success', $order_number);
            
        } catch (\Exception $e) {
            return redirect()->to('/checkout')->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }
    
    public function orderSuccess($orderNumber)
    {
        $order = \App\Models\Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        
        // Ensure user can only view their own order unless they are a guest who just ordered it
        if ($order->customer_id && (!\Auth::guard('customer')->check() || \Auth::guard('customer')->id() !== $order->customer_id)) {
            return redirect('/');
        }
        
        $general_setting = \DB::table('general_setting')->where('general_setting_id', '1')->first();
        $currency = $general_setting ? $general_setting->currency : 'CAD';
        
        return view('front.checkout-success', compact('order', 'currency'));
    }
}
