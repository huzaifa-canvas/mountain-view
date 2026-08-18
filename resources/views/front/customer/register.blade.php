@include('front.inc.header')

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">REGISTER</h6>
        </div> 
    </div>
</section>

<section class="checkout_wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <div class="checkout_form_wrap p-4 shadow-sm" style="background:#fff; border-radius:10px;">
                    <div class="checkout_form_ttext text-center mb-4">
                        <h6 class="heading">Create an Account</h6>
                        <p class="desc">Registered members earn loyalty points on every booking.</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.register.submit') }}" method="post">
                        @csrf
                        <div class="checkout_box">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="checkout_form_input">
                                        <label>First Name <span>*</span></label>
                                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First name" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="checkout_form_input">
                                        <label>Middle Name</label>
                                        <input type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="Middle name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="checkout_form_input">
                                        <label>Last name <span>*</span></label>
                                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last name" required>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <div class="checkout_form_input">
                                        <label>Email address <span>*</span></label>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="checkout_form_input">
                                        <label>Phone number</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="checkout_form_input">
                                        <label>Address</label>
                                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Enter Address">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="checkout_form_input">
                                        <label>City</label>
                                        <input type="text" name="city" value="{{ old('city') }}" placeholder="Enter City">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="checkout_form_input">
                                        <label>State</label>
                                        <input type="text" name="state" value="{{ old('state') }}" placeholder="Enter state">
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="checkout_form_input">
                                        <label>ZIP Code</label>
                                        <input type="text" name="zip_code" value="{{ old('zip_code') }}" placeholder="Enter ZIP code">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="checkout_form_input">
                                        <label>Password <span>*</span></label>
                                        <input type="password" name="password" placeholder="Create password (min 8 chars)" required>
                                    </div>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <div class="signin_box_btn1">
                                        <button type="submit" class="common_dark_btn w-100">Create Account <i class="fa-solid fa-circle-chevron-right"></i></button>
                                    </div>
                                </div>
                                <div class="col-12 text-center mt-4">
                                    <p>Already have an account? <a href="{{ route('customer.login') }}" style="color:var(--primary_color); font-weight:600;">Login here</a></p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('front.inc.footer')
