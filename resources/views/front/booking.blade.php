@include('front.inc.header')


<section class="index_banner_wrapper booking_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6 class="mb-4">BOOKING</h6>
        </div> 
        <div class="index_banner_form_box_wrapper">
            <div class="index_banner_form_box">
                <div class="index_banner_form_box_input">
                    <label for="">Check in</label>
                    <input type="date">
                    <img src="assets/front/images/calendar_icon.png" class="img-fluid" alt="">
                </div>
                <div class="index_banner_form_box_input">
                    <label for="">Check Out</label>
                    <input type="date">
                    <img src="assets/front/images/calendar_icon.png" class="img-fluid" alt="">
                </div>
               <div class="index_banner_form_box_input_1">
                    <div class="number">
                        <label for="Adult">Adult</label>
                        <span class="minus" onclick="changeValue('Adult', -0)"><i class="fa-solid fa-minus"></i></span>
                        <input type="text" placeholder="No Of Adult" id="Adult" readonly>
                        <span class="plus" onclick="changeValue('Adult', 0)"><i class="fa-solid fa-plus"></i></span>
                    </div>
                </div>
                
                <div class="index_banner_form_box_input_1">
                    <div class="number">
                        <label for="Children">Children</label>
                        <span class="minus" onclick="changeValue('Children', -0)"><i class="fa-solid fa-minus"></i></span>
                        <input type="text" placeholder="No Of Children" id="Children" readonly>
                        <span class="plus" onclick="changeValue('Children', 0)"><i class="fa-solid fa-plus"></i></span>
                    </div>
                </div>
                <div class="index_banner_form_box_btn">
                    <a href="#!" class="common_dark_btn">SEARCH <i class="fa-solid fa-magnifying-glass"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="index_second_wrapper">
    <div class="container">
        @foreach($listings as $listing)
        <div class="booking_main_wrap">
            <div class="booking_card_box">
                <div class="booking_card_box_img">
                    <div class="swiper booking_slider2">
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
                        <div thumbsSlider="" class="swiper booking_slider1">
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
                        <p class="sub_heading">today’s Price ${{ $listing->listings_price }}</p>
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
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="booking_card_box_textm_f">
                                <div class="booking_card_box_text1f">
                                    <div class="booking_card_box_text1">
                                        <h4 class="heading">Number OF Guest</h4>
                                        <ul>
                                            <li><i class="fa-solid fa-user"></i></li>
                                            <li><i class="fa-solid fa-user"></i></li>
                                            <li><i class="fa-solid fa-user"></i></li>
                                        </ul>
                                    </div>
                                    <div class="booking_card_box_text1">
                                        <h4 class="heading">Need laundry?</h4>
                                        <div class="radio_buttonf">
                                            <label class="radio-button">
                                              <input type="radio" name="example-radio" value="Yes1">
                                              <span class="radio"></span>
                                              Yes
                                            </label>
                                            
                                            <label class="radio-button">
                                              <input type="radio" name="example-radio" value="No1">
                                              <span class="radio"></span>
                                              No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="booking_card_box_text1">
                                        <h4 class="heading mb-3">Have Pets?</h4>
                                        <div class="number">
                                            <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                            <input type="text" name="1" value="0" maxlength="3" readonly="">
                                            <span class="plus"><i class="fa-solid fa-plus"></i></span>
                                        </div>
                                    </div>
                                    <div class="booking_card_box_text1">
                                        <h4 class="heading mb-3">Select Room</h4>
                                        <div class="number">
                                            <span class="minus"><i class="fa-solid fa-minus"></i></span>
                                            <input type="text" name="1" value="0" maxlength="3" readonly="">
                                            <span class="plus"><i class="fa-solid fa-plus"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="booking_card_box_btns">
                                    <a href="#!" class="common_light_btn">Read More <i class="fa-solid fa-circle-chevron-right"></i></a>
                                    <a href="#!" class="common_dark_btn">Reserve Room <i class="fa-solid fa-circle-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

@include('front.inc.footer')
