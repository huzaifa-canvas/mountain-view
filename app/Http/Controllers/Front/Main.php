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
        $cartItems = \DB::table('cart')->where('session_id', session()->getId())->pluck('listings_id')->toArray();
        $cartCount = count($cartItems);
        return view('front.booking',compact('listings', 'cartCount', 'cartItems'));
    
    }


    public function room(){
        return view('front.room');
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
        
        $subtotal = 0;
        foreach($checkout as $cart) {
            $checkIn = \Carbon\Carbon::parse($cart->cart_check_in);
            $checkOut = \Carbon\Carbon::parse($cart->cart_check_out);
            $nights = $checkIn->diffInDays($checkOut);
            $nights = $nights > 0 ? $nights : 1;
            
            $itemTotal = $cart->listings_price * $cart->cart_rooms * $nights;
            $subtotal += $itemTotal;
        }

        $general_setting = \DB::table('general_setting')->where('general_setting_id', '1')->first();
        $tax_rate = $general_setting ? $general_setting->tax_rate : 15.00;
        $currency = $general_setting ? $general_setting->currency : 'CAD';
        
        $tax = $subtotal * ($tax_rate / 100);
        $total = $subtotal + $tax;

        return view('front.checkout', compact('checkout', 'subtotal', 'tax', 'total', 'tax_rate', 'currency', 'general_setting'));
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
