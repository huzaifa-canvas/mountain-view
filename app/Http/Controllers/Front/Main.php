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
        return view('front.booking',compact('listings'));
    
    }


    public function room(){
        return view('front.room');
    }

    public function gallery(){
        return view('front.gallery');
    }


    public function checkout(){

        $checkout = DB::table('cart')->where('session_id', session()->getId())->join('listings','cart.listings_id','=','listings.listings_id')->get();
        $total = $checkout->sum('listings_price');
        if ($checkout->isEmpty()) {
            flash()->error('Your cart is empty.');
            return redirect()->to('/');
        }

        return view('front.checkout', compact('checkout', 'total'));
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
