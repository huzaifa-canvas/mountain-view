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
        $cart->cart_check_in = $request->get('checkin');
        $cart->cart_check_out = $request->get('checkout');
        $cart->save();
        flash()->success('Room added to cart successfully');
        return redirect('checkout');
    }

    public function checkout(){
        $accessToken = 'e29cc5da-a5a5-e71e-2a49-35fdc2aee152';
        $merchantId = 'CMNW2BQJ42JR1';  

        $response = Http::withToken($accessToken)->post("https://sandbox.dev.clover.com/v1/merchants/{$merchantId}/paykeys", [
            "amount" => 1000, 
            "currency" => "usd",
            "redirect_url" => url('/payment/success'),
        ]);

        $checkout = $response->json();

        if (!isset($checkout['url'])) {
            return response()->json([
                'error' => 'Checkout URL not found in response.',
                'response' => $checkout
            ], 500);
        }

        return response()->json([
            'checkout_url' => $checkout['url'],
        ]);
      
    }

}
