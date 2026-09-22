@include('front.inc.header')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
<script src="https://js.stripe.com/v3/"></script>

<style>
/* Modern Luxury Checkout Design System */
.checkout_wrapper {
    padding: 50px 0 80px !important;
    background: #f8fafc !important;
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}

.checkout_form_wrap, .checkout_review_cart_wrap {
    background: #ffffff !important;
    border-radius: 20px !important;
    box-shadow: 0 10px 35px rgba(0, 0, 0, 0.04) !important;
    border: 1px solid #e2e8f0 !important;
    padding: 32px !important;
    margin-bottom: 30px !important;
}

.checkout_form_ttext .heading, .checkout_review_ttext .heading {
    font-size: 26px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    letter-spacing: -0.5px !important;
    margin-bottom: 6px !important;
}
.checkout_form_ttext .desc, .checkout_review_ttext .desc {
    color: #64748b !important;
    font-size: 14px !important;
    margin-bottom: 24px !important;
}

/* Auth Segmented Tabs */
.check_main_btns {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 6px !important;
    background: #f1f5f9 !important;
    padding: 5px !important;
    border-radius: 14px !important;
    margin-bottom: 28px !important;
    border: 1px solid #e2e8f0 !important;
}
.check_main_btns .auth-tab-btn {
    flex: 1 !important;
    min-width: 110px !important;
    height: 44px !important;
    padding: 0 16px !important;
    border-radius: 10px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    letter-spacing: 0.3px !important;
    border: none !important;
    background: transparent !important;
    color: #64748b !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    white-space: nowrap !important;
    transition: all 0.25s ease !important;
    cursor: pointer !important;
}
.check_main_btns .auth-tab-btn:hover {
    color: #184E77 !important;
    background: rgba(24, 78, 119, 0.06) !important;
}
.check_main_btns .auth-tab-btn.active {
    background: #184E77 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(24, 78, 119, 0.25) !important;
}
.check_main_btns .auth-tab-btn.active i {
    color: #ffffff !important;
}

/* Form Group & Input Styling */
.form_field_wrapper {
    margin-bottom: 20px !important;
}
.form_field_label {
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #1e293b !important;
    margin-bottom: 8px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}
.req_star {
    color: #ef4444 !important;
    font-weight: 800 !important;
    margin-left: 2px !important;
}
.badge_optional {
    background: #f1f5f9 !important;
    color: #64748b !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    padding: 2px 8px !important;
    border-radius: 12px !important;
    text-transform: none !important;
}

/* Input Icon Integration */
.input_with_icon {
    position: relative !important;
    display: flex !important;
    align-items: center !important;
}
.input_with_icon i.field_icon {
    position: absolute !important;
    left: 16px !important;
    color: #94a3b8 !important;
    font-size: 15px !important;
    pointer-events: none !important;
    transition: all 0.2s ease !important;
    z-index: 2 !important;
}
.input_with_icon input, .input_with_icon select {
    width: 100% !important;
    height: 48px !important;
    padding: 10px 16px 10px 46px !important;
    border-radius: 12px !important;
    border: 1.5px solid #cbd5e1 !important;
    background: #f8fafc !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    color: #0f172a !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    transition: all 0.25s ease !important;
    outline: none !important;
}
.input_no_icon input, .input_no_icon select {
    padding-left: 16px !important;
}
.input_with_icon input:focus, .input_with_icon select:focus {
    background: #ffffff !important;
    border-color: #184E77 !important;
    box-shadow: 0 0 0 4px rgba(24, 78, 119, 0.12) !important;
}
.input_with_icon input:focus ~ i.field_icon, .input_with_icon select:focus ~ i.field_icon {
    color: #184E77 !important;
}

/* Custom Drag/Click File Dropzone */
.file_dropzone {
    border: 2px dashed #cbd5e1 !important;
    background: #f8fafc !important;
    border-radius: 14px !important;
    padding: 20px 24px !important;
    text-align: center !important;
    cursor: pointer !important;
    transition: all 0.25s ease !important;
    position: relative !important;
}
.file_dropzone:hover {
    background: #ffffff !important;
    border-color: #184E77 !important;
    box-shadow: 0 4px 15px rgba(24, 78, 119, 0.08) !important;
}
.file_dropzone input[type="file"] {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    opacity: 0 !important;
    cursor: pointer !important;
    z-index: 5 !important;
}
.file_dropzone_icon {
    font-size: 28px !important;
    color: #184E77 !important;
    margin-bottom: 8px !important;
}
.file_dropzone_title {
    font-size: 14px !important;
    font-weight: 700 !important;
    color: #1e293b !important;
    margin: 0 !important;
}
.file_dropzone_sub {
    font-size: 12px !important;
    color: #64748b !important;
    margin-top: 3px !important;
}
.file_selected_name {
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #059669 !important;
    margin-top: 8px !important;
    display: none;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

/* Payment Card Container */
.payment_card_wrapper {
    background: #f8fafc !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 14px !important;
    padding: 18px 20px !important;
    transition: all 0.25s ease !important;
}
.payment_card_header {
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #0f172a !important;
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    margin-bottom: 12px !important;
}
.stripe_card_element {
    padding: 14px 16px !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 12px !important;
    background: #ffffff !important;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03) !important;
    transition: all 0.25s ease !important;
}
.stripe_card_element:focus-within {
    border-color: #184E77 !important;
    box-shadow: 0 0 0 4px rgba(24, 78, 119, 0.12) !important;
}

/* Review Cart Items & Luxury Pricing Typography */
.cart_item_card {
    background: #ffffff !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 14px !important;
    padding: 16px !important;
    margin-bottom: 16px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02) !important;
}
.cart_item_dates_box {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 10px !important;
    padding: 10px 14px !important;
    margin-top: 12px !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
}

/* Pricing Typography Overhaul */
.checkout_review_text p, .checkout_review_text span, .cart_item_card p, .cart_item_dates_box p, #summary-grand-total {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    font-variant-numeric: tabular-nums !important;
    letter-spacing: -0.2px !important;
}
.checkout_review_text p {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    font-size: 14px !important;
    color: #475569 !important;
    margin-bottom: 10px !important;
}
.checkout_review_text p span {
    font-weight: 700 !important;
    color: #0f172a !important;
}
.checkout_review_text p.darkk {
    font-size: 18px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    border-top: 2px dashed #e2e8f0 !important;
    padding-top: 14px !important;
    margin-top: 14px !important;
}
.checkout_review_text p.darkk span#summary-grand-total {
    color: #184E77 !important;
    font-size: 22px !important;
    font-weight: 800 !important;
}

/* Terms Box in Summary Column */
.checkbox-wrapper-46 {
    transition: all 0.25s ease !important;
}
.checkbox-wrapper-46 .cbx span:first-child {
    border-radius: 6px !important;
}
</style>

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">CHECKOUT</h6>
        </div> 
    </div>
</section>

<section class="checkout_wrapper">
    <div class="container">
        <div class="checkout_m_wrap">

            <!-- Main Checkout Form wrapping both Left & Right columns -->
            <form action="{{ route('checkout.process-payment') }}" method="post" id="payment-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_intent" id="payment_intent">

                <div class="row justify-content-between">
                    <!-- Left Side: Guest Details Form -->
                    <div class="col-12 col-lg-7 col-xl-7">
                        <div class="checkout_form_wrap">
                            <div class="checkout_form_ttext">
                                <h6 class="heading">Guest Information</h6>
                                <p class="desc">Please complete your guest details below to confirm your reservation.</p>
                            </div>

                            @if(session('error'))
                                <div class="alert alert-danger mb-4" style="border-radius:12px; font-weight:600;"><i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}</div>
                            @endif

                            @if(!Auth::guard('customer')->check())
                                <div class="check_main_btns mb-4">
                                    <button type="button" class="auth-tab-btn active" id="btn-guest-tab"><i class="fa-solid fa-user"></i> Guest Checkout</button>
                                    <button type="button" class="auth-tab-btn" id="btn-login-tab"><i class="fa-solid fa-arrow-right-to-bracket"></i> Sign in</button>
                                    <button type="button" class="auth-tab-btn" id="btn-register-tab"><i class="fa-solid fa-user-plus"></i> Create Account</button>
                                </div>
                            @else
                                <div class="alert alert-info d-flex justify-content-between align-items-center mb-4" style="border-radius:12px; background:#f0f9ff; border:1px solid #bae6fd; color:#0369a1;">
                                    <div>
                                        <i class="fa-solid fa-user-check me-2" style="font-size:16px;"></i> Logged in as <strong>{{ Auth::guard('customer')->user()->first_name }} {{ Auth::guard('customer')->user()->last_name }}</strong> ({{ Auth::guard('customer')->user()->email }})
                                    </div>
                                    <a href="{{ route('customer.logout') }}" class="btn btn-sm btn-outline-danger" style="border-radius:20px; font-size:12px; font-weight:700;">Logout</a>
                                </div>
                            @endif

                            <div class="checkout_box" id="checkout-fields-box">
                                
                                <!-- Booking Type Field -->
                                <div class="form_field_wrapper">
                                    <div class="form_field_label">Booking Type:</div>
                                    <div class="input_with_icon">
                                        <select name="booking_type">
                                            <option value="Personal">Personal Booking</option>
                                            <option value="Business">Business Booking</option>
                                        </select>
                                        <i class="fa-solid fa-briefcase field_icon"></i>
                                    </div>
                                </div>

                                @if(!Auth::guard('customer')->check())
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <div class="form_field_wrapper">
                                                <div class="form_field_label">First Name <span class="req_star">*</span></div>
                                                <div class="input_with_icon">
                                                    <input type="text" name="first_name" id="guest_first_name" placeholder="First Name" required>
                                                    <i class="fa-solid fa-user field_icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="form_field_wrapper">
                                                <div class="form_field_label">Last Name <span class="req_star">*</span></div>
                                                <div class="input_with_icon">
                                                    <input type="text" name="last_name" id="guest_last_name" placeholder="Last Name" required>
                                                    <i class="fa-solid fa-user field_icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form_field_wrapper">
                                        <div class="form_field_label">Email Address <span class="req_star">*</span></div>
                                        <div class="input_with_icon">
                                            <input type="email" name="email" id="guest_email" placeholder="name@example.com" required>
                                            <i class="fa-solid fa-envelope field_icon"></i>
                                        </div>
                                    </div>

                                    <div class="form_field_wrapper">
                                        <div class="form_field_label">Phone Number <span class="req_star">*</span></div>
                                        <div class="input_with_icon">
                                            <input type="text" name="phone" id="guest_phone" placeholder="Phone Number" required>
                                            <i class="fa-solid fa-phone field_icon"></i>
                                        </div>
                                    </div>
                                @endif

                                <div class="form_field_wrapper">
                                    <div class="form_field_label">
                                        Street Address <span class="badge_optional">Optional</span>
                                    </div>
                                    <div class="input_with_icon">
                                        <input type="text" name="address" id="guest_address" placeholder="123 Main Street, Suite #">
                                        <i class="fa-solid fa-location-dot field_icon"></i>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form_field_wrapper">
                                            <div class="form_field_label">
                                                City <span class="badge_optional">Optional</span>
                                            </div>
                                            <div class="input_with_icon">
                                                <input type="text" name="city" id="guest_city" placeholder="City">
                                                <i class="fa-solid fa-city field_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form_field_wrapper">
                                            <div class="form_field_label">
                                                Province / State <span class="badge_optional">Optional</span>
                                            </div>
                                            <div class="input_with_icon">
                                                <input type="text" name="province" id="guest_province" placeholder="Province / State">
                                                <i class="fa-solid fa-map field_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form_field_wrapper">
                                            <div class="form_field_label">
                                                PIN / Postal Code <span class="badge_optional">Optional</span>
                                            </div>
                                            <div class="input_with_icon">
                                                <input type="text" name="postal_code" id="guest_postal_code" placeholder="Postal Code">
                                                <i class="fa-solid fa-hashtag field_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form_field_wrapper">
                                            <div class="form_field_label">
                                                Vehicle Number <span class="badge_optional">Optional</span>
                                            </div>
                                            <div class="input_with_icon">
                                                <input type="text" name="vehicle_number" id="guest_vehicle_number" placeholder="License Plate / Vehicle #">
                                                <i class="fa-solid fa-car field_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Custom Required ID Proof Dropzone -->
                                <div class="form_field_wrapper">
                                    <div class="form_field_label">
                                        Upload Customer ID Proof <span class="req_star">*</span>
                                    </div>
                                    <div class="file_dropzone" id="id-dropzone">
                                        <input type="file" name="id_proof" id="guest_id_proof" accept="image/*,.pdf" required>
                                        <i class="fa-solid fa-cloud-arrow-up file_dropzone_icon"></i>
                                        <p class="file_dropzone_title">Click or drag file here to upload ID Proof</p>
                                        <p class="file_dropzone_hint">Supports Images & Documents (JPG, PNG, PDF max 5MB)</p>
                                        <div class="file_selected_name" id="file-selected-name">
                                            <i class="fa-solid fa-circle-check"></i> <span id="file-name-text"></span>
                                        </div>
                                    </div>
                                    <div id="id-proof-error-msg" class="text-danger small mt-2 fw-bold d-none" role="alert"></div>
                                </div>

                            </div>

                            <!-- Inline Login Form -->
                            <div class="signin_box d-none" id="inline-login-box">
                                <h6 class="mb-3" style="font-weight:800; color:#0f172a;">Sign In to Your Account</h6>
                                <div id="login-error-msg" class="alert alert-danger d-none" style="border-radius:10px;"></div>
                                
                                <div class="form_field_wrapper">
                                    <div class="form_field_label">Email Address <span class="req_star">*</span></div>
                                    <div class="input_with_icon">
                                        <input type="email" id="login_email" placeholder="Enter email address">
                                        <i class="fa-solid fa-envelope field_icon"></i>
                                    </div>
                                </div>

                                <div class="form_field_wrapper">
                                    <div class="form_field_label">Password <span class="req_star">*</span></div>
                                    <div class="input_with_icon">
                                        <input type="password" id="login_password" placeholder="••••••••••••">
                                        <i class="fa-solid fa-lock field_icon"></i>
                                    </div>
                                </div>

                                <div class="signin_box_btn1 mt-4">
                                    <button type="button" class="common_dark_btn w-100" id="btn-do-login" style="border-radius:30px; padding:12px;">Login & Continue <i class="fa-solid fa-circle-chevron-right"></i></button>
                                </div>
                            </div>

                            <!-- Inline Registration Form -->
                            <div class="signup_box d-none" id="inline-register-box">
                                <h6 class="mb-3" style="font-weight:800; color:#0f172a;">Create New Customer Account</h6>
                                <div id="register-error-msg" class="alert alert-danger d-none" style="border-radius:10px;"></div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form_field_wrapper">
                                            <div class="form_field_label">First Name <span class="req_star">*</span></div>
                                            <div class="input_with_icon">
                                                <input type="text" id="reg_first_name" placeholder="First name">
                                                <i class="fa-solid fa-user field_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form_field_wrapper">
                                            <div class="form_field_label">Last Name <span class="req_star">*</span></div>
                                            <div class="input_with_icon">
                                                <input type="text" id="reg_last_name" placeholder="Last name">
                                                <i class="fa-solid fa-user field_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form_field_wrapper">
                                            <div class="form_field_label">Email Address <span class="req_star">*</span></div>
                                            <div class="input_with_icon">
                                                <input type="email" id="reg_email" placeholder="Email address">
                                                <i class="fa-solid fa-envelope field_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form_field_wrapper">
                                            <div class="form_field_label">Password <span class="req_star">*</span></div>
                                            <div class="input_with_icon">
                                                <input type="password" id="reg_password" placeholder="Minimum 8 characters">
                                                <i class="fa-solid fa-lock field_icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <div class="signin_box_btn1">
                                            <button type="button" class="common_dark_btn w-100" id="btn-do-register" style="border-radius:30px; padding:12px;">Create Account & Continue <i class="fa-solid fa-circle-chevron-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Side: Order Summary, Payment Card, Terms & Pay Button -->
                    <div class="col-12 col-lg-5 col-xl-5">
                        <div class="checkout_review_cart_wrap">
                            <div class="checkout_review_ttext">
                                <h6 class="heading">Review Your Cart</h6>
                                <p class="desc" style="font-size:13px; color:#64748b; margin-top:2px;">Check-in starts at 2:00 PM | Check-out at 11:00 AM</p>
                            </div>

                            <!-- Cart Items List -->
                            <div class="checkout_review_product_wrap" style="margin-top:15px;">
                                @php
                                    $grandSubtotal = 0;
                                    use Carbon\Carbon;
                                @endphp
                                
                                @foreach($checkout as $cart)
                                @php
                                    $checkIn = Carbon::parse($cart->cart_check_in);
                                    $checkOut = Carbon::parse($cart->cart_check_out);
                                    $nights = $checkIn->diffInDays($checkOut);
                                    $nights = $nights > 0 ? $nights : 1;
                                    
                                    $itemTotal = $cart->listings_price * $cart->cart_rooms * $nights;
                                    $grandSubtotal += $itemTotal;
                                    
                                    $img = json_decode($cart->listings_img);
                                @endphp
                                <div class="cart_item_card">
                                    <div style="display:flex; justify-content:space-between; width:100%; align-items:flex-start; gap:12px;">
                                        <div style="display:flex; gap:14px;">
                                            <div class="checkout_review_pro_img" style="width:75px; height:75px; flex-shrink:0;">
                                                <img src="{{ asset('storage/listing/'.$img[0]) }}" class="img-fluid" alt="{{ $cart->listings_name }}" style="border-radius:10px; width:100%; height:100%; object-fit:cover;">
                                            </div>
                                            <div class="checkout_review_pro_text">
                                                <h5 class="heading" style="margin-bottom:4px; font-size:16px; font-weight:800; color:#0f172a;">{{ $cart->listings_name }}</h5>
                                                <p class="desc" style="font-size:12px; color:#475569; margin-bottom:2px;">
                                                    <strong>Rooms:</strong> {{ $cart->cart_rooms }} &nbsp;|&nbsp; 
                                                    <strong>Pets:</strong> {{ $cart->cart_pets }} &nbsp;|&nbsp; 
                                                    <strong>Laundry:</strong> {{ $cart->cart_laundry }} @if(!empty($cart->cart_laundry_qty)) ({{ $cart->cart_laundry_qty }} loads) @endif
                                                </p>
                                                <p class="desc" style="font-size:12px; font-weight:600; color:#64748b;">{{ $currency }} {{ number_format($cart->listings_price, 2) }} / night per room</p>
                                            </div>
                                        </div>
                                        <button type="button" class="remove-item-btn" data-id="{{ $cart->cart_id }}" style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:15px; padding:4px;" title="Remove Room">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="cart_item_dates_box">
                                        <div>
                                            <p style="margin:0; font-size:12px; color:#475569;"><strong>Check in:</strong> {{ $checkIn->format('M d, Y') }}</p>
                                            <p style="margin:0; font-size:12px; color:#475569;"><strong>Check out:</strong> {{ $checkOut->format('M d, Y') }}</p>
                                            <p style="margin:2px 0 0; font-size:12px; font-weight:700; color:#184E77;"><i class="fa-solid fa-moon me-1"></i> {{ $nights }} Night{{ $nights > 1 ? 's' : '' }}</p>
                                        </div>
                                        <div style="text-align:right;">
                                            <p style="margin:0; font-size:11px; color:#64748b; font-weight:600;">Subtotal</p>
                                            <p style="margin:0; font-size:17px; font-weight:800; color:#184E77;">{{ $currency }} {{ number_format($itemTotal, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Pricing Totals & Loyalty -->
                            <div class="checkout_review_cart_price" style="position: relative; margin-top:20px;">
                                <!-- Loyalty Loader Overlay -->
                                <div id="loyalty-loader" style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.85); z-index:10; display:none; justify-content:center; align-items:center; border-radius:8px;">
                                    <div style="text-align:center;">
                                        <i class="fa-solid fa-spinner fa-spin" style="font-size:24px; color:#184E77;"></i>
                                        <p style="margin:8px 0 0; font-size:13px; color:#475569; font-weight:600;">Recalculating...</p>
                                    </div>
                                </div>

                                <div class="checkout_review_text">
                                    <p class="desc">Room Subtotal <span>{{ $currency }} {{ number_format($roomSubtotal ?? $subtotal, 2) }}</span></p>
                                    @if(($pet_fee_total ?? 0) > 0)
                                    <p class="desc">Pet Fee Total <span>{{ $currency }} {{ number_format($pet_fee_total, 2) }}</span></p>
                                    @endif
                                    @if(($laundry_fee_total ?? 0) > 0)
                                    <p class="desc">Laundry Fee Total <span>{{ $currency }} {{ number_format($laundry_fee_total, 2) }}</span></p>
                                    @endif
                                    <p class="desc">Subtotal <span>{{ $currency }} {{ number_format($subtotal, 2) }}</span></p>
                                    <p class="desc">{{ $general_setting->tax_label ?? 'Taxes & fees' }} ({{ $tax_rate }}%) <span>{{ $currency }} {{ number_format($tax, 2) }}</span></p>
                                    <p class="desc text-success d-none" id="loyalty-discount-row">Loyalty Discount <span id="loyalty-discount-amount">-{{ $currency }} 0.00</span></p>
                                    <p class="desc darkk">Grand Total <span id="summary-grand-total">{{ $currency }} {{ number_format($total, 2) }}</span></p>
                                </div>
                            </div>

                            <!-- Payment Card Details (Placed in Right Panel directly above Terms & Pay Button) -->
                            <div class="form_field_wrapper mt-4">
                                <div class="payment_card_wrapper">
                                    <div class="payment_card_header">
                                        <i class="fa-solid fa-lock text-success" style="font-size:16px;"></i> Payment Card Details <span class="req_star">*</span>
                                    </div>
                                    <div class="stripe_card_element">
                                        <div id="card-element"></div>
                                    </div>
                                    <div id="card-errors" class="text-danger small mt-2 fw-bold" role="alert"></div>
                                </div>
                            </div>

                            <!-- Loyalty Points Box (for logged in customers) -->
                            @if(Auth::guard('customer')->check())
                                @php
                                    $customer = Auth::guard('customer')->user();
                                    $redemptionRate = $general_setting->loyalty_points_redemption_rate ?? 0.10;
                                    $pointsValue = $customer->loyalty_points * $redemptionRate;
                                @endphp
                                <div class="loyalty_redeem_box p-3 mt-3 mb-3" style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:12px;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1 text-primary" style="font-weight:700;"><i class="fa-solid fa-coins me-1"></i> Loyalty Points Balance</h6>
                                            <p class="mb-0 text-muted small">You have <strong>{{ number_format($customer->loyalty_points, 0) }} points</strong> (Worth {{ $currency }} {{ number_format($pointsValue, 2) }})</p>
                                        </div>
                                        @if($customer->loyalty_points > 0)
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="apply_loyalty_points" style="cursor:pointer; transform: scale(1.3);">
                                                <label class="form-check-label fw-bold text-success ms-2" for="apply_loyalty_points">Redeem Points</label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Terms & Conditions Checkbox (Placed directly above SSL Security Badge & Pay Now Button) -->
                            <div class="checkbox-wrapper-46 mt-3 mb-3" id="terms-checkbox-wrapper" style="background:#f8fafc; border:1.5px solid #cbd5e1; border-radius:14px; padding:14px 16px;">
                                <input type="checkbox" id="cbx-46" class="inp-cbx" name="terms" required />
                                <label for="cbx-46" class="cbx" style="margin:0; font-size:13px; font-weight:600; color:#334155; line-height:1.4;">
                                    <span><svg viewBox="0 0 12 10" height="10px" width="12px"><polyline points="1.5 6 4.5 9 10.5 1"></polyline></svg></span>
                                    <span>Have read all terms & conditions, pets policy, privacy policy & cookie policy</span>
                                </label>
                            </div>

                            <!-- SSL Security Badge -->
                            <div class="checkout_review_ssl_text mb-3 text-center d-flex align-items-center justify-content-center gap-2" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:10px;">
                                <img src="{{ asset('assets/front/images/lock_img.png') }}" class="img-fluid" alt="" style="width:16px;">
                                <p class="desc mb-0" style="font-size:12px; color:#475569; font-weight:700;">Secure Checkout - Stripe SSL Encrypted</p>
                            </div>

                            <!-- Pay Now Button -->
                            <div class="checkout_review_cart_btn">
                                <button type="button" id="pay-button" class="common_dark_btn w-100" style="height:52px; font-size:16px; border-radius:30px; box-shadow:0 6px 20px rgba(24, 78, 119, 0.3);">PAY NOW <i class="fa-solid fa-circle-chevron-right ms-2"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            {{-- Hidden Forms for Remove Action --}}
            @foreach($checkout as $cart)
            <form id="remove-form-{{ $cart->cart_id }}" action="{{ route('remove_cart', $cart->cart_id) }}" method="POST" style="display:none;">
                @csrf
                @method('DELETE')
            </form>
            @endforeach

        </div>
    </div>
</section>

<!-- Global Checkout Processing Loader Overlay -->
<div id="global-processing-loader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.65); z-index: 999999; display: none; justify-content: center; align-items: center; flex-direction: column;">
    <div style="background: #ffffff; padding: 35px 45px; border-radius: 16px; text-align: center; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); max-width: 380px; width: 90%; animation: zoomIn 0.3s ease;">
        <i class="fa-solid fa-spinner fa-spin" style="font-size: 45px; color: #184E77; margin-bottom: 20px;"></i>
        <h5 style="margin: 0 0 10px; color: #1e293b; font-weight: 700; font-size: 20px; font-family: sans-serif;">Processing...</h5>
        <p style="margin: 0; color: #64748b; font-size: 14px; line-height: 1.5; font-family: sans-serif;" id="global-loader-text">Please wait while we process your request.</p>
    </div>
</div>

<style>
@keyframes zoomIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
</style>

@include('front.inc.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Terms Checkbox dynamic error clear
        const termsCheckbox = document.getElementById('cbx-46');
        const termsWrapper = document.getElementById('terms-checkbox-wrapper');

        if (termsCheckbox && termsWrapper) {
            termsCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    termsWrapper.style.borderColor = '#cbd5e1';
                    termsWrapper.style.background = '#f8fafc';
                    const errAlert = document.getElementById('terms-error-alert');
                    if (errAlert) errAlert.remove();
                }
            });
        }

        // File dropzone filename preview & clear error
        const fileInput = document.getElementById('guest_id_proof');
        const fileNameDisplay = document.getElementById('file-selected-name');
        const fileNameText = document.getElementById('file-name-text');
        const idDropzone = document.getElementById('id-dropzone');
        const idErrBox = document.getElementById('id-proof-error-msg');

        if(fileInput && fileNameDisplay && fileNameText) {
            fileInput.addEventListener('change', function() {
                if(this.files && this.files.length > 0) {
                    fileNameText.textContent = this.files[0].name;
                    fileNameDisplay.style.display = 'inline-flex';
                    if (idDropzone) {
                        idDropzone.style.borderColor = '#cbd5e1';
                        idDropzone.style.background = '#f8fafc';
                    }
                    if (idErrBox) idErrBox.classList.add('d-none');
                } else {
                    fileNameDisplay.style.display = 'none';
                }
            });
        }

        // Global loader logic
        const globalLoader = document.getElementById('global-processing-loader');
        const globalLoaderText = document.getElementById('global-loader-text');
        
        window.showGlobalLoader = function(text = 'Please wait while we process your request.') {
            if (globalLoader) {
                if (globalLoaderText) globalLoaderText.textContent = text;
                globalLoader.style.display = 'flex';
            }
        }
        
        window.hideGlobalLoader = function() {
            if (globalLoader) {
                globalLoader.style.display = 'none';
            }
        }

        // Tab switching logic for guest / login / register
        const btnGuestTab = document.getElementById('btn-guest-tab');
        const btnLoginTab = document.getElementById('btn-login-tab');
        const btnRegisterTab = document.getElementById('btn-register-tab');

        const checkoutBox = document.getElementById('checkout-fields-box');
        const inlineLoginBox = document.getElementById('inline-login-box');
        const inlineRegisterBox = document.getElementById('inline-register-box');

        if(btnGuestTab && btnLoginTab && btnRegisterTab) {
            btnGuestTab.addEventListener('click', function() {
                btnGuestTab.classList.add('active');
                btnLoginTab.classList.remove('active');
                btnRegisterTab.classList.remove('active');

                checkoutBox.classList.remove('d-none');
                inlineLoginBox.classList.add('d-none');
                inlineRegisterBox.classList.add('d-none');
            });
            btnLoginTab.addEventListener('click', function() {
                btnLoginTab.classList.add('active');
                btnGuestTab.classList.remove('active');
                btnRegisterTab.classList.remove('active');

                checkoutBox.classList.add('d-none');
                inlineLoginBox.classList.remove('d-none');
                inlineRegisterBox.classList.add('d-none');
            });
            btnRegisterTab.addEventListener('click', function() {
                btnRegisterTab.classList.add('active');
                btnGuestTab.classList.remove('active');
                btnLoginTab.classList.remove('active');

                checkoutBox.classList.add('d-none');
                inlineLoginBox.classList.add('d-none');
                inlineRegisterBox.classList.remove('d-none');
            });
        }

        // Handle Inline AJAX Login
        const btnDoLogin = document.getElementById('btn-do-login');
        if(btnDoLogin) {
            btnDoLogin.addEventListener('click', function() {
                const email = document.getElementById('login_email').value;
                const password = document.getElementById('login_password').value;
                const errorBox = document.getElementById('login-error-msg');

                if(!email || !password) {
                    errorBox.textContent = 'Please fill in all required fields.';
                    errorBox.classList.remove('d-none');
                    return;
                }
                
                showGlobalLoader('Logging you in...');
                
                fetch('{{ route("customer.login.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ email: email, password: password })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    } else {
                        hideGlobalLoader();
                        errorBox.textContent = data.message || 'Login failed.';
                        errorBox.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    hideGlobalLoader();
                    errorBox.textContent = 'Something went wrong. Please try again.';
                    errorBox.classList.remove('d-none');
                    console.error(err);
                });
            });
        }

        // Handle Inline AJAX Register
        const btnDoRegister = document.getElementById('btn-do-register');
        if(btnDoRegister) {
            btnDoRegister.addEventListener('click', function() {
                const firstName = document.getElementById('reg_first_name').value;
                const lastName = document.getElementById('reg_last_name').value;
                const email = document.getElementById('reg_email').value;
                const password = document.getElementById('reg_password').value;
                const errorBox = document.getElementById('register-error-msg');

                if(!firstName || !lastName || !email || !password) {
                    errorBox.textContent = 'Please fill in all required fields.';
                    errorBox.classList.remove('d-none');
                    return;
                }

                showGlobalLoader('Creating your account...');

                fetch('{{ route("customer.register.submit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        first_name: firstName,
                        last_name: lastName,
                        email: email,
                        password: password
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    } else {
                        hideGlobalLoader();
                        let msg = 'Registration failed.';
                        if(data.errors) {
                            msg = Object.values(data.errors).flat().join(' ');
                        }
                        errorBox.textContent = msg;
                        errorBox.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    hideGlobalLoader();
                    errorBox.textContent = 'Something went wrong. Please try again.';
                    errorBox.classList.remove('d-none');
                    console.error(err);
                });
            });
        }

        // Item Removal logic
        document.querySelectorAll('.remove-item-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if(confirm('Are you sure you want to remove this room from your cart?')) {
                    document.getElementById('remove-form-' + this.dataset.id).submit();
                }
            });
        });

        // STRIPE INTEGRATION
        const stripeKey = '{{ config("services.stripe.key") ?: env("STRIPE_KEY") }}';
        const stripe = Stripe(stripeKey);
        const elements = stripe.elements();
        
        const style = {
            base: {
                color: '#0f172a',
                fontFamily: '"Plus Jakarta Sans", -apple-system, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '15px',
                '::placeholder': {
                    color: '#94a3b8'
                }
            },
            invalid: {
                color: '#ef4444',
                iconColor: '#ef4444'
            }
        };

        const card = elements.create('card', { style: style });
        card.mount('#card-element');

        let isCardComplete = false;
        let cardErrorMessage = '';

        card.on('change', function(event) {
            isCardComplete = event.complete;
            cardErrorMessage = event.error ? event.error.message : '';
            
            const displayError = document.getElementById('card-errors');
            const cardWrapper = document.querySelector('.payment_card_wrapper');

            if (event.error) {
                if (displayError) displayError.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> ' + event.error.message;
                if (cardWrapper) {
                    cardWrapper.style.borderColor = '#ef4444';
                    cardWrapper.style.background = '#fef2f2';
                }
            } else {
                if (displayError) displayError.innerHTML = '';
                if (cardWrapper && event.complete) {
                    cardWrapper.style.borderColor = '#cbd5e1';
                    cardWrapper.style.background = '#f8fafc';
                }
            }
        });

        let clientSecret = '';

        // Loyalty loader overlay
        const loyaltyLoader = document.getElementById('loyalty-loader');
        function showLoyaltyLoader() {
            if(loyaltyLoader) loyaltyLoader.style.display = 'flex';
        }
        function hideLoyaltyLoader() {
            if(loyaltyLoader) loyaltyLoader.style.display = 'none';
        }

        // Loyalty points toggle handler
        const loyaltyCheckbox = document.getElementById('apply_loyalty_points');
        if(loyaltyCheckbox) {
            loyaltyCheckbox.addEventListener('change', function() {
                showLoyaltyLoader();
                const apply = this.checked;
                
                fetch('{{ route("checkout.apply-loyalty") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ apply_loyalty: apply })
                })
                .then(res => res.json())
                .then(data => {
                    hideLoyaltyLoader();
                    if(data.success) {
                        const discountRow = document.getElementById('loyalty-discount-row');
                        const discountAmt = document.getElementById('loyalty-discount-amount');
                        const grandTotal = document.getElementById('summary-grand-total');

                        if(data.loyalty_discount > 0) {
                            discountAmt.textContent = '-{{ $currency }} ' + data.loyalty_discount.toFixed(2);
                            discountRow.classList.remove('d-none');
                        } else {
                            discountRow.classList.add('d-none');
                        }

                        grandTotal.textContent = '{{ $currency }} ' + data.total.toFixed(2);
                        
                        clientSecret = '';
                    } else {
                        alert(data.message || 'Error updating loyalty points');
                    }
                })
                .catch(err => {
                    hideLoyaltyLoader();
                    console.error(err);
                });
            });
        }

        // Pay Button Submission Handler
        const payBtn = document.getElementById('pay-button');
        const form = document.getElementById('payment-form');

        if(payBtn && form) {
            payBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // 1. Clear previous errors
                let existingTermsErr = document.getElementById('terms-error-alert');
                if (existingTermsErr) existingTermsErr.remove();

                if (idErrBox) idErrBox.classList.add('d-none');
                if (idDropzone) {
                    idDropzone.style.borderColor = '#cbd5e1';
                    idDropzone.style.background = '#f8fafc';
                }

                const cardWrapper = document.querySelector('.payment_card_wrapper');
                const cardErrors = document.getElementById('card-errors');
                if (cardWrapper) {
                    cardWrapper.style.borderColor = '#cbd5e1';
                    cardWrapper.style.background = '#f8fafc';
                }
                if (cardErrors) cardErrors.innerHTML = '';

                // 2. Validate Required Text/Select Inputs (First Name, Last Name, Email, Phone)
                let hasFieldError = false;
                const reqInputs = form.querySelectorAll('input[required]:not([type="checkbox"]):not([type="file"])');
                reqInputs.forEach(function(inp) {
                    if(!inp.value.trim()) {
                        inp.style.borderColor = '#ef4444';
                        inp.style.background = '#fef2f2';
                        hasFieldError = true;
                    } else {
                        inp.style.borderColor = '#cbd5e1';
                        inp.style.background = '#f8fafc';
                    }
                });

                if (hasFieldError) {
                    form.reportValidity();
                    return false;
                }

                // 3. Validate Required ID Proof Upload File
                if (fileInput && (!fileInput.files || fileInput.files.length === 0)) {
                    if (idDropzone) {
                        idDropzone.style.borderColor = '#ef4444';
                        idDropzone.style.background = '#fef2f2';
                    }
                    if (idErrBox) {
                        idErrBox.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> Please upload your Customer ID Proof to proceed.';
                        idErrBox.classList.remove('d-none');
                    }
                    if (idDropzone) idDropzone.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }

                // 4. Validate Stripe Card Details Input
                if (!isCardComplete) {
                    if (cardWrapper) {
                        cardWrapper.style.borderColor = '#ef4444';
                        cardWrapper.style.background = '#fef2f2';
                    }
                    if (cardErrors) {
                        cardErrors.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> ' + (cardErrorMessage || 'Please enter your card number to proceed.');
                    }
                    if (cardWrapper) cardWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return false;
                }

                // 5. Custom Validation for Terms & Conditions Checkbox
                if (termsCheckbox && !termsCheckbox.checked) {
                    if (termsWrapper) {
                        termsWrapper.style.borderColor = '#ef4444';
                        termsWrapper.style.background = '#fef2f2';

                        let errAlert = document.getElementById('terms-error-alert');
                        if (!errAlert) {
                            errAlert = document.createElement('div');
                            errAlert.id = 'terms-error-alert';
                            errAlert.style.color = '#ef4444';
                            errAlert.style.fontSize = '13px';
                            errAlert.style.fontWeight = '700';
                            errAlert.style.marginTop = '8px';
                            errAlert.style.display = 'flex';
                            errAlert.style.alignItems = 'center';
                            errAlert.style.gap = '6px';
                            errAlert.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> Please accept all terms & conditions to proceed.';
                            termsWrapper.parentNode.insertBefore(errAlert, termsWrapper.nextSibling);
                        }
                        termsWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }

                showGlobalLoader('Securing your booking...');
                payBtn.disabled = true;

                // Step 1: Create Stripe Payment Intent via AJAX
                fetch('{{ route("checkout.create-payment-intent") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        apply_loyalty: loyaltyCheckbox ? loyaltyCheckbox.checked : false
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if(!data.success) {
                        throw new Error(data.message || 'Failed to initialize payment.');
                    }

                    clientSecret = data.clientSecret;

                    // Step 2: Confirm Card Payment with Stripe
                    showGlobalLoader('Processing payment card...');
                    return stripe.confirmCardPayment(clientSecret, {
                        payment_method: {
                            card: card,
                            billing_details: {
                                name: (document.getElementById('guest_first_name') ? document.getElementById('guest_first_name').value : '') + ' ' + (document.getElementById('guest_last_name') ? document.getElementById('guest_last_name').value : ''),
                                email: document.getElementById('guest_email') ? document.getElementById('guest_email').value : '',
                                phone: document.getElementById('guest_phone') ? document.getElementById('guest_phone').value : ''
                            }
                        }
                    });
                })
                .then(result => {
                    if (result.error) {
                        hideGlobalLoader();
                        payBtn.disabled = false;
                        const errorElement = document.getElementById('card-errors');
                        if (errorElement) errorElement.innerHTML = '<i class="fa-solid fa-triangle-exclamation me-1"></i> ' + result.error.message;
                        if (cardWrapper) {
                            cardWrapper.style.borderColor = '#ef4444';
                            cardWrapper.style.background = '#fef2f2';
                        }
                    } else {
                        if (result.paymentIntent.status === 'succeeded') {
                            showGlobalLoader('Payment confirmed! Completing order...');
                            document.getElementById('payment_intent').value = result.paymentIntent.id;
                            form.submit();
                        } else {
                            hideGlobalLoader();
                            payBtn.disabled = false;
                            alert('Payment status: ' + result.paymentIntent.status);
                        }
                    }
                })
                .catch(err => {
                    hideGlobalLoader();
                    payBtn.disabled = false;
                    alert(err.message || 'An error occurred during checkout.');
                    console.error(err);
                });
            });
        }
    });
</script>