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
        <div class="booking_main_wrap">
            <div class="booking_card_box">
                <div class="booking_card_box_img">
                    <div class="swiper booking_slider2">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img1.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img2.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img3.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img4.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img5.jpg" />
                          </div>
                        </div>
                    </div>
                    <div class="booking_slider1_wrap">
                        <div thumbsSlider="" class="swiper booking_slider1">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img1.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img2.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img3.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img4.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/superior_queen_img5.jpg" />
                          </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="booking_card_box_text_m">
                    <div class="booking_card_box_htext">
                        <h6 class="heading">Superior Queen Room <span>Recommended</span></h6>
                        <p class="sub_heading">today’s Price $150</p>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7 mb-3">
                            <div class="booking_card_box_text border_right">
                                <ul>
                                    <li><span>✓ </span>Free toiletries</li>
                                    <li><span>✓ </span>Streaming service</li>
                                    <li><span>✓ </span>Toilet</li>
                                    <li><span>✓ </span>Bathtub or shower</li>
                                    <li><span>✓ </span>Towels</li>
                                    <li><span>✓ </span>Linens</li>
                                    <li><span>✓ </span>TV</li>
                                    <li><span>✓ </span>Refrigerator</li>
                                    <li><span>✓ </span>Tea/Coffee maker</li>
                                    <li><span>✓ </span>Radio</li>
                                    <li><span>✓ </span>Microwave</li>
                                    <li><span>✓ </span>Hairdryer</li>
                                    <li><span>✓ </span>Kitchenette</li>
                                    <li><span>✓ </span>Guest bathroom</li>
                                    <li><span>✓ </span>Carpeted</li>
                                    <li><span>✓ </span>Electric kettle</li>
                                    <li><span>✓ </span>Outdoor furniture</li>
                                    <li><span>✓ </span>Cable channels</li>
                                    <li><span>✓ </span>Alarm clock</li>
                                    <li><span>✓ </span>Entire unit on ground floor</li>
                                    <li><span>✓ </span>Toilet paper</li>
                                    <li><span>✓ </span>Single-room AC</li>
                                    <li><span>✓ </span>Hand sanitizer</li>
                                    <li><span>✓ </span>Carbon monoxide detector</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5 mb-3">
                            <div class="booking_card_box_ul">
                                <ul>
                                    <li class="img_fix"><img src="assets/front/images/nico_1.png" class="img-fluid"> 28 m²</li>
                                    <li><img src="assets/front/images/nico_2.png" class="img-fluid"> Private kitchenette</li>
                                    <li><img src="assets/front/images/nico_3.png" class="img-fluid"> Private bathroom</li>
                                    <!--<li><img src="assets/front/images/nico_4.png" class="img-fluid"> Balcony</li>-->
                                    <li class="img_fix"><img src="assets/front/images/nico_11.png" class="img-fluid"> Free Wifi</li>
                                    <li><img src="assets/front/images/nico_6.png" class="img-fluid"> Mountain view</li>
                                </ul>
                                <ul>
                                    <li><img src="assets/front/images/nico_7.png" class="img-fluid"> Air conditioning</li>
                                    <li><img src="assets/front/images/nico_8.png" class="img-fluid"> Flat-screen TV</li>
                                    <li><img src="assets/front/images/nico_9.png" class="img-fluid"> Soundproof</li>
                                    <li><img src="assets/front/images/nico_10.png" class="img-fluid"> Coffee machine</li>
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
        <div class="booking_main_wrap">
            <div class="booking_card_box">
                <div class="booking_card_box_img">
                    <div class="swiper booking_slider4">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img1.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img2.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img3.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img4.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img5.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img6.jpg" />
                          </div>
                        </div>
                    </div>
                    <div class="booking_slider1_wrap">
                        <div thumbsSlider="" class="swiper booking_slider3">
                        <div class="swiper-wrapper">
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img1.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img2.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img3.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img4.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img5.jpg" />
                          </div>
                          <div class="swiper-slide">
                            <img src="assets/front/images/deluxe_family_img6.jpg" />
                          </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="booking_card_box_text_m">
                    <div class="booking_card_box_htext">
                        <h6 class="heading">Deluxe Family Room</h6>
                        <p class="sub_heading">today’s Price $200</p>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7">
                            <div class="booking_card_box_text border_right">
                                <ul>
                                    <li><span>✓ </span>Free toiletries</li>
                                    <li><span>✓ </span>Streaming service</li>
                                    <li><span>✓ </span>Toilet</li>
                                    <li><span>✓ </span>Bathtub or shower</li>
                                    <li><span>✓ </span>Towels</li>
                                    <li><span>✓ </span>Linens</li>
                                    <li><span>✓ </span>TV</li>
                                    <li><span>✓ </span>Refrigerator</li>
                                    <li><span>✓ </span>Tea/Coffee maker</li>
                                    <li><span>✓ </span>Radio</li>
                                    <li><span>✓ </span>Microwave</li>
                                    <li><span>✓ </span>Hairdryer</li>
                                    <li><span>✓ </span>Kitchenette</li>
                                    <li><span>✓ </span>Guest bathroom</li>
                                    <li><span>✓ </span>Carpeted</li>
                                    <li><span>✓ </span>Electric kettle</li>
                                    <li><span>✓ </span>Outdoor furniture</li>
                                    <li><span>✓ </span>Cable channels</li>
                                    <li><span>✓ </span>Alarm clock</li>
                                    <li><span>✓ </span>Entire unit on ground floor</li>
                                    <li><span>✓ </span>Toilet paper</li>
                                    <li><span>✓ </span>Single-room AC</li>
                                    <li><span>✓ </span>Hand sanitizer</li>
                                    <li><span>✓ </span>Carbon monoxide detector</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                            <div class="booking_card_box_ul">
                                <ul>
                                    <li class="img_fix"><img src="assets/front/images/nico_1.png" class="img-fluid"> 28 m²</li>
                                    <li><img src="assets/front/images/nico_2.png" class="img-fluid"> Private kitchenette</li>
                                    <li><img src="assets/front/images/nico_3.png" class="img-fluid"> Private bathroom</li>
                                    <!--<li><img src="assets/front/images/nico_4.png" class="img-fluid"> Balcony</li>-->
                                    <li class="img_fix"><img src="assets/front/images/nico_11.png" class="img-fluid"> Free Wifi</li>
                                    <li><img src="assets/front/images/nico_6.png" class="img-fluid"> Mountain view</li>
                                </ul>
                                <ul>
                                    <li><img src="assets/front/images/nico_7.png" class="img-fluid"> Air conditioning</li>
                                    <li><img src="assets/front/images/nico_8.png" class="img-fluid"> Flat-screen TV</li>
                                    <li><img src="assets/front/images/nico_9.png" class="img-fluid"> Soundproof</li>
                                    <li><img src="assets/front/images/nico_10.png" class="img-fluid"> Coffee machine</li>
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
    </div>
</section>

@include('front.inc.footer')
