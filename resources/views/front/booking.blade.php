@include('front.inc.header')

<section class="index_banner_wrapper booking_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">BOOKING</h6>
        </div> 
        <form action="{{ url('booking') }}" method="get">
            <div class="index_banner_form_box_wrapper">
                <div class="index_banner_form_box">
                    <div class="index_banner_form_box_input">
                        <label for="">Check in</label>
                        <input type="date" name="check_in" id="check_in" required value="{{ request()->get('check_in') }}">
                        <img src="{{ asset('assets/front/images/calendar_icon.png') }}" class="img-fluid" alt="">
                    </div>
                    <div class="index_banner_form_box_input">
                        <label for="">Check Out</label>
                        <input type="date" name="check_out" id="check_out" required value="{{ request()->get('check_out') }}">
                        <img src="{{ asset('assets/front/images/calendar_icon.png') }}" class="img-fluid" alt="">
                    </div>
                <div class="index_banner_form_box_input_1">
                        <div class="number">
                            <label for="Adult">Adult</label>
                            <span class="minus" onclick="changeValue('Adult', -0)"><i class="fa-solid fa-minus"></i></span>
                            <input type="text" name="adult" placeholder="No Of Adult" id="Adult" value="{{ request()->get('adult') }}">
                            <span class="plus" onclick="changeValue('Adult', 0)"><i class="fa-solid fa-plus"></i></span>
                        </div>
                    </div>
                    <div class="index_banner_form_box_input_1">
                        <div class="number">
                            <label for="Children">Children</label>
                            <span class="minus" onclick="changeValue('Children', -0)"><i class="fa-solid fa-minus"></i></span>
                            <input type="text" name="children" placeholder="No Of Children" id="Children" value="{{ request()->get('children') }}">
                            <span class="plus" onclick="changeValue('Children', 0)"><i class="fa-solid fa-plus"></i></span>
                        </div>
                    </div>
                    <div class="index_banner_form_box_btn">
                        <button class="common_dark_btn">SEARCH <i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>


<section class="index_second_wrapper">
    <div class="container">
        @foreach($listings as $listing)
        @php $isInCart = in_array($listing->listings_id, $cartItems); @endphp
        <div class="booking_main_wrap">
            <div class="booking_card_box">
                <div class="booking_card_box_img">
                    <div class="swiper booking_slider2 booking_slider2_{{ $listing->listings_id }}">
                        <div class="swiper-wrapper">
                        @php 
                            $images = json_decode($listing->listings_img, true);
                        @endphp
                        @if(is_array($images))
                        @foreach ($images as $img)
                            <div class="swiper-slide">
                              <img src="{{ asset('storage/listing/'.$img) }}" />
                            </div>
                           
                        @endforeach
                        @endif
                    </div>

                    </div>
                    <div class="booking_slider1_wrap">
                        <div thumbsSlider="" class="swiper booking_slider1 booking_slider1_{{ $listing->listings_id }}">
                            <div class="swiper-wrapper">

                        @php 
                        $images = json_decode($listing->listings_img, true);
                    @endphp
                    @if(is_array($images))
                    @foreach ($images as $img)
                           <div class="swiper-slide">
                            <img src="{{ asset('storage/listing/'.$img) }}" />
                        </div>
                        
                        @endforeach
                        @endif
                    </div>

                    </div>
                    </div>
                </div>
                <div class="booking_card_box_text_m">
                    <div class="booking_card_box_htext" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                        <h6 class="heading" style="margin:0;">{{ $listing->listings_name }} <span>Recommended</span></h6>
                        
                        {{-- Dynamic Price Display --}}
                        <div id="price-summary-{{ $listing->listings_id }}" style="background:rgba(0,0,0,0.03); padding:4px 12px; border-radius:10px; display:none; flex-direction:column; justify-content:center; text-align:center;">
                            <p style="margin:0; font-size:16px; color:#555; line-height:1.2;">
                                <strong>Estimated Total:</strong> <span id="price-calc-{{ $listing->listings_id }}" style="font-size:16px; font-weight:700; color:#1a3c5e;">$0.00</span>
                                <small id="price-detail-{{ $listing->listings_id }}" style="display:block; margin-top:2px; color:#888; font-size:12px;"></small>
                            </p>
                        </div>

                        <p class="sub_heading" style="margin:0;">Price ${{ number_format($listing->listings_price, 2) }} / night</p>
                    </div>

                    {{-- Reserved Badge --}}
                    <div id="reserved-badge-{{ $listing->listings_id }}" style="margin-bottom:10px; display: {{ $isInCart ? 'flex' : 'none' }}; align-items:center; gap:10px;">
                        <span style="background:#28a745; color:#fff; padding:5px 15px; border-radius:20px; font-size:13px; font-weight:600;">
                            <i class="fa-solid fa-check-circle"></i> Reserved — Added to Cart
                        </span>
                        <button class="remove-cart-btn btn btn-sm btn-danger" style="border-radius:20px; font-size:12px; padding:4px 12px; background:#dc3545; color:#fff; border:none; cursor:pointer;" data-listing="{{ $listing->listings_id }}">
                            <i class="fa-solid fa-trash"></i> <span class="btn-text">Remove</span>
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7 mb-3">
                            <div class="booking_card_box_text border_right">
                                <ul>
                                    @php 
                                        $points = json_decode($listing->listings_points, true);
                                    @endphp
                                    @if(is_array($points))
                                    @foreach ($points as $point)
                                        <li><span>✓ </span>{{ $point }}</li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 mb-3">
                            <div class="booking_card_box_ul">
                                <ul>
                                    @php 
                                        $extras = json_decode($listing->listings_extras, true);
                                    @endphp
                                    @if(is_array($extras))          
                                    @foreach ($extras as $index => $extra)
                                        <li><i class="{{$extra}}"></i> {{$index }}</li>
                                    @endforeach
                                    @endif
                                </ul>
                             
                            </div>
                        </div>

                        <div id="reserve-form-container-{{ $listing->listings_id }}" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12" style="display: {{ $isInCart ? 'none' : 'block' }};">
                            <form class="reserve-form" id="reserve-form-{{ $listing->listings_id }}" action="{{ route('booking_cart', ['id' => $listing->listings_id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="checkin" id="form_checkin_{{ $listing->listings_id }}" value="{{ request()->get('check_in') }}">
                                <input type="hidden" name="checkout" id="form_checkout_{{ $listing->listings_id }}" value="{{ request()->get('check_out') }}">
                                <div class="booking_card_box_textm_f">
                                    <div class="booking_card_box_text1f">
                                        <div class="booking_card_box_text1">
                                            <h4 class="heading">Number OF Guest</h4>
                                            <ul>
                                                @for($i = 0; $i < ($listing->listings_number_of_persons ?? 1); $i++)
                                                <li><i class="fa-solid fa-user"></i></li>
                                                @endfor
                                            </ul>
                                        </div>
                                        <div class="booking_card_box_text1">
                                            <h4 class="heading">Need laundry?</h4>
                                            <div class="radio_buttonf">
                                                <label class="radio-button">
                                                  <input type="radio" value="Yes" name="laundry">
                                                  <span class="radio"></span>
                                                  Yes
                                                </label>

                                                <label class="radio-button">
                                                  <input type="radio"  value="No" name="laundry" checked>
                                                  <span class="radio"></span>
                                                  No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="booking_card_box_text1">
                                            <h4 class="heading mb-3">Have Pets?</h4>
                                            <div class="number">
                                                <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                                <input type="text" name="pets" value="0" maxlength="3" readonly="" required>
                                                <span class="plus"><i class="fa-solid fa-plus"></i></span>
                                            </div>
                                        </div>
                                        <div class="booking_card_box_text1">
                                            <h4 class="heading mb-3">Select Room</h4>
                                            <div class="number">
                                                <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                                <input type="text" name="room" value="0" maxlength="3" readonly="" required 
                                                       data-max="{{ $listing->listings_number_of_rooms ?? 1 }}" 
                                                       data-price="{{ $listing->listings_price }}"
                                                       data-listing-id="{{ $listing->listings_id }}"
                                                       class="room-input">
                                                <span class="plus"><i class="fa-solid fa-plus"></i></span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="booking_card_box_btns">
                                        <a href="{{ url('room') }}" class="common_light_btn">Read More <i class="fa-solid fa-circle-chevron-right"></i></a>
                                        <button type="submit" class="common_dark_btn reserve-btn" data-listing="{{ $listing->listings_id }}">
                                            <span class="btn-text">Reserve Room</span> <i class="fa-solid fa-circle-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- Floating Checkout Button --}}
<div id="floating-checkout" style="position:fixed; bottom:50px; right:30px; z-index:999999; display:{{ $cartCount > 0 ? 'block' : 'none' }};">
    <a href="{{ url('checkout') }}" class="common_dark_btn" style="display:inline-flex; align-items:center; justify-content:center; gap:8px; width:60px; height:60px; border-radius:50%; box-shadow: 0 10px 25px rgba(0,0,0,0.4); font-size:20px; text-decoration:none; padding:0;">
        <i class="fa-solid fa-cart-shopping"></i> <span id="cart-count-badge" style="position:absolute; top:-5px; right:-5px; background:#dc3545; color:#fff; font-size:12px; font-weight:bold; width:22px; height:22px; display:flex; align-items:center; justify-content:center; border-radius:50%;">{{ $cartCount }}</span>
    </a>
</div>

@include('front.inc.footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Move floating checkout outside of smooth-wrapper directly to body
        var floatingCheckout = document.getElementById('floating-checkout');
        if(floatingCheckout) {
            document.body.appendChild(floatingCheckout);
        }

        // Initialize Swipers
        @foreach($listings as $listing)
        var thumbSwiper_{{ $listing->listings_id }} = new Swiper(".booking_slider1_{{ $listing->listings_id }}", {
            loop: false,
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
        });
        var mainSwiper_{{ $listing->listings_id }} = new Swiper(".booking_slider2_{{ $listing->listings_id }}", {
            loop: false,
            spaceBetween: 10,
            effect: "fade",
            thumbs: {
                swiper: thumbSwiper_{{ $listing->listings_id }},
            },
        });
        @endforeach

        // Room +/- with max limit (Wait for theme script to run first, then enforce max)
        document.querySelectorAll('.number').forEach(function(el) {
            var input = el.querySelector('input');
            
            el.querySelector('.minus').addEventListener('click', function() {
                setTimeout(function() {
                    var val = parseInt(input.value) || 0;
                    if (val < 0) { input.value = 0; }
                    updatePrice(input);
                }, 10);
            });
            el.querySelector('.plus').addEventListener('click', function() {
                var maxVal = parseInt(input.dataset.max) || 999;
                setTimeout(function() {
                    var val = parseInt(input.value) || 0;
                    if (val > maxVal) { input.value = maxVal; }
                    updatePrice(input);
                }, 10);
            });
        });

        // Price calculation
        function updatePrice(input) {
            if (!input.classList.contains('room-input')) return;
            
            var listingId = input.dataset.listingId;
            var pricePerNight = parseFloat(input.dataset.price) || 0;
            var rooms = parseInt(input.value) || 0;
            
            var checkIn = document.getElementById('check_in').value;
            var checkOut = document.getElementById('check_out').value;
            var nights = 1;
            
            if (checkIn && checkOut) {
                var d1 = new Date(checkIn);
                var d2 = new Date(checkOut);
                var diff = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
                if (diff > 0) nights = diff;
            }
            
            var summaryEl = document.getElementById('price-summary-' + listingId);
            var calcEl = document.getElementById('price-calc-' + listingId);
            var detailEl = document.getElementById('price-detail-' + listingId);
            
            if (rooms > 0) {
                var total = pricePerNight * rooms * nights;
                summaryEl.style.display = 'block';
                calcEl.textContent = '$' + total.toFixed(2);
                detailEl.textContent = rooms + ' room(s) × ' + nights + ' night(s) × $' + pricePerNight.toFixed(2);
            } else {
                summaryEl.style.display = 'none';
            }
        }

        // Update hidden checkin/checkout fields when top filter changes
        document.getElementById('check_in').addEventListener('change', function() {
            document.querySelectorAll('[id^="form_checkin_"]').forEach(function(el) { el.value = document.getElementById('check_in').value; });
            document.querySelectorAll('.room-input').forEach(updatePrice);
        });
        document.getElementById('check_out').addEventListener('change', function() {
            document.querySelectorAll('[id^="form_checkout_"]').forEach(function(el) { el.value = document.getElementById('check_out').value; });
            document.querySelectorAll('.room-input').forEach(updatePrice);
        });

        // AJAX Reserve Form Submission
        document.querySelectorAll('.reserve-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                var listingId = this.id.replace('reserve-form-', '');
                var checkIn = document.getElementById('check_in').value;
                var checkOut = document.getElementById('check_out').value;
                var roomInput = document.querySelector('#reserve-form-' + listingId + ' .room-input');
                var rooms = parseInt(roomInput.value) || 0;

                if (!checkIn || !checkOut) {
                    alert('Please select Check-in and Check-out dates first.');
                    return false;
                }
                if (rooms < 1) {
                    alert('Please select at least 1 room.');
                    return false;
                }

                // Update hidden fields
                document.getElementById('form_checkin_' + listingId).value = checkIn;
                document.getElementById('form_checkout_' + listingId).value = checkOut;

                var submitBtn = form.querySelector('.reserve-btn');
                var originalHtml = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Reserving...';
                submitBtn.disabled = true;

                var formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    submitBtn.innerHTML = originalHtml;
                    submitBtn.disabled = false;
                    
                    if(data.success) {
                        // Update UI
                        document.getElementById('reserve-form-container-' + listingId).style.display = 'none';
                        document.getElementById('reserved-badge-' + listingId).style.display = 'flex';
                        
                        // Update cart count
                        var cartBadge = document.getElementById('cart-count-badge');
                        if(cartBadge) {
                            cartBadge.textContent = data.cartCount;
                            var floatingCheckout = document.getElementById('floating-checkout');
                            if(floatingCheckout) {
                                floatingCheckout.style.display = data.cartCount > 0 ? 'block' : 'none';
                            }
                        }
                    } else {
                        alert(data.errors ? Object.values(data.errors).join('\n') : 'An error occurred.');
                    }
                })
                .catch(error => {
                    submitBtn.innerHTML = originalHtml;
                    submitBtn.disabled = false;
                    alert('An error occurred. Please try again.');
                });
            });
        });

        // AJAX Remove Cart Submission
        document.querySelectorAll('.remove-cart-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if(!confirm('Are you sure you want to remove this room from your cart?')) return;
                
                var listingId = this.dataset.listing;
                var originalHtml = this.innerHTML;
                this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Removing...';
                this.disabled = true;

                fetch("{{ url('cart/listing') }}/" + listingId, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    this.innerHTML = originalHtml;
                    this.disabled = false;
                    
                    if(data.success) {
                        // Update UI
                        document.getElementById('reserved-badge-' + listingId).style.display = 'none';
                        document.getElementById('reserve-form-container-' + listingId).style.display = 'block';
                        
                        // Update cart count
                        var cartBadge = document.getElementById('cart-count-badge');
                        if(cartBadge) {
                            cartBadge.textContent = data.cartCount;
                            var floatingCheckout = document.getElementById('floating-checkout');
                            if(floatingCheckout) {
                                floatingCheckout.style.display = data.cartCount > 0 ? 'block' : 'none';
                            }
                        }
                    } else {
                        alert(data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    this.innerHTML = originalHtml;
                    this.disabled = false;
                    alert('An error occurred. Please try again.');
                });
            });
        });
    });
</script>
