<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Dashboard extends Controller
{
    public function index(){
          return view('admin.index');
    
    }



    public function services(){
        $services = DB::table('services')->orderBy('services_id','DESC')->get();
        return view('admin.service',compact('services'));
    
    }
    public function homepage(){
        $homepage = DB::table('homepage')->where('homepage_id',1)->first();
        return view('admin.homepage',compact('homepage'));
    } 


    public function videos(){
        $videos=DB::table('videos')->orderBy('videos_id','DESC')->get();
        return view('admin.videos',compact('videos'));
    }


    public function global(){
    
        $general_setting= DB::table('general_setting')->where('general_setting_id','1')->first();
        return view('admin.global',compact('general_setting'));
    } 

    public function membership(){
        $membership = DB::table('membership_forms')->orderBy('membership_forms_id','DESC')->get();
        return view('admin.membership_form',compact('membership'));
    }
    public function providers(){
        $provider = DB::table('provider')->orderBy('provider_id','DESC')->get();
        return view('admin.providers',compact('provider'));
    }
    public function get_form(Request $request, $id){
        $membership_forms = DB::table('membership_forms')->where('membership_forms_id', $id)->first();
        if ($membership_forms == null) {
            return response(['status' => 404, 'message' => 'Membership Form Not Found']);
        } else {
            $sf = \App\Models\Membership_form::find($id);
            if ($sf) {
                $sf->membership_forms_read_status = '1';
                $sf->save();
                
                $membership_forms = "
                <section class='section'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h5 class='card-title'>Membership Detail</h5>
                                        <div id='kf' class='row mb-3'>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Name:</strong></p>
                                                    <h5>{$membership_forms->membership_forms_name}</h5>
                                                </div>
                                                <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Email:</strong></p>
                                                    <h5>{$membership_forms->membership_forms_email}</h5>
                                                </div>
                                                <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Phone:</strong></p>
                                                    <h5>{$membership_forms->membership_forms_phone}</h5>
                                                </div>
                                                <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Address:</strong></p>
                                                    <h5>{$membership_forms->membership_forms_address}</h5>
                                                </div>
                                                <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Age:</strong></p>
                                                    <h5>{$membership_forms->membership_forms_age}</h5>
                                                </div>
                                                <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Years Played:</strong></p>
                                                    <h5>{$membership_forms->membership_forms_years_played}</h5>
                                                </div>
                                                <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Played For :</strong></p>
                                                    <h5>{$membership_forms->membership_forms_teams_played_for}</h5>
                                                </div>
                                                <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Family Member:</strong></p>
                                                    <h5>{$membership_forms->membership_forms_family_member}</h5>
                                                </div>
                                            </div>
                                            
                                        </div> 
                                  
                                        <div class='row mb-3'>
                                            <div class='col-sm-10'>
                                                <form method='POST' action='".url('admin/delete/membership', $membership_forms->membership_forms_id)."' onsubmit=\"return confirm('Are you sure you want to delete this membership form?');\">
                                                    ".csrf_field()."
                                                    ".method_field('DELETE')."
                                                    <input type='submit' value='Delete' class='btn btn-danger'>
                                                </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>";
            }
            return response(['status' => 200, 'data' => $membership_forms, 'read' => 1]);
        }
    }
    public function get_provider(Request $request, $id){
        $provider = DB::table('provider')->where('provider_id', $id)->first();
        if ($provider == null) {
            return response(['status' => 404, 'message' => 'Membership Form Not Found']);
        } else {
        
                $data = "
                <section class='section'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='card'>
                                <div class='card-body'>
                                    <h5 class='card-title'>Membership Detail</h5>
                                        <div id='kf' class='row mb-3'>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Name:</strong></p>
                                                    <h5>{$provider->provider_company_name}</h5>
                                                </div>
                                            </div>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Email:</strong></p>
                                                    <h5>{$provider->provider_email}</h5>
                                                </div>
                                            </div>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Phone:</strong></p>
                                                    <h5>{$provider->provider_phone}</h5>
                                                </div>
                                            </div>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Address:</strong></p>
                                                    <h5>{$provider->provider_address}</h5>
                                                </div>
                                            </div>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Fax:</strong></p>
                                                    <h5>{$provider->provider_fax}</h5>
                                                </div>
                                            </div>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>GM:</strong></p>
                                                    <h5>{$provider->provider_gm}</h5>
                                                </div>
                                            </div>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Logo :</strong></p>
                                                    <img class='img-fluid' src='" . url('storage/provider/' . $provider->provider_logo) . "' alt='Team Played For'>
                                                </div>
                                            </div>
                                            <div class='col-sm-12'>
                                                <div class='card_body_sh_text'>
                                                    <p><strong>Social Media:</strong></p>
                                                    <h5>{$provider->provider_social_media}</h5>
                                                </div>
                                            </div>
                                            
                                        </div> 
                                  
                                        <div class='row mb-3'>
                                            <div class='col-sm-10'>
                                                <form method='POST' action='".url('admin/delete/provider', $provider->provider_id)."' onsubmit=\"return confirm('Are you sure you want to delete this provider form?');\">
                                                    ".csrf_field()."
                                                    ".method_field('DELETE')."
                                                    <input type='submit' value='Delete' class='btn btn-danger'>
                                                </form>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>";
        return response(['status' => 200, 'data' => $data, 'read' => 1]);
        }
    }
    public function team_edit(Request $request,$id){

       $team=  DB::table('teams')->where('teams_id',$id)->first();

        $html = "
        <div class='modal-body'>
        <form action='" . url('admin/update-team/'.$team->teams_id) . "' method='post' enctype='multipart/form-data'>
          " . csrf_field() . "
           " . method_field('PUT') . "

          <section class='section'>
            <div class='row'>
              <div class='col-lg-12'>
          
            <div class='card'>
              <div class='card-body'>
                <h5 class='card-title'>Team</h5>
         
                <div id='kf' class='row mb-3'>
                  <label for='inputText' class='col-sm-12 col-form-label'>Team Name</label>
                  <div class='col-sm-12'>
                    <input type='text' class='form-control' name='teams_name' id='inputText' value='".$team->teams_name."' placeholder='Enter Team Name' required>
                  </div>
                </div> 

                <div id='kf' class='row mb-3'>
                  <label for='teams_img' class='col-sm-12 col-form-label'>Team Img</label>
                  <div class='col-sm-12'>
                    <input type='file' class='form-control' name='teams_img' id='teams_img'>
                  </div>
                </div> 
                <div class='row mb-3'>
                  <div class='col-sm-10'>
                      <input type='submit' value='Update Team' class='btn btn-success'>
                  </div>
                </div>
                </form>
              </div>
            </div>
              </div>
            </div>
          </section>
          </div>";
        return response(['status' => 200, 'data' => $html]);
    }

    public function services_edit(Request $request,$id){

        $services=  DB::table('services')->where('services_id',$id)->first();
 
         $html = "
         <div class='modal-body'>
         <form action='" . url('admin/update-service/'.$services->services_id) . "' method='post' enctype='multipart/form-data'>
           " . csrf_field() . "
            " . method_field('PUT') . "
 
           <section class='section'>
             <div class='row'>
               <div class='col-lg-12'>
           
             <div class='card'>
               <div class='card-body'>
                 <h5 class='card-title'>Team</h5>
          
                 <div id='kf' class='row mb-3'>
                   <label for='inputText' class='col-sm-12 col-form-label'>Team Name</label>
                   <div class='col-sm-12'>
                     <input type='text' class='form-control' name='services_name' id='inputText' value='".$services->services_name."' placeholder='Enter Service Name' required>
                   </div>
                 </div> 
 
                 <div id='kf' class='row mb-3'>
                   <label for='teams_img' class='col-sm-12 col-form-label'>Team Img</label>
                   <div class='col-sm-12'>
                    <div class='input-images'></div>
                   </div>
                 </div> 
                 <div class='row mb-3'>
                   <div class='col-sm-10'>
                       <input type='submit' value='Update Team' class='btn btn-success'>
                   </div>
                 </div>
                 </form>
               </div>
             </div>
               </div>
             </div>
           </section>
           </div>";
         return response(['status' => 200, 'data' => $html]);
     }
    public function founder_page(){
        $founder = DB::table('founder_page')->where('founder_page_id',1)->first();
        return view('admin.founder_page',compact('founder'));
    }

    public function profile(){
        return view('admin.profile');
    }

    public function edit_profile(Request $request){
            $user = User::find(Auth::id());
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->password != null){
                $user->password = Hash::make($request->password);
            }
         
            $user->save();
            return redirect()->back()->with('success','Profile Updated Successfully');
        }

    public function delete(Request $request,$path,$id){
        if($path === 'teams'){
            DB::table('teams')->where('teams_id',$id)->delete();
        }
        if($path === 'services'){
            DB::table('services')->where('services_id',$id)->delete();

        }

        if($path === 'videos'){
            DB::table('videos')->where('videos_id',$id)->delete();

        }

        if($path === 'membership'){
            DB::table('membership_forms')->where('membership_forms_id',$id)->delete();

        }
        if($path === 'provider'){
            DB::table('provider')->where('provider_id',$id)->delete();

        }
        return redirect()->back()->with('success','Deleted');

    }
    public function cache(){
        Cache::clear();
        return redirect()->back()->with('success','Cache Cleared Successfully');

    }
}
