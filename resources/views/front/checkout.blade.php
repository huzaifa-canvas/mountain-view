@include('front.inc.header')

<script src="https://js.stripe.com/v3/"></script>

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
            <div class="row justify-content-between">
                <!-- Left Side: Guest / Login / Checkout Form -->
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                    <div class="checkout_form_wrap">
                        <div class="checkout_form_ttext">
                            <h6 class="heading">Checkout</h6>
                            <p class="desc">Registered members earn loyalty points on every booking.</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                        @endif

<style>
    .check_main_btns {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        background: #f1f5f9;
        padding: 6px;
        border-radius: 50px;
        margin-bottom: 25px;
    }
    .check_main_btns .auth-tab-btn {
        flex: 1;
        min-width: 120px;
        height: 46px;
        padding: 0 18px;
        border-radius: 35px;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 0.3px;
        text-transform: uppercase;
        border: none;
        background: transparent;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
        transition: all 0.25s ease-in-out;
        cursor: pointer;
    }
    .check_main_btns .auth-tab-btn i {
        font-size: 14px;
    }
    .check_main_btns .auth-tab-btn:hover {
        color: #184E77;
        background: rgba(24, 78, 119, 0.08);
    }
    .check_main_btns .auth-tab-btn.active {
        background: #184E77 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(24, 78, 119, 0.25);
    }
    .check_main_btns .auth-tab-btn.active i {
        color: #ffffff;
    }
</style>

                        @if(!Auth::guard('customer')->check())
                            <div class="check_main_btns mb-4">
                                <button type="button" class="auth-tab-btn active" id="btn-guest-tab">Guest Checkout <i class="fa-solid fa-user"></i></button>
                                <button type="button" class="auth-tab-btn" id="btn-login-tab">Sign in <i class="fa-solid fa-circle-chevron-right"></i></button>
                                <button type="button" class="auth-tab-btn" id="btn-register-tab">Create Account <i class="fa-solid fa-circle-chevron-right"></i></button>
                            </div>
                        @else
                            <div class="alert alert-info d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <i class="fa-solid fa-user-check me-2"></i> Logged in as <strong>{{ Auth::guard('customer')->user()->first_name }} {{ Auth::guard('customer')->user()->last_name }}</strong> ({{ Auth::guard('customer')->user()->email }})
                                </div>
                                <a href="{{ route('customer.logout') }}" class="btn btn-sm btn-outline-danger">Logout</a>
                            </div>
                        @endif

                        <!-- Main Checkout Form -->
                        <form action="{{ route('checkout.process-payment') }}" method="post" id="payment-form">
                            @csrf
                            <input type="hidden" name="payment_intent" id="payment_intent">

                            <div class="checkout_box" id="checkout-fields-box">
                                <div class="checkout_form_input">
                                    <label>Booking Type:</label>
                                    <select class="minimal1" name="booking_type">
                                        <option value="Personal">Personal</option>
                                        <option value="Business">Business</option>
                                    </select>
                                </div>

                                @if(!Auth::guard('customer')->check())
                                    <div class="checkout_form_input">
                                        <label>Full Name <span>*</span></label>
                                        <input type="text" name="name" id="guest_name" placeholder="Your Name" required>
                                    </div>
                                    <div class="checkout_form_input">
                                        <label>Email Address <span>*</span></label>
                                        <input type="email" name="email" id="guest_email" placeholder="Your Email" required>
                                    </div>
                                    <div class="checkout_form_input">
                                        <label>Phone Number <span>*</span></label>
                                        <input type="text" name="phone" id="guest_phone" placeholder="Your Phone Number" required>
                                    </div>
                                @endif

                                <!-- Stripe Payment Element Container -->
                                <div class="checkout_form_input mt-3">
                                    <label class="fw-bold">Payment Card Details <span>*</span></label>
                                    <div id="card-element" style="padding: 12px; border: 1px solid #ced4da; border-radius: 6px; background: #fff;"></div>
                                    <div id="card-errors" class="text-danger small mt-2" role="alert"></div>
                                </div>

                                <!-- Loyalty Points Box (for logged in customers) -->
                                @if(Auth::guard('customer')->check())
                                    @php
                                        $customer = Auth::guard('customer')->user();
                                        $redemptionRate = $general_setting->loyalty_points_redemption_rate ?? 0.10;
                                        $pointsValue = $customer->loyalty_points * $redemptionRate;
                                    @endphp
                                    <div class="loyalty_redeem_box p-3 mt-3 mb-3" style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 text-primary"><i class="fa-solid fa-coins me-1"></i> Loyalty Points Balance</h6>
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

                                <div class="checkbox-wrapper-46 mt-3">
                                    <input type="checkbox" id="cbx-46" class="inp-cbx" required />
                                    <label for="cbx-46" class="cbx">
                                        <span><svg viewBox="0 0 12 10" height="10px" width="12px"><polyline points="1.5 6 4.5 9 10.5 1"></polyline></svg></span>
                                        <span>Have read all terms & conditions, pets policy, privacy policy & cookie policy</span>
                                    </label>
                                </div>
                            </div>
                        </form>

                        <!-- Inline Login Form (Hidden by default) -->
                        <div class="signin_box d-none" id="inline-login-box">
                            <h6 class="mb-3">Sign In to Your Account</h6>
                            <div id="login-error-msg" class="alert alert-danger d-none"></div>
                            <div class="checkout_form_input">
                                <label>Email address <span>*</span></label>
                                <input type="email" id="login_email" placeholder="Enter email address">
                            </div>
                            <div class="checkout_form_input">
                                <label>Password <span>*</span></label>
                                <input type="password" id="login_password" placeholder="**************">
                            </div>
                            <div class="signin_box_btn1 mt-3">
                                <button type="button" class="common_dark_btn w-100" id="btn-do-login">Login & Continue <i class="fa-solid fa-circle-chevron-right"></i></button>
                            </div>
                        </div>

                        <!-- Inline Registration Form (Hidden by default) -->
                        <div class="signup_box d-none" id="inline-register-box">
                            <h6 class="mb-3">Create New Customer Account</h6>
                            <div id="register-error-msg" class="alert alert-danger d-none"></div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="checkout_form_input">
                                        <label>First Name <span>*</span></label>
                                        <input type="text" id="reg_first_name" placeholder="First name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="checkout_form_input">
                                        <label>Last Name <span>*</span></label>
                                        <input type="text" id="reg_last_name" placeholder="Last name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="checkout_form_input">
                                        <label>Email Address <span>*</span></label>
                                        <input type="email" id="reg_email" placeholder="Email address">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="checkout_form_input">
                                        <label>Password <span>*</span></label>
                                        <input type="password" id="reg_password" placeholder="Minimum 8 characters">
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="signin_box_btn1">
                                        <button type="button" class="common_dark_btn w-100" id="btn-do-register">Create Account & Continue <i class="fa-solid fa-circle-chevron-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Side: Order Summary & Review Cart -->
                <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                    <div class="checkout_review_cart_wrap">
                        <div class="checkout_review_ttext">
                            <h6 class="heading">Review your cart</h6>
                            <p class="desc" style="font-size:13px; color:#666; margin-top:5px;">(Check in starts at 2pm and check out at 11am the next day.)</p>
                        </div>
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
                            <div class="checkout_review_pro_f" style="position:relative; flex-direction:column; align-items:flex-start; gap:15px; background:#f8f9fa; padding:15px; border-radius:10px; margin-bottom:15px;">
                                <div style="display:flex; justify-content:space-between; width:100%; align-items:flex-start;">
                                    <div style="display:flex; gap:15px;">
                                        <div class="checkout_review_pro_img" style="width:80px; height:80px; flex-shrink:0;">
                                            <img src="{{ asset('storage/listing/'.$img[0]) }}" class="img-fluid" alt="{{ $cart->listings_name }}" style="border-radius:8px; width:100%; height:100%; object-fit:cover;">
                                        </div>
                                        <div class="checkout_review_pro_text">
                                            <h5 class="heading" style="margin-bottom:5px; font-size:16px;">{{ $cart->listings_name }}</h5>
                                            <p class="desc" style="font-size:13px; margin-bottom:2px;"><strong>Rooms:</strong> {{ $cart->cart_rooms }} &nbsp;|&nbsp; <strong>Pets:</strong> {{ $cart->cart_pets }} &nbsp;|&nbsp; <strong>Laundry:</strong> {{ $cart->cart_laundry }}</p>
                                            <p class="desc" style="font-size:13px; color:#555;">{{ $currency }} {{ number_format($cart->listings_price, 2) }} / night per room</p>
                                        </div>
                                    </div>
                                    <button type="button" class="remove-item-btn" data-id="{{ $cart->cart_id }}" style="background:none; border:none; color:#dc3545; cursor:pointer; font-size:16px; padding:5px; align-self:flex-start;" title="Remove">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </div>
                                
                                <div style="background:#fff; padding:10px; border-radius:8px; width:100%; border:1px solid #eee; display:flex; justify-content:space-between; align-items:center;">
                                    <div>
                                        <p style="margin:0; font-size:12px; color:#666;"><strong>Check in:</strong> {{ $checkIn->format('M d, Y') }}</p>
                                        <p style="margin:0; font-size:12px; color:#666;"><strong>Check out:</strong> {{ $checkOut->format('M d, Y') }}</p>
                                        <p style="margin:0; font-size:12px; color:#1a3c5e; margin-top:3px;"><i class="fa-solid fa-moon"></i> {{ $nights }} Night{{ $nights > 1 ? 's' : '' }}</p>
                                    </div>
                                    <div style="text-align:right;">
                                        <p style="margin:0; font-size:12px; color:#666;">Total</p>
                                        <p style="margin:0; font-size:18px; font-weight:bold; color:#1a3c5e;">{{ $currency }} {{ number_format($itemTotal, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="checkout_review_cart_price" style="position: relative;">
                            <!-- Loyalty Loader Overlay -->
                            <div id="loyalty-loader" style="position:absolute; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.85); z-index:10; display:none; justify-content:center; align-items:center; border-radius:8px;">
                                <div style="text-align:center;">
                                    <i class="fa-solid fa-spinner fa-spin" style="font-size:24px; color:#184E77;"></i>
                                    <p style="margin:8px 0 0; font-size:13px; color:#475569; font-weight:600;">Recalculating...</p>
                                </div>
                            </div>

                            <div class="checkout_review_text">
                                <p class="desc">Subtotal <span>{{ $currency }} {{ number_format($subtotal, 2) }}</span></p>
                                <p class="desc">{{ $general_setting->tax_label ?? 'Taxes & fees' }} ({{ $tax_rate }}%) <span>{{ $currency }} {{ number_format($tax, 2) }}</span></p>
                                <p class="desc text-success d-none" id="loyalty-discount-row">Loyalty Discount <span id="loyalty-discount-amount">-{{ $currency }} 0.00</span></p>
                                <p class="desc darkk">Grand Total <span id="summary-grand-total">{{ $currency }} {{ number_format($total, 2) }}</span></p>
                            </div>
                        </div>

                        <div class="checkout_review_cart_btn">
                            <button type="button" id="pay-button" class="common_dark_btn w-100">Pay Now <i class="fa-solid fa-circle-chevron-right"></i></button>
                        </div>
                        <div class="checkout_review_ssl_text mt-3">
                            <img src="{{ asset('assets/front/images/lock_img.png') }}" class="img-fluid" alt="">
                            <p class="desc">Secure Checkout - Stripe SSL Encrypted</p>
                        </div>
                    </div>
                </div>

                {{-- Hidden Forms for Remove Action --}}
                @foreach($checkout as $cart)
                <form id="remove-form-{{ $cart->cart_id }}" action="{{ route('remove_cart', $cart->cart_id) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach

            </div>
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
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        const card = elements.create('card', { style: style });
        card.mount('#card-element');

        card.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
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

        function initPaymentIntent(applyPoints = false) {
            showLoyaltyLoader();

            fetch('{{ route("checkout.payment-intent") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ apply_points: applyPoints })
            })
            .then(res => res.json())
            .then(data => {
                hideLoyaltyLoader();

                if(data.clientSecret) {
                    clientSecret = data.clientSecret;
                    
                    const discountRow = document.getElementById('loyalty-discount-row');
                    const discountAmt = document.getElementById('loyalty-discount-amount');
                    const grandTotal = document.getElementById('summary-grand-total');

                    if(data.discount > 0) {
                        discountRow.classList.remove('d-none');
                        discountAmt.textContent = '-{{ $currency }} ' + parseFloat(data.discount).toFixed(2);
                    } else {
                        discountRow.classList.add('d-none');
                    }

                    grandTotal.textContent = '{{ $currency }} ' + parseFloat(data.total).toFixed(2);
                } else if(data.error) {
                    console.error('Stripe PaymentIntent error:', data.error);
                }
            })
            .catch(err => {
                hideLoyaltyLoader();
                console.error('Network error:', err);
            });
        }

        initPaymentIntent(false);

        const loyaltyCheckbox = document.getElementById('apply_loyalty_points');
        if(loyaltyCheckbox) {
            loyaltyCheckbox.addEventListener('change', function() {
                initPaymentIntent(this.checked);
            });
        }

        const payButton = document.getElementById('pay-button');
        const paymentForm = document.getElementById('payment-form');

        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            // Check validity of form if guest
            if(!paymentForm.checkValidity()) {
                paymentForm.reportValidity();
                return;
            }

            payButton.disabled = true;
            payButton.innerHTML = 'Processing Payment... <i class="fa-solid fa-spinner fa-spin"></i>';
            showGlobalLoader('Processing your payment... Please do not close or refresh this page.');

            // Build billing details from logged-in customer or guest fields
            let billingName = '';
            let billingEmail = '';
            @if(\Auth::guard('customer')->check())
                billingName = '{{ addslashes(trim(\Auth::guard('customer')->user()->first_name . " " . \Auth::guard('customer')->user()->last_name)) }}';
                billingEmail = '{{ \Auth::guard('customer')->user()->email }}';
            @else
                const nameField = document.querySelector('input[name="name"]');
                const emailField = document.querySelector('input[name="email"]');
                if(nameField) billingName = nameField.value;
                if(emailField) billingEmail = emailField.value;
            @endif

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: billingName || undefined,
                        email: billingEmail || undefined
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                    payButton.disabled = false;
                    payButton.innerHTML = 'Pay Now <i class="fa-solid fa-circle-chevron-right"></i>';
                    hideGlobalLoader();
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        document.getElementById('payment_intent').value = result.paymentIntent.id;
                        showGlobalLoader('Finalizing your booking order...');
                        paymentForm.submit();
                    }
                }
            }).catch(function(err) {
                hideGlobalLoader();
                payButton.disabled = false;
                payButton.innerHTML = 'Pay Now <i class="fa-solid fa-circle-chevron-right"></i>';
                console.error(err);
            });
        });
    });
</script>