<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;

class Listings extends Controller
{
    public function index()
    {
        $listings = Listing::orderBy('listings_id', 'DESC')->get();
        return view('admin.listings.index', compact('listings'));
    }

    public function create()
    {
        return view('admin.listings.create');
    }

    public function store(Request $request)
    {
        $listing = new Listing();

        if ($request->hasFile('images')) {
            $imageNames = [];
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/listing/'), $filename);
                $imageNames[] = $filename;
            }
            $listing->listings_img = json_encode($imageNames);
        } else {
            $listing->listings_img = json_encode([]);
        }

        $listing->listings_name = $request->listings_name;
        $listing->listings_price = $request->listings_price;
        $listing->listings_points = json_encode($request->listings_points ?? []);
        
        $arr1 = is_string($request->listings_icons) ? json_decode($request->listings_icons, true) : ($request->listings_icons ?? []);
        $arr2 = is_string($request->listings_extras) ? json_decode($request->listings_extras, true) : ($request->listings_extras ?? []);

        $arr3 = [];
        foreach ($arr2 as $index => $extra) {
            if (isset($arr1[$index])) {
                $arr3[$extra] = $arr1[$index];
            }
        }

        $listing->listings_extras = json_encode($arr3);
        $listing->listings_number_of_persons = $request->listings_number_of_persons;
        $listing->listings_number_of_rooms = $request->listings_number_of_rooms;
        $listing->listings_status = $request->listings_status ?? 1;
        
        $listing->save();
        return redirect('admin/listings')->with('success', 'Listing Added Successfully!');
    }

    public function edit($id)
    {
        $listing = Listing::findOrFail($id);
        return view('admin.listings.edit', compact('listing'));
    }

    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        $existingImages = json_decode($listing->listings_img, true) ?? [];
        $preloadedImages = $request->old_images ?? []; // Array of existing images that were NOT removed

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/listing/'), $filename);
                $preloadedImages[] = $filename;
            }
        }
        
        $listing->listings_img = json_encode(array_values($preloadedImages));

        $listing->listings_name = $request->listings_name;
        $listing->listings_price = $request->listings_price;
        $listing->listings_points = json_encode($request->listings_points ?? []);

        $arr1 = is_string($request->listings_icons) ? json_decode($request->listings_icons, true) : ($request->listings_icons ?? []);
        $arr2 = is_string($request->listings_extras) ? json_decode($request->listings_extras, true) : ($request->listings_extras ?? []);

        $arr3 = [];
        foreach ($arr2 as $index => $extra) {
            if (isset($arr1[$index])) {
                $arr3[$extra] = $arr1[$index];
            }
        }

        $listing->listings_extras = json_encode($arr3);
        $listing->listings_number_of_persons = $request->listings_number_of_persons;
        $listing->listings_number_of_rooms = $request->listings_number_of_rooms;
        $listing->listings_status = $request->listings_status ?? 1;
        
        $listing->save();
        return redirect('admin/listings')->with('success', 'Listing Updated Successfully!');
    }

    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->delete();
        return redirect('admin/listings')->with('success', 'Listing Deleted Successfully!');
    }
}
