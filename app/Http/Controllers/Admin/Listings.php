<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lisiting;

class Listings extends Controller
{
    public function store(Request $request,$id){
        $listing= new Lisiting();

        if ($request->hasFile('images')) {
            $imageNames = [];
            foreach ($request->file('images') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/listing/'), $filename);
            $imageNames[] = $filename;
            }
            $listing->listings_img = json_encode($imageNames);
        }
        
        $listing->listings_name=$request->listings_name;
        $listing->listings_price=$request->listings_price;
        $home->listings_points=json_encode($request->listings_points);
        $home->listings_extras=json_encode($request->listings_extras);
        $home->listings_number_of_persons=$request->listings_number_of_persons;
        $home->save();
        return redirect()->back()->with('success', 'Listing Added!');
    }

}
