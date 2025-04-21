<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homepage;
use App\Models\Founder_page;
use App\Models\Teams;
use App\Models\Services;
use App\Models\General_setting;
use App\Models\Videos;
use PhpParser\Node\Stmt\Global_;

class Home extends Controller
{
    public function store(Request $request,$id){
        $home= Homepage::firstOrCreate(['homepage_id' => $id]);
        if($request->hasFile('homepage_background_video')){

            $file = $request->file('homepage_background_video');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/video'), $filename);
            $home->homepage_background_video=$filename;
        }
        if($request->hasFile('homepage_first_section_two_img_one')){

            $file = $request->file('homepage_first_section_two_img_one');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_first_section_two_img_one=$filename;
        }
        if($request->hasFile('homepage_first_section_two_img_two')){

            $file = $request->file('homepage_first_section_two_img_two');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_first_section_two_img_two=$filename;
        }
        if($request->hasFile('homepage_first_section_two_img_three')){

            $file = $request->file('homepage_first_section_two_img_three');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_first_section_two_img_three=$filename;
        }
        if($request->hasFile('homepage_first_section_two_img_four')){

            $file = $request->file('homepage_first_section_two_img_four');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/homepage/'), $filename);
            $home->homepage_first_section_two_img_four=$filename;
        }
      
        
        $home->homepage_first_section_heading=$request->homepage_first_section_heading;
        $home->homepage_first_section_text=$request->homepage_first_section_text;
        $home->homepage_first_section_two_text=$request->homepage_first_section_two_text;
        $home->homepage_first_section_two_heading_one=$request->homepage_first_section_two_heading_one;
        $home->homepage_first_section_two_heading_two=$request->homepage_first_section_two_heading_two;
        $home->homepage_first_section_two_bottom_text=$request->homepage_first_section_two_bottom_text;
        $home->homepage_first_section_three_heading_one=$request->homepage_first_section_three_heading_one;
        $home->homepage_first_section_three_text=$request->homepage_first_section_three_text;
        $home->update();
        return redirect()->back()->with('success', 'Homepage Updated!');
    }
    public function store_founder(Request $request,$id){
        $home= Founder_page::firstOrCreate(['founder_page_id' => $id]);
        if($request->hasFile('founder_page_img')){

            $file = $request->file('founder_page_img');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/founder'), $filename);
            $home->founder_page_img=$filename;
        }
      
        
        $home->founder_page_name=$request->founder_page_name;
        $home->founder_page_name_sub_text=$request->founder_page_name_sub_text;
        $home->founder_page_description=$request->founder_page_description;
        $home->update();
        return redirect()->back()->with('success', 'Page Updated!');
    }
    public function post_team(Request $request){
        $team = new Teams();
        $team->teams_name = $request->teams_name;
        if($request->hasFile('teams_img')){

            $file = $request->file('teams_img');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/team/'), $filename);
            $team->teams_img=$filename;
        }
        $team->save();
        return redirect()->back()->with('success', 'Team Added!');

    }

    public function update_team(Request $request,$id){
        $team = Teams::find($id);
        $team->teams_name = $request->teams_name;
        if($request->hasFile('teams_img')){

            $file = $request->file('teams_img');
            $filename = time().$file->getClientOriginalName();
            $file->move(public_path('storage/team/'), $filename);
            $team->teams_img=$filename;
        }
        $team->save();
        return redirect()->back()->with('success', 'Team Updated!');
    }

    public function post_service(Request $request){
        $service = new Services();
        $service->services_name = $request->services_name;
        if ($request->hasFile('images')) {
            $imageNames = [];
            foreach ($request->file('images') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/service/'), $filename);
            $imageNames[] = $filename;
            }
            $service->services_images = json_encode($imageNames);
        }
        $service->save();
        return redirect()->back()->with('success', 'Service Added!');

    }
    public function update_service(Request $request, $id){
        $service = Services::find($id);
        $service->services_name = $request->services_name;
        if ($request->hasFile('images')) {
            $imageNames = [];
            foreach ($request->file('images') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/service/'), $filename);
            $imageNames[] = $filename;
            }
            $service->services_images = json_encode($imageNames);
        }
        $service->save();
        return redirect()->back()->with('success', 'Service Updated!');
    }
    public function global_setting(Request $request,$id){
        $setting= General_setting::firstOrCreate(['general_setting_id'=>$id]);
        if($request->hasFile('general_setting_logo')){

            $file = $request->file('general_setting_logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/global/'), $filename);
            $setting->general_setting_logo = $filename;
        }
        
        $setting->general_setting_text=$request->general_setting_text;
        $setting->general_setting_logo=$request->general_setting_logo;
        $setting->general_setting_address=$request->general_setting_address;
        $setting->general_setting_phone=$request->general_setting_phone;
        $setting->general_setting_email=$request->general_setting_email;
        $setting->general_setting_facebook=$request->general_setting_facebook;
        $setting->general_setting_linkedin=$request->general_setting_linkedin;
        $setting->general_setting_youtube=$request->general_setting_youtube;
        $setting->general_setting_twitter=$request->general_setting_twitter;        
        $setting->update();
        return redirect()->back()->with('success', 'Website Updated!');
    }

    public function video(Request $request)
    {
        $videos = new Videos(); 
        $videos->videos_name = $request->videos_name;
        if ($request->hasFile('videos_url')) {
            $file = $request->file('videos_url');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/video'), $filename);
    
            $videos->videos_url = $filename;
        }
       
        $videos->save(); 
        return redirect()->back()->with('success', 'Video Uploaded!');
    }

}
