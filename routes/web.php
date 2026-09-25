<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Login;
use App\Http\Controllers\Admin\Dashboard;
use App\Http\Controllers\Admin\Listings;
use App\Http\Controllers\Admin\Home;


use App\Http\Controllers\Front\Main;

use App\Http\Controllers\Front\Ecommerce;


Route::post('/auth',[Login::class,'authenticate']);
Route::get('/logout',function(){
    session()->flush();
    return redirect('/');
});


//AMDIN POST END 
Route::get('/admin/login',function(){
    return view('admin.login');
})->name('login');

Route::get('/admin',function(){
    return redirect('admin/dashboard');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'index']);
    Route::get('/listings', [Listings::class, 'index']);
    Route::get('/listings/create', [Listings::class, 'create']);
    Route::get('/listings/{id}/edit', [Listings::class, 'edit']);
    Route::put('/update-listing/{id}', [Listings::class, 'update']);
    Route::delete('/delete-listing/{id}', [Listings::class, 'destroy']);
    Route::get('/teams', [Dashboard::class, 'teams']);
    Route::get('/services', [Dashboard::class, 'services']);
    Route::get('/videos', [Dashboard::class, 'videos']);
    Route::get('/memberships', [Dashboard::class, 'membership']);
    Route::get('/providers', [Dashboard::class, 'providers']);
    Route::get('get-form/{id}',[Dashboard::class,'get_form']);
    Route::get('get-provider/{id}',[Dashboard::class,'get_provider']);
    Route::get('global-setting',[Dashboard::class,'global']);
    Route::get('cache-clear',[Dashboard::class,'cache']);
    Route::get('get-team/{id}',[Dashboard::class,'team_edit']);
    Route::get('get-service/{id}',[Dashboard::class,'services_edit']);

    // Registered members
    Route::get('/members', [\App\Http\Controllers\Admin\Customers::class, 'index'])->name('admin.members.index');
    Route::get('/members/{id}', [\App\Http\Controllers\Admin\Customers::class, 'show'])->name('admin.members.show');

    // Admin Orders & Calendar
    Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrders::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/calendar', [\App\Http\Controllers\Admin\AdminOrders::class, 'calendar'])->name('admin.orders.calendar');
    Route::get('/orders/calendar-events', [\App\Http\Controllers\Admin\AdminOrders::class, 'calendarEvents'])->name('admin.orders.calendar-events');
    // Registered before /orders/{id} so "create" is not read as an order id.
    Route::get('/orders/create', [\App\Http\Controllers\Admin\AdminOrders::class, 'create'])->name('admin.orders.create');
    Route::post('/orders', [\App\Http\Controllers\Admin\AdminOrders::class, 'store'])->name('admin.orders.store');
    Route::get('/orders/room-availability', [\App\Http\Controllers\Admin\AdminOrders::class, 'availability'])->name('admin.orders.availability');
    Route::get('/orders/{id}', [\App\Http\Controllers\Admin\AdminOrders::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{id}/update-dates', [\App\Http\Controllers\Admin\AdminOrders::class, 'updateDates'])->name('admin.orders.update-dates');
    Route::post('/orders/{id}/cancel', [\App\Http\Controllers\Admin\AdminOrders::class, 'cancel'])->name('admin.orders.cancel');
    Route::post('/orders/{id}/mark-checked-in', [\App\Http\Controllers\Admin\AdminOrders::class, 'markCheckedIn'])->name('admin.orders.mark-checked-in');
    Route::post('/orders/{id}/mark-checked-out', [\App\Http\Controllers\Admin\AdminOrders::class, 'markCheckedOut'])->name('admin.orders.mark-checked-out');
    Route::post('/orders/{id}/send-reminder', [\App\Http\Controllers\Admin\AdminOrders::class, 'sendReminder'])->name('admin.orders.send-reminder');
    Route::get('/feedbacks', [\App\Http\Controllers\Admin\AdminOrders::class, 'feedbacks'])->name('admin.feedbacks.index');

    // Email template gallery (read-only previews)
    Route::get('/email-templates', [\App\Http\Controllers\Admin\EmailTemplates::class, 'index'])->name('admin.emails.index');
    Route::get('/email-templates/{key}', [\App\Http\Controllers\Admin\EmailTemplates::class, 'show'])->name('admin.emails.show');
    Route::get('/email-templates/{key}/render', [\App\Http\Controllers\Admin\EmailTemplates::class, 'render'])->name('admin.emails.render');

    
    Route::get('/founder-page', [Dashboard::class, 'founder_page']);

    Route::get('profile/',[Dashboard::class,'profile']);
    //POST METHOD
    Route::post('post-listings',[Listings::class,'Store']);
    Route::post('edit-founderpage/{id}',[Home::class,'store_founder']);
    Route::post('/upload-video', [Home::class, 'video']);
    Route::post('/global-settings/{id}', [Dashboard::class, 'update_global_setting'])->name('admin.global_setting.update');
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
Route::get('/about', [Main::class, 'about']);
Route::get('/booking', [Main::class,'booking']);
Route::get('/room', [Main::class,'room']);
Route::get('/gallery', [Main::class,'gallery']);
Route::get('/checkout', [Main::class,'checkout']);
Route::get('/memberships', [Main::class,'memberships']);
Route::get('/contact', [Main::class,'contact']);
Route::get('/cookie-privacy', [Main::class,'cookie_privacy']);
Route::get('/privacy', [Main::class,'privacy']);
Route::get('/term-condition', [Main::class,'term_condition']);

use App\Http\Controllers\Front\CustomerAuth;
Route::get('/customer/login', [CustomerAuth::class, 'showLogin'])->name('customer.login');
Route::post('/customer/login', [CustomerAuth::class, 'login'])->name('customer.login.submit');
Route::get('/customer/register', [CustomerAuth::class, 'showRegister'])->name('customer.register');
Route::post('/customer/register', [CustomerAuth::class, 'register'])->name('customer.register.submit');
Route::get('/customer/logout', [CustomerAuth::class, 'logout'])->name('customer.logout');
Route::middleware('auth:customer')->group(function () {
    Route::get('/my-account', [CustomerAuth::class, 'dashboard'])->name('customer.dashboard');
    Route::post('/customer/profile-update', [CustomerAuth::class, 'updateProfile'])->name('customer.profile.update');
    Route::post('/customer/password-update', [CustomerAuth::class, 'updatePassword'])->name('customer.password.update');
    Route::get('/my-account/booking/{order_number}', [CustomerAuth::class, 'booking'])->name('customer.booking.show');
    Route::post('/my-account/booking/{order_number}/cancel', [CustomerAuth::class, 'cancelBooking'])->name('customer.booking.cancel');
    Route::post('/my-account/booking/{order_number}/reschedule', [CustomerAuth::class, 'rescheduleBooking'])->name('customer.booking.reschedule');
});


Route::get('room-availability',[Ecommerce::class,'availability'])->name('room.availability');
Route::get('room-availability/calendar',[Ecommerce::class,'calendarAvailability'])->name('room.availability.calendar');
Route::post('booking/{id}',[Ecommerce::class,'booking_cart'])->name('booking_cart');
Route::delete('cart/{id}',[Ecommerce::class,'remove_cart'])->name('remove_cart');
Route::delete('cart-listing/{id}',[Ecommerce::class,'remove_cart_listing'])->name('remove_cart_listing');
Route::delete('cart/listing/{id}',[Ecommerce::class,'remove_cart_listing']);

// Checkout & Payment Routes
Route::post('/create-payment-intent', [Ecommerce::class, 'createPaymentIntent'])->name('checkout.create-payment-intent');
Route::post('/apply-loyalty', [Ecommerce::class, 'applyLoyalty'])->name('checkout.apply-loyalty');
Route::post('/process-payment', [Ecommerce::class, 'processPayment'])->name('checkout.process-payment');
Route::get('/checkout/success/{order_number}', [Ecommerce::class, 'orderSuccess'])->name('checkout.success');
Route::post('post_checkout',[Ecommerce::class,'checkout'])->name('store_checkout');

// Guest Feedback Routes
use App\Http\Controllers\Front\FeedbackController;
Route::get('feedback/{order_number}', [FeedbackController::class, 'show'])->name('feedback.show');
Route::post('feedback/{order_number}', [FeedbackController::class, 'store'])->name('feedback.store');

//Front End