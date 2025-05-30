@include('front.inc.header')
<section class="index_banner_wrapper inner_banner_wrapper">
    <div class="container">
        <div class="index_banner_wrap_text inner_banner_wrap">
            <h6>Contact Us</h6>
        </div>
    </div>
</section>


<section class="contact_wrapper">
    <div class="container">
        <div class="contact_wrap">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-5">
                    <div class="contact_wrap_text">
                        <h4 class="heading">Contact Us</h4>
                        <p class="desc">Need a map and form on left side with following fields</p>
                    </div>
                    <div class="form">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                <div class="form_field">
                                    <h6>First Name:</h6>
                                    <input type="text" name="first name" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                <div class="form_field">
                                    <h6>Last Name:</h6>
                                    <input type="text" name="last name" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                <div class="form_field">
                                    <h6>Email:</h6>
                                    <input type="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                <div class="form_field">
                                    <h6>Phone:</h6>
                                    <input type="number" name="number" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                <div class="form_field">
                                    <h6>Subject:</h6>
                                    <input type="text" name="subject" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                <div class="form_field">
                                    <h6>Message:</h6>
                                    <textarea name="message" required></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                <div class="form_field">
                                    <button class="common_dark_btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6 mb-5">
                    <div class="contact_wrap_map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1611.7800457407088!2d-121.43398826097922!3d49.37504083925206!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5483f5b6a8212b31%3A0xba7be2449593bfa5!2sMountain%20View%20Hope%20Motel!5e1!3m2!1sen!2s!4v1736986427995!5m2!1sen!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                    <div class="address_flex">
                        <a href="tel:+12363550999">
                            <i class="fa-solid fa-phone"></i>
                            <p>+1 236-355-0999</p>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                    <div class="address_flex">
                        <a href="#!">
                            <i class="fa-solid fa-location-dot"></i>
                            <p>504 Old Hope Princeton Way Hope, BC V0X 1L4 Canada</p>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                    <div class="address_flex">
                        <a href="mailto:customerservice@mountainviewhope.com">
                            <i class="fa-solid fa-envelope"></i>
                            <p>customerservice@mountainviewhope.com</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('front.inc.footer')
