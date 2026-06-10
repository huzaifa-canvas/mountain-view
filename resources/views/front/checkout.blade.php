@include('front.inc.header')

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
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                    <div class="checkout_form_wrap">
                        <div class="checkout_form_ttext">
                            <h6 class="heading">Checkout</h6>
                            <p class="desc">Registered members can earn royalty points on their bookings</p>
                        </div>
                        <div class="check_main_btns">
                            <button class="common_dark_btn">Sign in <i class="fa-solid fa-circle-chevron-right"></i></button>
                            <button class="common_dark_btn long_btn">create an account <i class="fa-solid fa-circle-chevron-right"></i></button>
                        </div>
                        <form action="{{ route('store_checkout') }}" method="post">
                            @csrf
                            <div class="checkout_box">
                                <div class="checkout_form_input">
                                    <label>Booking Type:</label>
                                    <select class="minimal1">
                                        <option>Personal</option>
                                        <option>Business</option>
                                    </select>
                                </div>
                                <div class="checkout_form_input">
                                    <label>Name</label>
                                    <input type="text" placeholder="Your Name">
                                    <span><img src="{{ asset('assets/front/images/mini_check.png') }}" class="img-fluid" alt=""></span>
                                </div>
                                <div class="checkout_form_input">
                                    <label>Card number</label>
                                    <input type="number" placeholder="123 - 456 -">
                                </div>
                                <div class="checkout_form_input_main_f">
                                    <div class="checkout_form_input">
                                        <label>Expiration</label>
                                        <div class="checkout_form_input_f">
                                            <div class="checkout_form_input">
                                                <input type="number" placeholder="03" class="sm_input">
                                            </div>
                                            <div class="checkout_form_input">
                                                <p>/</p>
                                            </div>
                                            <div class="checkout_form_input">
                                                <input type="number" placeholder="24" class="sm_input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkout_form_input">
                                        <label>CVC <img src="{{ asset('assets/front/images/question_mark.svg') }}" class="img-fluid" alt=""></label>
                                        <input type="number" placeholder="123" >
                                    </div>
                                </div>
                                <div class="checkbox-wrapper-46">
                                <input type="checkbox" id="cbx-46" class="inp-cbx" />
                                <label for="cbx-46" class="cbx"
                                    ><span>
                                    <svg viewBox="0 0 12 10" height="10px" width="12px">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline></svg></span
                                    ><span>Have read all terms & conditions, pets policy, privacy policy & cookie policy</span>
                                </label>
                                </div>
                                <div class="checkbox-wrapper-46">
                                <input type="checkbox" id="cbx-47" class="inp-cbx" />
                                <label for="cbx-47" class="cbx"
                                    ><span>
                                    <svg viewBox="0 0 12 10" height="10px" width="12px">
                                        <polyline points="1.5 6 4.5 9 10.5 1"></polyline></svg></span
                                    ><span>for marketing emails & promotions</span>
                                </label>
                                </div>
                            </div>
                            <div class="signin_box d-none">
                                <div class="checkout_form_input">
                                    <label>Email address <span>*</span></label>
                                    <input type="email" placeholder="Enter email address">
                                </div>
                                <div class="checkout_form_input">
                                    <label>Password <span>*</span></label>
                                    <input type="password" placeholder="**************">
                                </div>
                                <div class="signin_box_btn">
                                    <a href="#">Forgot Password</a>
                                </div>
                                <div class="signin_box_btn1">
                                    <button class="common_dark_btn">Continue <i class="fa-solid fa-circle-chevron-right"></i></button>
                                </div>
                            </div>
                            <div class="signup_box d-none">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                        <div class="checkout_form_input">
                                            <label>First Name <span>*</span></label>
                                            <input type="text" placeholder="Enter full name">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                        <div class="checkout_form_input">
                                            <label>Enter Middle Name <span>*</span></label>
                                            <input type="text" placeholder="Enter Middle Name">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                        <div class="checkout_form_input">
                                            <label>Last name <span>*</span></label>
                                            <input type="text" placeholder="Enter Last name">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                        <div class="checkout_form_input">
                                            <label>Address <span>*</span></label>
                                            <input type="text" placeholder="Enter Address">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                        <div class="checkout_form_input">
                                            <label>City</label>
                                            <input type="text" placeholder="Enter City">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                        <div class="checkout_form_input">
                                            <label>State</label>
                                            <input type="text" placeholder="Enter state">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                        <div class="checkout_form_input">
                                            <label>ZIP Code</label>
                                            <input type="text" placeholder="Enter ZIP code">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                        <div class="checkout_form_input">
                                            <label>Email address <span>*</span></label>
                                            <input type="email" placeholder="Enter email address">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                        <div class="checkout_form_input flag_input">
                                            <label>Phone number <span>*</span></label>
                                            <input type="number" placeholder="Enter phone number">
                                            <img src="{{ asset('assets/front/images/flag_dropdown.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                        <div class="signin_box_btn1">
                                            <button class="common_dark_btn">Continue <i class="fa-solid fa-circle-chevron-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                        <p class="desc" style="font-size:13px; color:#555;">${{ number_format($cart->listings_price, 2) }} / night per room</p>
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
                                                    <p style="margin:0; font-size:18px; font-weight:bold; color:#1a3c5e;">${{ number_format($itemTotal, 2) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="checkout_review_cart_input" style="margin-top:20px;">
                                        <img src="{{ asset('assets/front/images/ticket_discount.png') }}" class="img-fluid" alt="">
                                        <input type="text" placeholder="Add Coupon Code">
                                        <button type="button">Apply</button>
                                    </div>
                                    <div class="checkout_review_cart_price">
                                        <div class="checkout_review_text">
                                            @php
                                                $tax = $grandSubtotal * 0.15;
                                                $finalTotal = $grandSubtotal + $tax;
                                            @endphp
                                            <p class="desc">Subtotal <span>${{ number_format($grandSubtotal, 2) }}</span></p>
                                            <p class="desc">Taxes & fees 15% <span>${{ number_format($tax, 2) }}</span></p>
                                            <p class="desc darkk">Grand Total <span>${{ number_format($finalTotal, 2) }}</span></p>
                                        </div>
                                    </div>
                                    <div class="checkout_review_cart_btn">
                                        <button type="submit" class="common_dark_btn">Pay Now <i class="fa-solid fa-circle-chevron-right"></i></button>
                                    </div>
                                    <div class="checkout_review_ssl_text">
                                        <img src="{{ asset('assets/front/images/lock_img.png') }}" class="img-fluid" alt="">
                                        <p class="desc">Secure Checkout - SSL Encrypted</p>
                                    </div>
                                    <div class="checkout_review_text">
                                        <p class="desc">Ensuring your financial and personal details are secure during every transaction.</p>
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

@include('front.inc.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.remove-item-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if(confirm('Are you sure you want to remove this room from your cart?')) {
                    document.getElementById('remove-form-' + this.dataset.id).submit();
                }
            });
        });
    });
</script>