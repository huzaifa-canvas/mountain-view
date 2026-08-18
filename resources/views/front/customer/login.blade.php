@include('front.inc.header')

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">LOGIN</h6>
        </div> 
    </div>
</section>

<section class="checkout_wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="checkout_form_wrap p-4 shadow-sm" style="background:#fff; border-radius:10px;">
                    <div class="checkout_form_ttext text-center mb-4">
                        <h6 class="heading">Customer Login</h6>
                        <p class="desc">Log in to manage your bookings and view your loyalty points.</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('customer.login.submit') }}" method="post">
                        @csrf
                        <div class="checkout_box">
                            <div class="checkout_form_input">
                                <label>Email address <span>*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                @error('email')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="checkout_form_input">
                                <label>Password <span>*</span></label>
                                <input type="password" name="password" placeholder="**************" required>
                            </div>
                            <div class="signin_box_btn text-end mt-2 mb-4">
                                <a href="#">Forgot Password?</a>
                            </div>
                            <div class="signin_box_btn1">
                                <button type="submit" class="common_dark_btn w-100">Login <i class="fa-solid fa-circle-chevron-right"></i></button>
                            </div>
                            <div class="text-center mt-4">
                                <p>Don't have an account? <a href="{{ route('customer.register') }}" style="color:var(--primary_color); font-weight:600;">Create one</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('front.inc.footer')
