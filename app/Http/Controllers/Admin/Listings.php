<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;

class Listings extends Controller
{
    public function store(Request $request){
        $listing= new Listing();

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
        $listing->listings_points=json_encode($request->listings_points);
       $arr1 = is_string($request->listings_icons) ? json_decode($request->listings_icons, true) : ($request->listings_icons ?? []);
        $arr2 = is_string($request->listings_extras) ? json_decode($request->listings_extras, true) : ($request->listings_extras ?? []);

        $arr3 = [];

        foreach ($arr2 as $index => $extra) {
            if (isset($arr1[$index])) {
                $arr3[$extra] = $arr1[$index];
            }
        }

        $listing->listings_extras = json_encode($arr3);
        $listing->listings_number_of_persons=$request->listings_number_of_persons;
        $listing->save();
        return redirect()->back()->with('success', 'Listing Added!');
    }

}
