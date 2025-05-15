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
                        </div>
                        <div class="checkout_review_text_f">
                            <div class="checkout_review_text">
                                <h5 class="heading">Check in</h5>
                                <p class="desc">07-11-2024</p>
                            </div>
                            <div class="checkout_review_text">
                                <h5 class="heading">Check Out</h5>
                                <p class="desc">07-12-2024</p>
                            </div>
                        </div>
                        <div class="checkout_review_text mb-3">
                            <p class="desc">(Check in starts at 2pm and check out at 11am the next day.)</p>
                        </div>
                        <div class="checkout_review_text mb-2">
                            <p class="desc"><span>Total length of stay:</span> 3 nights</p>
                        </div>
                        <div class="checkout_review_product_wrap">
                            <div class="checkout_review_pro_f">
                                <div class="checkout_review_pro_img">
                                    <img src="{{ asset('assets/front/images/pro_img1.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="checkout_review_pro_text">
                                    <h5 class="heading">Superior Queen Room</h5>
                                    <p class="desc">2 Adults + 1 Child </p>
                                    <p class="desc">Laundry</p>
                                    <p class="desc"><span>$150</span></p>
                                </div>
                            </div>
                            <div class="checkout_review_pro_f">
                                <div class="checkout_review_pro_img">
                                    <img src="{{ asset('assets/front/images/pro_img1.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="checkout_review_pro_text">
                                    <h5 class="heading">Superior Queen Room</h5>
                                    <p class="desc">1 Adults + 2 Child </p>
                                    <p class="desc">1 Pet</p>
                                    <p class="desc"><span>$200</span></p>
                                </div>
                            </div>
                            <div class="checkout_review_pro_f">
                                <div class="checkout_review_pro_img">
                                    <img src="{{ asset('assets/front/images/pro_img1.png') }}" class="img-fluid" alt="">
                                </div>
                                <div class="checkout_review_pro_text">
                                    <h5 class="heading">Superior Queen Room</h5>
                                    <p class="desc">2 Adults + 2 Child </p>
                                    <p class="desc">Laundry</p>
                                    <p class="desc"><span>$250</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="checkout_review_cart_input">
                            <img src="{{ asset('assets/front/images/ticket_discount.png') }}" class="img-fluid" alt="">
                            <input type="text" placeholder="Add Coupon Code">
                            <button>Apply</button>
                        </div>
                        <div class="checkout_review_cart_price">
                            <div class="checkout_review_text">
                                <p class="desc">Subtotal <span>$45.00</span></p>
                                <p class="desc">Taxes & fees 15% <span>$5.00</span></p>
                                <p class="desc">Discount <span>-$10.00</span></p>
                                <p class="desc darkk">Total <span>$40.00</span></p>
                            </div>
                        </div>
                        <div class="checkout_review_cart_btn">
                            <button class="common_dark_btn">Pay Now <i class="fa-solid fa-circle-chevron-right"></i></button>
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
            </div>
        </div>
    </div>
</section>

@include('front.inc.footer')