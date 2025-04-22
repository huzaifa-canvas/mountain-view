<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mountain View Hope</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <meta name="robots" content="noindex" />
	<link rel="icon" href="assets/front/images/favicon.ico">
    <link rel="stylesheet" href="assets/front/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/front/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <link rel="stylesheet" href="assets/front/css/main.css">
    <link rel="stylesheet" href="assets/front/css/responsive.css">
</head>
<body>
    <div id="smooth-wrapper">
        <div id="smooth-content">
            <header class="header_wrapper">
                <div class="container-fluid ps-6 pe-6">
                    <div class="header_flex">
                        <div class="header_logo">
                            <a href="index.php"><img src="assets/front/images/logo.png" class="img-fluid" alt=""></a>
                        </div>
                        <div class="header_inner_flex">
                            <div class="header_nav">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="about.php">About Us</a></li>
                                    <li><a href="room.php">Rooms</a></li>
                                    <li><a href="{{ url('booking') }}">Bookings</a></li>
                                    <li><a href="memberships.php">Memberships</a></li>
                                    <li><a href="{{ url('gallery') }}">Gallery</a></li>
                                    <li><a href="contact.php">Contact Us</a></li>
                                </ul>
                            </div>
                            <div class="header_btn">
                                <a href="#!" class="common_dark_btn">Book Now <i class="fa-solid fa-circle-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>