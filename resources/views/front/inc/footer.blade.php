            <footer class="footer_wrapper">
                <div class="container-fluid ps-6 pe-6">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                            <div class="footer_logo">
                                <img src="assets/front/images/logo.png" class="img-fluid" alt="">
                            </div>
                            <div class="footer_info">
                                <ul>
                                    <li><i class="fa-solid fa-envelope"></i><a href="mailto:info@mountainviewhope.com">info@mountainviewhope.com</a></li>
                                    <li><i class="fa-solid fa-phone"></i><a href="tel:+1 236-355-0999">+1 236-355-0999</a></li>
                                    <li><i class="fa-solid fa-location-dot"></i><span>504 Old Hope Princeton Way Hope, BC V0X 1L4 Canada</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 col-xxl-8">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                    <div class="footer_nav">
                                        <h6>Quick Links</h6>
                                        <ul>
                                            <li><a href="index.php">Home</a></li>
                                            <li><a href="about.php">About Us</a></li>
                                            <li><a href="room.php">rooms</a></li>
                                            <li><a href="booking.php">bookings</a></li>
                                            <li><a href="memberships.php">memberships</a></li>
                                            <li><a href="gallery.php">gallery</a></li>
                                            <li><a href="contact.php">Contact Us </a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 col-xxl-3">
                                    <div class="footer_nav">
                                        <h6>Resources</h6>
                                        <ul>
                                            <li><a href="#!">My account</a></li>
                                            <li><a href="term-condition.php">Terms & Condition</a></li>
                                            <li><a href="privacy.php">Privacy Policy</a></li>
                                            <li><a href="cookie-privacy.php">Cookie Policy</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                    <div class="footer_nav">
                                        <h6>Newsletter</h6>
                                        <p>Discover the Latest from Our motel mountain view</p>
                                        <div class="footer_nav_input">
                                            <input type="text" placeholder="Enter your email">
                                            <img src="assets/front/images/arrow_long.png" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="copyright">
                    <div class="container-fluid ps-6 pe-6">
                        <div class="copyright_flex">
                            <div class="copyright_text">
                                <p>© 2024 <span>motel mountain view</span>. All rights reserved</p>
                            </div>
                            <div class="copyright_text">
                                <p>Designed by <span>WebAppDevs</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>


<script src="assets/front/js/bootstrap.min.js"></script>
<script src="assets/front/js/jquery-3.6.3.min.js"></script>
<script src="assets/front/js/swiper-bundle.min.js"></script>
<script src="assets/front/js/gsap.min.js"></script>
<script src="assets/front/js/scrolltrigger.min.js"></script>
<script src="assets/front/js/scrollsmoother.min.js"></script>
<script src="assets/front/js/custom.js"></script>

<script>
function changeValue(id, step) {
    let input = document.getElementById(id);
    let value = input.value ? parseInt(input.value) : 0;
    let newValue = value + step;

    if (newValue >= 0) {
        input.value = newValue;
    }
}
</script>

<script>
    var swiper = new Swiper(".booking_slider1", {
      loop: true,
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".booking_slider2", {
      loop: true,
      spaceBetween: 10,
      effect: "fade",
      thumbs: {
        swiper: swiper,
      },
    });
  </script>
<script>
    var swiper = new Swiper(".booking_slider3", {
      loop: true,
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".booking_slider4", {
      loop: true,
      spaceBetween: 10,
      effect: "fade",
      thumbs: {
        swiper: swiper,
      },
    });
  </script>
<script>
    var swiper = new Swiper(".booking_slider5", {
      loop: true,
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".booking_slider6", {
      loop: true,
      spaceBetween: 10,
      effect: "fade",
      thumbs: {
        swiper: swiper,
      },
    });
  </script>
</body>
</html>