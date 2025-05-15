<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
class Ecommerce extends Controller
{
    public function booking_cart(Request $request,$id){
        $data = $request->all();
        $validate = \Validator::make($data, [
            'laundry' => 'required',
            'pets' => 'required',
            'room' => 'required',
        ]);

        if($validate->fails()){
            flash()->error($validate->errors());
            return redirect()->back();
        }
        $cart = new Cart();
        $cart->session_id = $request->session()->getId();
        $cart->listings_id = $id;
        $cart->cart_laundry = $data['laundry'];
        $cart->cart_pets = $data['pets'];
        $cart->cart_rooms = $data['room'];
        $cart->save();
        flash()->success('Item added to cart successfully');
        return redirect()->back();
    }

    public function checkout(){

      return redirect()->back()->with('success','Checkout successfully');
      
    }
}
