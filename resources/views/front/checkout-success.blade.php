@include('front.inc.header')

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">BOOKING CONFIRMED</h6>
        </div> 
    </div>
</section>

<section class="checkout_wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8">
                <div class="checkout_form_wrap text-center p-5">
                    <div class="mb-4">
                        <i class="fa-solid fa-circle-check text-success" style="font-size: 64px;"></i>
                    </div>
                    <h3 class="heading mb-2">Thank You for Your Booking!</h3>
                    <p class="desc mb-4">Your order <strong>#{{ $order->order_number }}</strong> has been placed and payment confirmed.</p>
                    
                    <div class="card border-0 bg-light p-4 text-start mb-4">
                        <h5 class="mb-3">Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Booking Type:</span>
                            <strong>{{ $order->booking_type }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>{{ $currency }} {{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax:</span>
                            <span>{{ $currency }} {{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        @if($order->loyalty_discount > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>Loyalty Discount:</span>
                            <span>-{{ $currency }} {{ number_format($order->loyalty_discount, 2) }}</span>
                        </div>
                        @endif
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Grand Total:</span>
                            <span>{{ $currency }} {{ number_format($order->grand_total, 2) }}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        @if(Auth::guard('customer')->check())
                            <a href="{{ route('customer.dashboard') }}" class="common_dark_btn">Go to My Account <i class="fa-solid fa-circle-chevron-right"></i></a>
                        @else
                            <a href="{{ url('/') }}" class="common_dark_btn">Back to Home <i class="fa-solid fa-circle-chevron-right"></i></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('front.inc.footer')
