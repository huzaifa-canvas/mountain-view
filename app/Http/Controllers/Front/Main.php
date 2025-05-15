<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        return view('front.checkout');
    }
}
