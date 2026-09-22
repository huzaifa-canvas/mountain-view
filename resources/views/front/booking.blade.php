@include('front.inc.header')

<style>
/* Luxury Booking Card Redesign */
.booking_card_box {
    background: #ffffff !important;
    border-radius: 16px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
    border: 1px solid #e2e8f0 !important;
    padding: 24px !important;
    margin-bottom: 30px !important;
    transition: all 0.3s ease !important;
}
.booking_card_box:hover {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.09) !important;
    border-color: #cbd5e1 !important;
}

/* Card Header */
.booking_card_box_htext {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    flex-wrap: wrap !important;
    gap: 12px !important;
    padding-bottom: 16px !important;
    border-bottom: 1px solid #f1f5f9 !important;
    margin-bottom: 16px !important;
}
.booking_card_box_htext .heading {
    font-size: 24px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    margin: 0 !important;
}
.booking_card_box_htext .heading span {
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: #ffffff !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    padding: 3px 10px !important;
    border-radius: 20px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
}
.booking_card_box_htext .sub_heading {
    background: #f8fafc !important;
    color: #1e293b !important;
    border: 1px solid #cbd5e1 !important;
    font-size: 15px !important;
    font-weight: 700 !important;
    padding: 6px 16px !important;
    border-radius: 30px !important;
    margin: 0 !important;
}

/* Bottom Options Bar */
.booking_options_bar {
    background: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 14px !important;
    padding: 18px 22px !important;
    margin-top: 15px !important;
}
.options_grid {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 20px 30px !important;
    align-items: flex-start !important;
    justify-content: space-between !important;
    transition: all 0.3s ease !important;
}

/* Reserved Overlay for Row 1 */
.options_grid.reserved_locked {
    pointer-events: none !important;
    opacity: 0.65 !important;
    position: relative !important;
    user-select: none !important;
}
.options_grid.reserved_locked::after {
    content: '';
    position: absolute;
    top: -6px;
    left: -6px;
    right: -6px;
    bottom: -6px;
    background: rgba(248, 250, 252, 0.45);
    border-radius: 12px;
    z-index: 10;
}

/* Control Tiles */
.control_tile {
    display: flex !important;
    flex-direction: column !important;
    gap: 6px !important;
}
.control_tile_title {
    font-size: 12px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    color: #184E77 !important;
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    margin: 0 !important;
    flex-wrap: wrap !important;
}
.fee_badge {
    font-size: 11px !important;
    font-weight: 700 !important;
    padding: 2px 7px !important;
    border-radius: 10px !important;
    text-transform: none !important;
}
.fee_badge_blue {
    background: #e0f2fe !important;
    color: #0284c7 !important;
}
.fee_badge_amber {
    background: #fef3c7 !important;
    color: #d97706 !important;
}

/* Plus / Minus Stepper inside Booking Cards */
.booking_card_box .number, .control_tile .number {
    display: inline-flex !important;
    align-items: center !important;
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 2px !important;
    width: fit-content !important;
}
.booking_card_box .number .minus, .booking_card_box .number .plus,
.control_tile .number .minus, .control_tile .number .plus {
    width: 28px !important;
    height: 28px !important;
    background: #f1f5f9 !important;
    color: #0f172a !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 6px !important;
    cursor: pointer !important;
    font-size: 11px !important;
    transition: all 0.2s ease !important;
    user-select: none !important;
}
.booking_card_box .number .minus:hover, .booking_card_box .number .plus:hover,
.control_tile .number .minus:hover, .control_tile .number .plus:hover {
    background: #184E77 !important;
    color: #ffffff !important;
}
.booking_card_box .number input, .control_tile .number input {
    width: 38px !important;
    border: none !important;
    text-align: center !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    color: #0f172a !important;
    background: transparent !important;
    padding: 0 !important;
}

/* Custom Radio Buttons */
.radio_button_group {
    display: inline-flex !important;
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: 8px !important;
    padding: 3px !important;
    gap: 4px !important;
    width: fit-content !important;
}
.custom_radio_btn {
    padding: 4px 12px !important;
    border-radius: 6px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    color: #475569 !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    margin: 0 !important;
}
.custom_radio_btn input[type="radio"] {
    display: none !important;
}
.custom_radio_btn.active, .custom_radio_btn:has(input[type="radio"]:checked) {
    background: #184E77 !important;
    color: #ffffff !important;
    box-shadow: 0 2px 6px rgba(24, 78, 119, 0.25) !important;
}

/* Buttons & Total Bar */
.actions_bar {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 16px !important;
    margin-top: 18px !important;
    padding-top: 14px !important;
    border-top: 1px solid #e2e8f0 !important;
    flex-wrap: wrap !important;
}
.btn_read_more {
    padding: 10px 22px !important;
    border-radius: 30px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    background: #ffffff !important;
    color: #334155 !important;
    border: 1px solid #cbd5e1 !important;
    transition: all 0.2s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    text-decoration: none !important;
}
.btn_read_more:hover {
    background: #f1f5f9 !important;
    color: #0f172a !important;
}

.btn_reserve_room {
    padding: 11px 26px !important;
    border-radius: 30px !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    background: linear-gradient(135deg, #184E77, #1e6091) !important;
    color: #ffffff !important;
    border: none !important;
    box-shadow: 0 4px 14px rgba(24, 78, 119, 0.3) !important;
    transition: all 0.25s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    cursor: pointer !important;
}
.btn_reserve_room:hover {
    background: linear-gradient(135deg, #164264, #184E77) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 18px rgba(24, 78, 119, 0.4) !important;
}

/* Reserved Tag & Action Buttons */
.reserved_badge_tag {
    background: #10b981 !important;
    color: #ffffff !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    padding: 8px 16px !important;
    border-radius: 30px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25) !important;
}

.btn_remove_room {
    padding: 9px 18px !important;
    border-radius: 30px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    background: #fef2f2 !important;
    color: #ef4444 !important;
    border: 1px solid #fca5a5 !important;
    transition: all 0.2s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    cursor: pointer !important;
}
.btn_remove_room:hover {
    background: #ef4444 !important;
    color: #ffffff !important;
    border-color: #ef4444 !important;
}

.btn_checkout_room {
    padding: 9px 22px !important;
    border-radius: 30px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    background: linear-gradient(135deg, #10b981, #059669) !important;
    color: #ffffff !important;
    border: none !important;
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3) !important;
    transition: all 0.25s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    text-decoration: none !important;
}
.btn_checkout_room:hover {
    background: linear-gradient(135deg, #059669, #047857) !important;
    color: #ffffff !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 18px rgba(16, 185, 129, 0.4) !important;
}
</style>

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
                        <input type="text" name="check_in" id="check_in" required placeholder="Select Check-in Date" value="{{ request()->get('check_in') }}">
                        <img src="{{ asset('assets/front/images/calendar_icon.png') }}" class="img-fluid" alt="" style="pointer-events: none;">
                    </div>
                    <div class="index_banner_form_box_input">
                        <label for="">Check Out</label>
                        <input type="text" name="check_out" id="check_out" required placeholder="Select Check-out Date" value="{{ request()->get('check_out') }}">
                        <img src="{{ asset('assets/front/images/calendar_icon.png') }}" class="img-fluid" alt="" style="pointer-events: none;">
                    </div>
                    <div class="index_banner_form_box_input_1">
                        <div class="number">
                            <label for="Adult">Adult</label>
                            <span class="minus" onclick="changeValue('Adult', -0)"><i class="fa-solid fa-minus"></i></span>
                            <input type="text" name="adult" placeholder="No of Adult" id="Adult" value="{{ request()->get('adult') }}">
                            <span class="plus" onclick="changeValue('Adult', 0)"><i class="fa-solid fa-plus"></i></span>
                        </div>
                    </div>
                    <div class="index_banner_form_box_input_1">
                        <div class="number">
                            <label for="Children">Children</label>
                            <span class="minus" onclick="changeValue('Children', -0)"><i class="fa-solid fa-minus"></i></span>
                            <input type="text" name="children" placeholder="No of Children" id="Children" value="{{ request()->get('children') }}">
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
        @php 
            $cartItem = isset($cartRows[$listing->listings_id]) ? $cartRows[$listing->listings_id] : null;
            $isInCart = !is_null($cartItem);
            $savedRooms = $cartItem ? $cartItem->cart_rooms : 0;
            $savedPets = $cartItem ? $cartItem->cart_pets : 0;
            $savedLaundry = $cartItem ? $cartItem->cart_laundry : 'No';
            $savedLaundryQty = $cartItem ? ($cartItem->cart_laundry_qty ?? 1) : 1;
        @endphp
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
                    <div class="booking_card_box_htext">
                        <h6 class="heading">{{ $listing->listings_name }} <span>Recommended</span></h6>
                        <p class="sub_heading">Price ${{ number_format($listing->listings_price, 2) }} / Night</p>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-7 mb-3">
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
                        <div class="col-12 col-md-5 mb-3">
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

                        <!-- Form Options Bar -->
                        <div id="reserve-form-container-{{ $listing->listings_id }}" class="col-12">
                            <form class="reserve-form" id="reserve-form-{{ $listing->listings_id }}" action="{{ route('booking_cart', ['id' => $listing->listings_id]) }}" method="post">
                                @csrf
                                <input type="hidden" name="checkin" id="form_checkin_{{ $listing->listings_id }}" value="{{ request()->get('check_in') }}">
                                <input type="hidden" name="checkout" id="form_checkout_{{ $listing->listings_id }}" value="{{ request()->get('check_out') }}">
                                @php
                                    $petFeeAmount = isset($general_setting->pet_fee) ? number_format($general_setting->pet_fee, 2) : "25.00";
                                    $laundryFeeAmount = isset($general_setting->laundry_fee) ? number_format($general_setting->laundry_fee, 2) : "25.00";
                                @endphp

                                <div class="booking_options_bar">
                                    <!-- Row 1: Options Grid (Locked with overlay when reserved) -->
                                    <div class="options_grid {{ $isInCart ? 'reserved_locked' : '' }}" id="options-grid-{{ $listing->listings_id }}">
                                        
                                        <!-- Guest Tile -->
                                        <div class="control_tile">
                                            <h4 class="control_tile_title"><i class="fa-solid fa-users text-primary"></i> Guests</h4>
                                            <div style="display:flex; align-items:center; gap:6px; min-height:34px;">
                                                @for($i = 0; $i < ($listing->listings_number_of_persons ?? 1); $i++)
                                                <i class="fa-solid fa-user" style="color:#184E77; font-size:15px;"></i>
                                                @endfor
                                                <small style="color:#64748b; font-weight:600; margin-left:4px;">({{ $listing->listings_number_of_persons ?? 1 }} Max)</small>
                                            </div>
                                        </div>

                                        <!-- Beds Tile -->
                                        <div class="control_tile">
                                            <h4 class="control_tile_title"><i class="fa-solid fa-bed text-primary"></i> Beds</h4>
                                            <div style="display:flex; align-items:center; gap:8px; min-height:34px;">
                                                <span style="font-weight:700; font-size:14px; color:#1e293b; background:#fff; border:1px solid #cbd5e1; padding:4px 12px; border-radius:8px;">
                                                    {{ $listing->listings_number_of_beds ?? 1 }} {{ Str::plural('Bed', $listing->listings_number_of_beds ?? 1) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Laundry Tile (Inline Loads Counter) -->
                                        <div class="control_tile">
                                            <h4 class="control_tile_title">
                                                Laundry
                                                <span class="fee_badge fee_badge_blue">${{ $laundryFeeAmount }}/load</span>
                                            </h4>
                                            <div style="display:flex; align-items:center; gap:8px; min-height:34px;">
                                                <div class="radio_button_group">
                                                    <label class="custom_radio_btn {{ $savedLaundry == 'Yes' ? 'active' : '' }}">
                                                        <input type="radio" value="Yes" name="laundry" class="laundry-radio" data-listing="{{ $listing->listings_id }}" {{ $savedLaundry == 'Yes' ? 'checked' : '' }}>
                                                        Yes
                                                    </label>
                                                    <label class="custom_radio_btn {{ $savedLaundry != 'Yes' ? 'active' : '' }}">
                                                        <input type="radio" value="No" name="laundry" class="laundry-radio" data-listing="{{ $listing->listings_id }}" {{ $savedLaundry != 'Yes' ? 'checked' : '' }}>
                                                        No
                                                    </label>
                                                </div>
                                                <div id="laundry-qty-wrap-{{ $listing->listings_id }}" class="laundry-qty-wrap" style="display:{{ $savedLaundry == 'Yes' ? 'inline-block' : 'none' }};">
                                                    <div class="number">
                                                        <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                                        <input type="text" name="laundry_qty" id="laundry_qty_{{ $listing->listings_id }}" value="{{ $savedLaundryQty }}" maxlength="3" readonly required class="laundry-qty-input" data-listing-id="{{ $listing->listings_id }}">
                                                        <span class="plus"><i class="fa-solid fa-plus"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Pets Tile -->
                                        <div class="control_tile">
                                            <h4 class="control_tile_title">
                                                Pets
                                                <span class="fee_badge fee_badge_amber">${{ $petFeeAmount }}/pet</span>
                                            </h4>
                                            <div class="number">
                                                <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                                <input type="text" name="pets" value="{{ $savedPets }}" maxlength="3" readonly required class="pets-input" data-listing-id="{{ $listing->listings_id }}">
                                                <span class="plus"><i class="fa-solid fa-plus"></i></span>
                                            </div>
                                        </div>

                                        <!-- Room Tile -->
                                        <div class="control_tile">
                                            <h4 class="control_tile_title">Select Room</h4>
                                            <div class="number">
                                                <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                                <input type="text" name="room" value="{{ $savedRooms }}" maxlength="3" readonly required 
                                                       data-max="{{ $listing->listings_number_of_rooms ?? 1 }}" 
                                                       data-price="{{ $listing->listings_price }}"
                                                       data-listing-id="{{ $listing->listings_id }}"
                                                       class="room-input">
                                                <span class="plus"><i class="fa-solid fa-plus"></i></span>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Row 2: Actions Bar with Dynamic Estimated Total Box & Reserved/Unreserved Controls -->
                                    <div class="actions_bar">
                                        <div id="price-summary-{{ $listing->listings_id }}" class="price-summary-box" style="display:none; align-items:center; gap:10px; background:#f0f9ff; border:1px solid #bae6fd; padding:6px 16px; border-radius:30px;">
                                            <i class="fa-solid fa-calculator" style="color:#0284c7; font-size:16px;"></i>
                                            <div>
                                                <div style="font-size:13px; color:#0369a1; line-height:1.2;">
                                                    <strong>Estimated Total:</strong> <span id="price-calc-{{ $listing->listings_id }}" style="font-size:15px; font-weight:800; color:#184E77;">$0.00</span>
                                                </div>
                                                <small id="price-detail-{{ $listing->listings_id }}" style="display:block; color:#0284c7; font-size:11px; font-weight:600;"></small>
                                            </div>
                                        </div>

                                        <div style="display:flex; align-items:center; gap:12px; margin-left:auto; flex-wrap:wrap;">
                                            <a href="{{ url('room') }}" class="btn_read_more">Read More <i class="fa-solid fa-circle-chevron-right"></i></a>

                                            <!-- Unreserved Actions -->
                                            <div id="unreserved-actions-{{ $listing->listings_id }}" style="display: {{ $isInCart ? 'none' : 'flex' }}; align-items:center; gap:10px;">
                                                <button type="submit" class="btn_reserve_room reserve-btn" data-listing="{{ $listing->listings_id }}">
                                                    <span class="btn-text">Reserve Room</span> <i class="fa-solid fa-circle-chevron-right"></i>
                                                </button>
                                            </div>

                                            <!-- Reserved Actions (Reserved Badge Tag + Remove Button + Checkout Button) -->
                                            <div id="reserved-actions-{{ $listing->listings_id }}" style="display: {{ $isInCart ? 'flex' : 'none' }}; align-items:center; gap:10px; flex-wrap:wrap;">
                                                <span class="reserved_badge_tag">
                                                    <i class="fa-solid fa-circle-check"></i> Reserved
                                                </span>
                                                <button type="button" class="remove-cart-btn btn_remove_room" data-listing="{{ $listing->listings_id }}">
                                                    <i class="fa-solid fa-trash-can"></i> Remove
                                                </button>
                                                <a href="{{ url('checkout') }}" class="btn_checkout_room">
                                                    <i class="fa-solid fa-cart-shopping"></i> Checkout <i class="fa-solid fa-circle-chevron-right"></i>
                                                </a>
                                            </div>
                                        </div>
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
        // Laundry radio toggle quantity box & active styling
        document.querySelectorAll('.laundry-radio').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var listingId = this.dataset.listing;
                var wrap = document.getElementById('laundry-qty-wrap-' + listingId);
                
                // Toggle active class on custom radio labels
                var form = this.closest('form');
                if (form) {
                    form.querySelectorAll('.laundry-radio').forEach(function(r) {
                        var lbl = r.closest('.custom_radio_btn');
                        if (lbl) {
                            if (r.checked) {
                                lbl.classList.add('active');
                            } else {
                                lbl.classList.remove('active');
                            }
                        }
                    });
                }

                if (wrap) {
                    wrap.style.display = (this.value === 'Yes' && this.checked) ? 'inline-block' : 'none';
                }

                updatePriceForListing(listingId);
            });
        });

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

        // Room +/- with max limit
        document.querySelectorAll('.number').forEach(function(el) {
            var input = el.querySelector('input');
            if(!input) return;
            
            var minusBtn = el.querySelector('.minus');
            var plusBtn = el.querySelector('.plus');

            if(minusBtn) {
                minusBtn.addEventListener('click', function() {
                    setTimeout(function() {
                        var val = parseInt(input.value) || 0;
                        if (val < 0) { input.value = 0; }
                        var listingId = input.dataset.listingId || (input.closest('form') ? input.closest('form').id.replace('reserve-form-', '') : null);
                        if (listingId) updatePriceForListing(listingId);
                    }, 10);
                });
            }
            if(plusBtn) {
                plusBtn.addEventListener('click', function() {
                    var maxVal = parseInt(input.dataset.max) || 999;
                    setTimeout(function() {
                        var val = parseInt(input.value) || 0;
                        if (val > maxVal) { input.value = maxVal; }
                        var listingId = input.dataset.listingId || (input.closest('form') ? input.closest('form').id.replace('reserve-form-', '') : null);
                        if (listingId) updatePriceForListing(listingId);
                    }, 10);
                });
            }
        });

        // Price calculation including Rooms, Pets Total & Laundry Total
        function updatePriceForListing(listingId) {
            var form = document.getElementById('reserve-form-' + listingId);
            if (!form) return;
            
            var roomInput = form.querySelector('.room-input');
            if (!roomInput) return;

            var pricePerNight = parseFloat(roomInput.dataset.price) || 0;
            var rooms = parseInt(roomInput.value) || 0;
            
            var checkIn = document.getElementById('check_in').value;
            var checkOut = document.getElementById('check_out').value;
            var nights = 1;
            
            if (checkIn && checkOut) {
                var d1 = new Date(checkIn);
                var d2 = new Date(checkOut);
                var diff = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));
                if (diff > 0) nights = diff;
            }

            var petInput = form.querySelector('input[name="pets"]');
            var petsCount = parseInt(petInput ? petInput.value : 0) || 0;
            var petRate = parseFloat("{{ $general_setting->pet_fee ?? 25.00 }}") || 25;
            var petTotal = petsCount * petRate;

            var laundryRadio = form.querySelector('input[name="laundry"]:checked');
            var isLaundry = laundryRadio && laundryRadio.value === 'Yes';
            var laundryInput = form.querySelector('input[name="laundry_qty"]');
            var laundryCount = isLaundry ? (parseInt(laundryInput ? laundryInput.value : 1) || 1) : 0;
            var laundryRate = parseFloat("{{ $general_setting->laundry_fee ?? 25.00 }}") || 25;
            var laundryTotal = laundryCount * laundryRate;

            var roomTotal = pricePerNight * rooms * nights;
            var grandTotal = roomTotal + petTotal + laundryTotal;

            var summaryEl = document.getElementById('price-summary-' + listingId);
            var calcEl = document.getElementById('price-calc-' + listingId);
            var detailEl = document.getElementById('price-detail-' + listingId);

            if (rooms > 0) {
                summaryEl.style.display = 'inline-flex';
                calcEl.textContent = '$' + grandTotal.toFixed(2);
                
                var breakdown = rooms + ' room(s) × ' + nights + ' night(s)';
                if (petTotal > 0) {
                    breakdown += ' + $' + petTotal.toFixed(2) + ' pets (' + petsCount + ')';
                }
                if (laundryTotal > 0) {
                    breakdown += ' + $' + laundryTotal.toFixed(2) + ' laundry (' + laundryCount + ' load' + (laundryCount > 1 ? 's' : '') + ')';
                }
                detailEl.textContent = breakdown;
            } else {
                summaryEl.style.display = 'none';
            }
        }

        // Trigger price updates on page load for all listings
        document.querySelectorAll('.room-input').forEach(function(inp) {
            var id = inp.dataset.listingId;
            if (id) updatePriceForListing(id);
        });

        // Initialize Flatpickr on Check In & Check Out
        const checkInInput = document.getElementById('check_in');
        const checkOutInput = document.getElementById('check_out');

        if (checkInInput && checkOutInput) {
            const checkInPicker = flatpickr(checkInInput, {
                minDate: "today",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "M j, Y",
                onChange: function(selectedDates, dateStr, instance) {
                    document.querySelectorAll('[id^="form_checkin_"]').forEach(function(el) { el.value = dateStr; });
                    
                    if (selectedDates.length > 0) {
                        const nextDay = new Date(selectedDates[0]);
                        nextDay.setDate(nextDay.getDate() + 1);
                        checkOutPicker.set('minDate', nextDay);
                        
                        const currentCheckOut = checkOutPicker.selectedDates[0];
                        if (!currentCheckOut || currentCheckOut <= selectedDates[0]) {
                            checkOutPicker.setDate(nextDay);
                            
                            const nextDayStr = checkOutPicker.formatDate(nextDay, "Y-m-d");
                            document.querySelectorAll('[id^="form_checkout_"]').forEach(function(el) { el.value = nextDayStr; });
                        }
                    }
                    
                    document.querySelectorAll('.room-input').forEach(function(inp) {
                        var id = inp.dataset.listingId;
                        if (id) updatePriceForListing(id);
                    });
                }
            });

            const checkOutPicker = flatpickr(checkOutInput, {
                minDate: checkInPicker.selectedDates[0] 
                    ? new Date(new Date(checkInPicker.selectedDates[0]).getTime() + 24 * 60 * 60 * 1000)
                    : new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "M j, Y",
                onChange: function(selectedDates, dateStr, instance) {
                    document.querySelectorAll('[id^="form_checkout_"]').forEach(function(el) { el.value = dateStr; });
                    
                    document.querySelectorAll('.room-input').forEach(function(inp) {
                        var id = inp.dataset.listingId;
                        if (id) updatePriceForListing(id);
                    });
                }
            });

            if (checkInPicker.selectedDates.length > 0) {
                const checkInDate = checkInPicker.selectedDates[0];
                const nextDay = new Date(checkInDate);
                nextDay.setDate(nextDay.getDate() + 1);
                
                checkOutPicker.set('minDate', nextDay);
                
                const checkOutDate = checkOutPicker.selectedDates[0];
                if (!checkOutDate || checkOutDate <= checkInDate) {
                    checkOutPicker.setDate(nextDay);
                    
                    const nextDayStr = checkOutPicker.formatDate(nextDay, "Y-m-d");
                    document.querySelectorAll('[id^="form_checkout_"]').forEach(function(el) { el.value = nextDayStr; });
                    document.querySelectorAll('.room-input').forEach(function(inp) {
                        var id = inp.dataset.listingId;
                        if (id) updatePriceForListing(id);
                    });
                }
            }
        }

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
                        // Lock Row 1 with Overlay
                        var grid = document.getElementById('options-grid-' + listingId);
                        if (grid) grid.classList.add('reserved_locked');
                        
                        // Switch Actions in Row 2
                        document.getElementById('unreserved-actions-' + listingId).style.display = 'none';
                        document.getElementById('reserved-actions-' + listingId).style.display = 'flex';
                        
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
                        // Unlock Row 1 (Remove Overlay)
                        var grid = document.getElementById('options-grid-' + listingId);
                        if (grid) grid.classList.remove('reserved_locked');

                        // Reset room count if 0 so user can re-select
                        var form = document.getElementById('reserve-form-' + listingId);
                        if (form) {
                            var roomInp = form.querySelector('.room-input');
                            if (roomInp && parseInt(roomInp.value) === 0) {
                                roomInp.value = 1;
                            }
                        }

                        // Switch Actions in Row 2
                        document.getElementById('reserved-actions-' + listingId).style.display = 'none';
                        document.getElementById('unreserved-actions-' + listingId).style.display = 'flex';
                        
                        updatePriceForListing(listingId);

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