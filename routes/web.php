<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Listings;


use App\Http\Controllers\Front\Main;



Route::post('/auth',[Login::class,'authenticate']);
Route::get('/logout',function(){
    session()->flush();
    return redirect('/');
});


//AMDIN POST END 
Route::get('/admin/login',function(){
    return view('admin.login');
})->name('admin/login');

Route::get('/admin',function(){
    return redirect('admin/dashboard');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index']);
    Route::get('/listings', [Dashboard::class, 'listing']);
    Route::get('/teams', [Dashboard::class, 'teams']);
    Route::get('/services', [Dashboard::class, 'services']);
    Route::get('/videos', [Dashboard::class, 'videos']);
    Route::get('/about', [Dashboard::class, 'about']);
    Route::get('/memberships', [Dashboard::class, 'membership']);
    Route::get('/providers', [Dashboard::class, 'providers']);
    Route::get('get-form/{id}',[Dashboard::class,'get_form']);
    Route::get('get-provider/{id}',[Dashboard::class,'get_provider']);
    Route::get('global-setting',[Dashboard::class,'global']);
    Route::get('cache-clear',[Dashboard::class,'cache']);
    Route::get('get-team/{id}',[Dashboard::class,'team_edit']);
    Route::get('get-service/{id}',[Dashboard::class,'services_edit']);

    
    Route::get('/founder-page', [Dashboard::class, 'founder_page']);

    Route::get('profile/',[Dashboard::class,'profile']);
    //POST METHOD
    Route::post('post-listings',[Listings::class,'Store']);
    Route::post('edit-founderpage/{id}',[Home::class,'store_founder']);
    Route::post('/upload-video', [Home::class, 'video']);
    Route::post('/global-settings/{id}',[Home::class,'global_setting']);
    Route::post('post-team',[Home::class,'post_team']);
    Route::put('update-team/{id}',[Home::class,'update_team']);
    Route::post('post-service',[Home::class,'post_service']);
    Route::put('update-service/{id}',[Home::class,'update_service']);
    Route::post('edit-profile',[Dashboard::class,'edit_profile']);
    Route::delete('delete/{path}/{id}',[Dashboard::class,'delete']);

});

//Admin End
//Front Start 

Route::get('/', [Main::class,'index']);
Route::get('/booking', [Main::class,'booking']);
Route::get('/room', [Main::class,'booking']);
Route::get('/gallery', [Main::class,'gallery']);


//Front End