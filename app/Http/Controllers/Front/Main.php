<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class Main extends Controller
{
    
    public function index(){

        return view('front.index');

    }
    public function booking(){

        $listings = \App\Models\Listing::orderBy('listings_id', 'desc')->get();
        $cartRows = \DB::table('cart')->where('session_id', session()->getId())->get()->keyBy('listings_id');
        $cartItems = $cartRows->keys()->toArray();
        $cartCount = count($cartItems);
        $general_setting = \DB::table('general_setting')->where('general_setting_id', '1')->first();

        // Rooms still free for the dates in the URL, so the first paint is
        // already correct; the page refreshes this over AJAX as dates change.
        $checkIn  = request()->get('check_in');
        $checkOut = request()->get('check_out');
        $availability = [];

        foreach ($listings as $listing) {
            $total = \App\Support\RoomAvailability::totalRooms($listing);
            $availability[$listing->listings_id] = ($checkIn && $checkOut)
                ? \App\Support\RoomAvailability::remaining($listing, $checkIn, $checkOut)
                : $total;
        }

        return view('front.booking',compact('listings', 'cartCount', 'cartItems', 'cartRows', 'general_setting', 'availability'));
    
    }


    public function room(){

        // The two room tabs on this page are hand-written, so the listings are
        // handed over keyed by slug and each tab picks out its own. Matching on
        // slug rather than position means reordering the listings in admin
        // cannot put one room's photos under the other room's heading.
        $roomListings = \App\Models\Listing::where('listings_status', 1)
            ->get()
            ->keyBy('listings_slug');

        return view('front.room', compact('roomListings'));
    }

    public function gallery(){
        return view('front.gallery');
    }


    public function checkout(){

        $checkout = DB::table('cart')->where('session_id', session()->getId())->join('listings','cart.listings_id','=','listings.listings_id')->get();
        if ($checkout->isEmpty()) {
            flash()->error('Your cart is empty.');
            return redirect()->to('/');
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
            
            $itemTotal = $cart->listings_price * $cart->cart_rooms * $nights;
            $roomSubtotal += $itemTotal;

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

        return view('front.checkout', compact('checkout', 'roomSubtotal', 'pet_fee_total', 'laundry_fee_total', 'subtotal', 'tax', 'total', 'tax_rate', 'currency', 'general_setting'));
    }

    public function memberships(){
        return view('front.memberships');
    }

    public function contact(){
        return view('front.contact');
    }

    public function about(){
        return view('front.about');
    }

    public function cookie_privacy(){
        return view('front.cookie-privacy');
    }

    public function privacy(){
        return view('front.privacy');
    }

    public function term_condition(){
        return view('front.term-condition');
    }

    
}
