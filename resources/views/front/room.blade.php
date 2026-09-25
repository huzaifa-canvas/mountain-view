@include('front.inc.header')

<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6>Rooms</h6>
        </div>
    </div>
</section>

<section class="room_wrapper">
    <div class="container">
        <div class="index_first_wrap_text">
            <h4 class="heading">Rooms</h4>
            <p class="desc w-60 mb-5">Choose from our thoughtfully designed room types, each offering modern amenities, cozy comfort, and everything you need for a relaxing stay.</p>
        </div>
        <div class="nav room_wrap_tabs nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-room1-tab" data-bs-toggle="tab" data-bs-target="#nav-room1" type="button" role="tab" aria-controls="nav-room1" aria-selected="true">Superior Queen Room</button>
            <button class="nav-link" id="nav-room2-tab" data-bs-toggle="tab" data-bs-target="#nav-room2" type="button" role="tab" aria-controls="nav-room2" aria-selected="false">Deluxe Family Room</button>
        </div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-room1" role="tabpanel" aria-labelledby="nav-room1-tab">
                <div class="room_wrap_inner_text">
                    <h6 class="heading mb-3">Superior Queen Room</h6>
                    <p class="desc mb-4">Experience the perfect blend of comfort and convenience in our Superior Queen Room, thoughtfully designed to meet all your travel needs. This spacious unit features two plush full-sized beds, ideal for families or groups seeking restful nights. Enjoy the luxury of air conditioning and soundproof walls, ensuring a peaceful retreat no matter the season.</p>
                    <p class="desc">Indulge in entertainment with a 60-inch flat-screen TV, complete with Netflix streaming and premium channels. Prepare your favorite meals in the private kitchenette, equipped with a refrigerator, microwave, and coffee machine, so you can enjoy the comforts of home during your stay. Step out onto the private balcony to take in serene garden views, adding a touch of tranquility to your visit. The private bathroom includes a relaxing bath, offering a spa-like experience after a day of exploring. With free WiFi, complimentary parking, and a strict no-smoking policy, the Superior Queen Room is your ultimate haven for relaxation and style.</p>
                </div>
                <div class="d-flex align-items-start justify-content-between amenities_tabs">
                    <div class="scroll_box">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-r1-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-r1-gallery-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r1-gallery" type="button" role="tab"
                                aria-controls="v-pills-r1-gallery" aria-selected="true">
                                <span>Photos</span>
                            </button>
                            <button class="nav-link" id="v-pills-r1-amenities-1-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r1-amenities-1" type="button" role="tab"
                                aria-controls="v-pills-r1-amenities-1" aria-selected="false">
                                <span>In Your Private Kitchenette</span>
                            </button>
                            <button class="nav-link" id="v-pills-r1-amenities-2-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r1-amenities-2" type="button" role="tab"
                                aria-controls="v-pills-r1-amenities-2" aria-selected="false">
                                <span>In Your Private Bathroom</span>
                            </button>
                            <button class="nav-link" id="v-pills-r1-amenities-3-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r1-amenities-3" type="button" role="tab"
                                aria-controls="v-pills-r1-amenities-3" aria-selected="false">
                                <span>View</span>
                            </button>
                            <button class="nav-link" id="v-pills-r1-amenities-4-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r1-amenities-4" type="button" role="tab"
                                aria-controls="v-pills-r1-amenities-4" aria-selected="false">
                                <span>Room Facilities</span>
                            </button>
                            <button class="nav-link" id="v-pills-r1-amenities-5-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r1-amenities-5" type="button" role="tab"
                                aria-controls="v-pills-r1-amenities-5" aria-selected="false">
                                <span>Smoking</span>
                            </button>
                        </div>
                    </div>
                    <div class="tab-content" id="v-pills-r1-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-r1-gallery" role="tabpanel"
                            aria-labelledby="v-pills-r1-gallery-tab">
                            @php
                                $rmListing = ($roomListings ?? collect())->get('superior-queen-room');
                                $rmImages  = $rmListing ? (json_decode($rmListing->listings_img, true) ?: []) : [];
                            @endphp
                            @if(count($rmImages))
                                <div class="room_gallery" data-room-gallery="superior-queen-room">
                                    <div class="swiper room_gallery_main room_gallery_main_superior-queen-room">
                                        <div class="swiper-wrapper">
                                            @foreach($rmImages as $rmImg)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/listing/' . $rmImg) }}"
                                                         alt="{{ $rmListing->listings_name }}"
                                                         loading="lazy" />
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-button-prev room_gallery_prev"></div>
                                        <div class="swiper-button-next room_gallery_next"></div>
                                    </div>
                                    @if(count($rmImages) > 1)
                                        <div class="swiper room_gallery_thumbs room_gallery_thumbs_superior-queen-room">
                                            <div class="swiper-wrapper">
                                                @foreach($rmImages as $rmImg)
                                                    <div class="swiper-slide">
                                                        <img src="{{ asset('storage/listing/' . $rmImg) }}"
                                                             alt="{{ $rmListing->listings_name }}"
                                                             loading="lazy" />
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="desc mb-0">Photos of this room are coming soon.</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="v-pills-r1-amenities-1" role="tabpanel"
                            aria-labelledby="v-pills-r1-amenities-1-tab">
                            <div class="amenities_box_main">
                                <p class="title">In Your Private Kitchenette</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_1.png') }}" alt="img"></span>
                                                <p>Refrigerator</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" alt="img"></span>
                                                <p>Tea/Coffe Maker</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_3.png') }}" alt="img"></span>
                                                <p>Electric Kettle</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" alt="img"></span>
                                                <p>Coffe Machine</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_4.png') }}" alt="img"></span>
                                                <p>Microwave</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-r1-amenities-2" role="tabpanel"
                            aria-labelledby="v-pills-r1-amenities-2-tab">
                            <div class="amenities_box_main">
                                <p class="title">In Your Private Bathroom</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_5.png') }}" alt="img"></span>
                                                <p>Free Toiletries</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_6.png') }}" alt="img"></span>
                                                <p>Toilet</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_7.png') }}" alt="img"></span>
                                                <p>Bathtub or Shower</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_8.png') }}" alt="img"></span>
                                                <p>Hairdryer</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_6.png') }}" alt="img"></span>
                                                <p>Guest Bathroom</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_9.png') }}" alt="img"></span>
                                                <p>Toilet Paper</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-r1-amenities-3" role="tabpanel"
                            aria-labelledby="v-pills-r1-amenities-3-tab">
                            <div class="amenities_box_main">
                                <p class="title">View</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_10.png') }}" alt="img"></span>
                                                <p>Balcony</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_11.png') }}" alt="img"></span>
                                                <p>Garden View</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_12.png') }}" alt="img"></span>
                                                <p>Mountain View</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-r1-amenities-4" role="tabpanel"
                            aria-labelledby="v-pills-r1-amenities-4-tab">
                            <div class="amenities_box_main">
                                <p class="title">Room Facilities</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_13.png') }}" alt="img"></span>
                                                <p>Carbon monoxide detector</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" alt="img"></span>
                                                <p>Coffee machine</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_14.png') }}" alt="img"></span>
                                                <p>Flat-screen TV</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_15.png') }}" alt="img"></span>
                                                <p>Alarm clock</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_16.png') }}" alt="img"></span>
                                                <p>Towels</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" alt="img"></span>
                                                <p>Tea/Coffee maker</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_4.png') }}" alt="img"></span>
                                                <p>Microwave</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_17.png') }}" alt="img"></span>
                                                <p>TV</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_1.png') }}" alt="img"></span>
                                                <p>Refrigerator</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_18.png') }}" alt="img"></span>
                                                <p>Linens</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_19.png') }}" alt="img"></span>
                                                <p>Streaming service (like Netflix)</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_20.png') }}" alt="img"></span>
                                                <p>Entire unit located on ground floor</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_21.png') }}" alt="img"></span>
                                                <p>Carpeted</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_22.png') }}" alt="img"></span>
                                                <p>Kitchenette</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_3.png') }}" alt="img"></span>
                                                <p>Electric kettle</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_23.png') }}" alt="img"></span>
                                                <p>Single-room AC for guest accommodation</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_28.png') }}" alt="img"></span>
                                                <p>Cable channels</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_24.png') }}" alt="img"></span>
                                                <p>Radio</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_25.png') }}" alt="img"></span>
                                                <p>Soundproof</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_23.png') }}" alt="img"></span>
                                                <p>Air conditioning</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_26.png') }}" alt="img"></span>
                                                <p>Hand sanitizer</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-r1-amenities-5" role="tabpanel"
                            aria-labelledby="v-pills-r1-amenities-5-tab">
                            <div class="amenities_box_main">
                                <p class="title">Smoking</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_27.png') }}" alt="img"></span>
                                                <p>No smoking</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-room2" role="tabpanel" aria-labelledby="nav-room2-tab">
                <div class="room_wrap_inner_text">
                    <h6 class="heading mb-3">Deluxe Family Room</h6>
                    <p class="desc mb-4">Welcome to the Deluxe Family Room, a spacious and serene accommodation perfect for couples or small families. Featuring a luxurious queen-sized bed, this room offers an inviting and restful atmosphere. Designed with your comfort in mind, the room includes air conditioning and soundproof walls, creating the ideal environment for relaxation.</p>
                    <p class="desc">Stay entertained with a 60-inch flat-screen TV offering Netflix streaming and premium channels, or savor a home-cooked meal in the private kitchenette equipped with a refrigerator, microwave, and coffee machine. Step out onto your private balcony to enjoy peaceful garden views, perfect for unwinding after a busy day. The private bathroom, complete with a bathtub, adds a touch of luxury to your stay. With free WiFi, complimentary parking, and a no-smoking policy, the Deluxe Family Room offers everything you need for a memorable and comfortable visit.</p>
                </div>
                <div class="d-flex align-items-start justify-content-between amenities_tabs">
                    <div class="scroll_box">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-r2-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-r2-gallery-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r2-gallery" type="button" role="tab"
                                aria-controls="v-pills-r2-gallery" aria-selected="true">
                                <span>Photos</span>
                            </button>
                            <button class="nav-link" id="v-pills-r2-amenities-1-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r2-amenities-1" type="button" role="tab"
                                aria-controls="v-pills-r2-amenities-1" aria-selected="false">
                                <span>In Your Private Kitchenette</span>
                            </button>
                            <button class="nav-link" id="v-pills-r2-amenities-2-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r2-amenities-2" type="button" role="tab"
                                aria-controls="v-pills-r2-amenities-2" aria-selected="false">
                                <span>In Your Private Bathroom</span>
                            </button>
                            <button class="nav-link" id="v-pills-r2-amenities-3-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r2-amenities-3" type="button" role="tab"
                                aria-controls="v-pills-r2-amenities-3" aria-selected="false">
                                <span>View</span>
                            </button>
                            <button class="nav-link" id="v-pills-r2-amenities-4-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r2-amenities-4" type="button" role="tab"
                                aria-controls="v-pills-r2-amenities-4" aria-selected="false">
                                <span>Room Facilities</span>
                            </button>
                            <button class="nav-link" id="v-pills-r2-amenities-5-tab" data-bs-toggle="pill"
                                data-bs-target="#v-pills-r2-amenities-5" type="button" role="tab"
                                aria-controls="v-pills-r2-amenities-5" aria-selected="false">
                                <span>Smoking</span>
                            </button>
                        </div>
                    </div>
                    <div class="tab-content" id="v-pills-r2-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-r2-gallery" role="tabpanel"
                            aria-labelledby="v-pills-r2-gallery-tab">
                            @php
                                $rmListing = ($roomListings ?? collect())->get('deluxe-family-room');
                                $rmImages  = $rmListing ? (json_decode($rmListing->listings_img, true) ?: []) : [];
                            @endphp
                            @if(count($rmImages))
                                <div class="room_gallery" data-room-gallery="deluxe-family-room">
                                    <div class="swiper room_gallery_main room_gallery_main_deluxe-family-room">
                                        <div class="swiper-wrapper">
                                            @foreach($rmImages as $rmImg)
                                                <div class="swiper-slide">
                                                    <img src="{{ asset('storage/listing/' . $rmImg) }}"
                                                         alt="{{ $rmListing->listings_name }}"
                                                         loading="lazy" />
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-button-prev room_gallery_prev"></div>
                                        <div class="swiper-button-next room_gallery_next"></div>
                                    </div>
                                    @if(count($rmImages) > 1)
                                        <div class="swiper room_gallery_thumbs room_gallery_thumbs_deluxe-family-room">
                                            <div class="swiper-wrapper">
                                                @foreach($rmImages as $rmImg)
                                                    <div class="swiper-slide">
                                                        <img src="{{ asset('storage/listing/' . $rmImg) }}"
                                                             alt="{{ $rmListing->listings_name }}"
                                                             loading="lazy" />
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <p class="desc mb-0">Photos of this room are coming soon.</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="v-pills-r2-amenities-1" role="tabpanel"
                            aria-labelledby="v-pills-r2-amenities-1-tab">
                            <div class="amenities_box_main">
                                <p class="title">In Your Private Kitchenette</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_1.png') }}" alt="img"></span>
                                                <p>Refrigerator</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" alt="img"></span>
                                                <p>Tea/Coffe Maker</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_3.png') }}" alt="img"></span>
                                                <p>Electric Kettle</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" alt="img"></span>
                                                <p>Coffe Machine</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_4.png') }}" alt="img"></span>
                                                <p>Microwave</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-r2-amenities-2" role="tabpanel"
                            aria-labelledby="v-pills-r2-amenities-2-tab">
                            <div class="amenities_box_main">
                                <p class="title">In Your Private Bathroom</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_5.png') }}" alt="img"></span>
                                                <p>Free Toiletries</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_6.png') }}" alt="img"></span>
                                                <p>Toilet</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_7.png') }}" alt="img"></span>
                                                <p>Bathtub or Shower</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_8.png') }}" alt="img"></span>
                                                <p>Hairdryer</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_6.png') }}" alt="img"></span>
                                                <p>Guest Bathroom</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_9.png') }}" alt="img"></span>
                                                <p>Toilet Paper</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-r2-amenities-3" role="tabpanel"
                            aria-labelledby="v-pills-r2-amenities-3-tab">
                            <div class="amenities_box_main">
                                <p class="title">View</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_10.png') }}" alt="img"></span>
                                                <p>Balcony</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_11.png') }}" alt="img"></span>
                                                <p>Garden View</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_12.png') }}" alt="img"></span>
                                                <p>Mountain View</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-r2-amenities-4" role="tabpanel"
                            aria-labelledby="v-pills-r2-amenities-4-tab">
                            <div class="amenities_box_main">
                                <p class="title">Room Facilities</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_13.png') }}" alt="img"></span>
                                                <p>Carbon monoxide detector</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" alt="img"></span>
                                                <p>Coffee machine</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_14.png') }}" alt="img"></span>
                                                <p>Flat-screen TV</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_15.png') }}" alt="img"></span>
                                                <p>Alarm clock</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_16.png') }}" alt="img"></span>
                                                <p>Towels</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" alt="img"></span>
                                                <p>Tea/Coffee maker</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_4.png') }}" alt="img"></span>
                                                <p>Microwave</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_17.png') }}" alt="img"></span>
                                                <p>TV</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_1.png') }}" alt="img"></span>
                                                <p>Refrigerator</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_18.png') }}" alt="img"></span>
                                                <p>Linens</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_19.png') }}" alt="img"></span>
                                                <p>Streaming service (like Netflix)</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_20.png') }}" alt="img"></span>
                                                <p>Entire unit located on ground floor</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_21.png') }}" alt="img"></span>
                                                <p>Carpeted</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_22.png') }}" alt="img"></span>
                                                <p>Kitchenette</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_3.png') }}" alt="img"></span>
                                                <p>Electric kettle</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_23.png') }}" alt="img"></span>
                                                <p>Single-room AC for guest accommodation</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_28.png') }}" alt="img"></span>
                                                <p>Cable channels</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_24.png') }}" alt="img"></span>
                                                <p>Radio</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_25.png') }}" alt="img"></span>
                                                <p>Soundproof</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_23.png') }}" alt="img"></span>
                                                <p>Air conditioning</p>
                                            </li>
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_26.png') }}" alt="img"></span>
                                                <p>Hand sanitizer</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-r2-amenities-5" role="tabpanel"
                            aria-labelledby="v-pills-r2-amenities-5-tab">
                            <div class="amenities_box_main">
                                <p class="title">Smoking</p>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <ul class="amenities_list">
                                            <li>
                                                <span><img src="{{ asset('assets/front/images/amenity_icon_27.png') }}" alt="img"></span>
                                                <p>No smoking</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="room_second_wrapper">
    <div class="container">
        <div class="room_second_wrap_ttext">
            <h6 class="heading mb-4">Most Popular Facilities</h6>
            <ul>
                <li><span><img src="{{ asset('assets/front/images/free-parking.png') }}" class="img-fluid" alt="" /></span> Free Parking</li>
                <li><span><img src="{{ asset('assets/front/images/wi-fi.png') }}" class="img-fluid" alt="" /></span> Free Wifi</li>
                <li><span><img src="{{ asset('assets/front/images/amenity_icon_27.png') }}" class="img-fluid" alt="" /></span> Non-smoking Rooms</li>
                <li><span><img src="{{ asset('assets/front/images/amenity_icon_2.png') }}" class="img-fluid" alt="" /></span> Tea/Coffee Maker in all rooms</li>
            </ul> 
        </div>
        <div class="room_sec_wrap_text_list">
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/amenity_icon_5.png') }}" class="img-fluid" alt="" /></span>Great For Your Stay</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Private Bathroom </li>
                    <li><i class="fa-solid fa-check"></i> Parking </li>
                    <li><i class="fa-solid fa-check"></i> Air conditioning </li>
                    <li><i class="fa-solid fa-check"></i> Free Wifi </li>
                    <li><i class="fa-solid fa-check"></i> Bathtub </li>
                    <li><i class="fa-solid fa-check"></i> Pet Friendly </li>
                    <li><i class="fa-solid fa-check"></i> Flat-screen TV </li>
                    <li><i class="fa-solid fa-check"></i> Non-smoking Rooms </li>
                    <li><i class="fa-solid fa-check"></i> Free Parking </li>
                    <li><i class="fa-solid fa-check"></i> Tour Desk </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/amenity_icon_7.png') }}" class="img-fluid" alt="" /></span>Bathroom</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Toilet Paper </li>
                    <li><i class="fa-solid fa-check"></i> Towels </li>
                    <li><i class="fa-solid fa-check"></i> Bathtub Or Shower</li>
                    <li><i class="fa-solid fa-check"></i> Private Bathroom </li>
                    <li><i class="fa-solid fa-check"></i> Toilet</li>
                    <li><i class="fa-solid fa-check"></i> free toiletries</li>
                    <li><i class="fa-solid fa-check"></i> Bathtub </li>
                    <li><i class="fa-solid fa-check"></i> Shower </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/bedroom.png') }}" class="img-fluid" alt="" /></span>Bedroom</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Linens </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/amenity_icon_12.png') }}" class="img-fluid" alt="" /></span>View</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Mountain View </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/amenity_icon_11.png') }}" class="img-fluid" alt="" /></span>Outdoor</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Garden </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/amenity_icon_22.png') }}" class="img-fluid" alt="" /></span> Kitchen</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Electric kettle </li>
                    <li><i class="fa-solid fa-check"></i> Microwave </li>
                    <li><i class="fa-solid fa-check"></i> Refrigerator </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/pawprint.png') }}" class="img-fluid" alt="" /></span> Pets</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Pets Are Allowed. Charges May Apply </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/amenity_icon_14.png') }}" class="img-fluid" alt="" /></span> Media & Technology</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Streaming Service (like Netfilix) </li>
                    <li><i class="fa-solid fa-check"></i> Flat-screen TV </li>
                    <li><i class="fa-solid fa-check"></i> TV </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/fast-food.png') }}" class="img-fluid" alt="" /></span> Food & Drink</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Tea/Coffee Maker </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/wi-fi.png') }}" class="img-fluid" alt="" /></span>Internet</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Wifi available in the rooms and is free to charge </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/free-parking.png') }}" class="img-fluid" alt="" /></span>Parking</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Free Private parking is available on <br> site (reservation is not needed) </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/public-service.png') }}" class="img-fluid" alt="" /></span>Services</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Pet Bowls </li>
                    <li><i class="fa-solid fa-check"></i> Daily housekeeping </li>
                    <li><i class="fa-solid fa-check"></i> Lockers </li>
                    <li><i class="fa-solid fa-check"></i> Private Check-in/out </li>
                    <li><i class="fa-solid fa-check"></i> Fax Photocopying </li>
                    <li><i class="fa-solid fa-check"></i> Tour Desk </li>
                    <li><i class="fa-solid fa-check"></i> Express Check-in/out </li>
                    <li><i class="fa-solid fa-check"></i> Laundry Additional Charges </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/public-service.png') }}" class="img-fluid" alt="" /></span>Front Desk Services</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Invoice Provided </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/security.png') }}" class="img-fluid" alt="" /></span>Safety & security</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Fire extinguishers </li>
                    <li><i class="fa-solid fa-check"></i> CCTV outside property </li>
                    <li><i class="fa-solid fa-check"></i> CCTV in common areas </li>
                    <li><i class="fa-solid fa-check"></i> Smoke Alarm </li>
                    <li><i class="fa-solid fa-check"></i> Security Alarm </li>
                    <li><i class="fa-solid fa-check"></i> Key access </li>
                    <li><i class="fa-solid fa-check"></i> 24-hour Security </li>
                    <li><i class="fa-solid fa-check"></i> Safe </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/information.png') }}" class="img-fluid" alt="" /></span> General</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Designated Smoking area </li>
                    <li><i class="fa-solid fa-check"></i> Air conditioning </li>
                    <li><i class="fa-solid fa-check"></i> Heating </li>
                    <li><i class="fa-solid fa-check"></i> Soundproof Rooms </li>
                    <li><i class="fa-solid fa-check"></i> non-smoking Rooms </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"> <span><img src="{{ asset('assets/front/images/assis.png') }}" class="img-fluid" alt="" /></span> Accessibility</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> Entire unit located on ground floor </li>
                </ul>
            </div>
            <div class="room_wrap_Feature_text">
                <h5 class="list_heading"><span><img src="{{ asset('assets/front/images/language.png') }}" class="img-fluid" alt="" /></span> Languages Spoken</h5>
                <ul>
                    <li><i class="fa-solid fa-check"></i> English </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<style>
    /*
     * The amenities panel is a flex item with the default `flex: 0 1 auto`, so
     * it shrink-wraps whatever is inside it. That is fine for lists of text,
     * but a Swiper sizes its slides from the container it is in, so the two
     * kept growing off each other until the panel measured 33 million pixels
     * and squeezed the pill column down to nothing. Giving the panel a zero
     * basis fixes its width first and breaks the loop.
     */
    .amenities_tabs > .scroll_box { flex: 0 0 auto; }
    .amenities_tabs > .tab-content { flex: 1 1 0; min-width: 0; }

    .room_gallery { width: 100%; min-width: 0; max-width: 100%; }
    .room_gallery .swiper { width: 100%; min-width: 0; max-width: 100%; }
    .room_gallery_main {
        border-radius: 14px; overflow: hidden; background: #EEF2F7;
    }
    .room_gallery_main .swiper-slide img {
        width: 100%; height: 380px; object-fit: cover; display: block;
    }
    .room_gallery_main .swiper-button-prev,
    .room_gallery_main .swiper-button-next {
        width: 38px; height: 38px; border-radius: 50%;
        background: rgba(255, 255, 255, .92); color: #184E77;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .18);
    }
    .room_gallery_main .swiper-button-prev::after,
    .room_gallery_main .swiper-button-next::after { font-size: 14px; font-weight: 800; }
    .room_gallery_thumbs { margin-top: 10px; }
    .room_gallery_thumbs .swiper-slide {
        border-radius: 9px; overflow: hidden; cursor: pointer;
        opacity: .5; transition: opacity .2s ease, box-shadow .2s ease;
    }
    .room_gallery_thumbs .swiper-slide img {
        width: 100%; height: 74px; object-fit: cover; display: block;
    }
    .room_gallery_thumbs .swiper-slide-thumb-active {
        opacity: 1; box-shadow: 0 0 0 2px #184E77;
    }
    @media (max-width: 767px) {
        .room_gallery_main .swiper-slide img { height: 230px; }
        .room_gallery_thumbs .swiper-slide img { height: 58px; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var galleries = {};

        document.querySelectorAll('[data-room-gallery]').forEach(function (gallery) {
            var slug = gallery.getAttribute('data-room-gallery');
            var thumbsEl = gallery.querySelector('.room_gallery_thumbs_' + slug);

            // Only build the thumbnail strip when the room has more than one
            // photo; Swiper errors on an empty thumbs element otherwise.
            var thumbs = thumbsEl ? new Swiper('.room_gallery_thumbs_' + slug, {
                spaceBetween: 10,
                slidesPerView: 4,
                watchSlidesProgress: true,
                observer: true,
                observeParents: true,
                breakpoints: { 768: { slidesPerView: 5 } }
            }) : null;

            galleries[slug] = new Swiper('.room_gallery_main_' + slug, {
                spaceBetween: 0,
                loop: true,
                // Each gallery lives inside a tab pane, and a pane that has
                // never been shown has no width to measure. Watching the DOM
                // lets Swiper lay itself out the moment its tab opens.
                observer: true,
                observeParents: true,
                navigation: {
                    nextEl: '.room_gallery_main_' + slug + ' .room_gallery_next',
                    prevEl: '.room_gallery_main_' + slug + ' .room_gallery_prev'
                },
                thumbs: thumbs ? { swiper: thumbs } : undefined
            });
        });

        // Belt and braces: recalculate when any tab on this page is revealed.
        document.querySelectorAll('[data-bs-toggle="tab"], [data-bs-toggle="pill"]').forEach(function (btn) {
            btn.addEventListener('shown.bs.tab', function () {
                Object.keys(galleries).forEach(function (slug) {
                    galleries[slug].update();
                    if (galleries[slug].thumbs && galleries[slug].thumbs.swiper) {
                        galleries[slug].thumbs.swiper.update();
                    }
                });
            });
        });
    });
</script>

@include('front.inc.footer')
