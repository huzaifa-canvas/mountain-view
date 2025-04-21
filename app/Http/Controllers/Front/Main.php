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
        return view('front.booking');
    }


    public function room(){
        return view('front.room');
    }
}
