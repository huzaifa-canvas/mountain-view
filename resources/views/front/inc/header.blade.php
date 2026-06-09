<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mountain View Hope</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <meta name="robots" content="noindex" />
    <link rel="icon" href="{{ asset('assets/front/images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/front/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/responsive.css') }}">
    <style>
        .header_nav ul li a.active {
            color: var(--primary_color, #000);
            font-weight: 700;
        }
        .header_nav ul li a.active::before {
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="smooth-wrapper">
        <div id="smooth-content">
            <header class="header_wrapper">
                <div class="container-fluid ps-6 pe-6">
                    <div class="header_flex">
                        <div class="header_logo">
                            <a href="{{ url('/') }}"><img src="{{ asset('assets/front/images/logo.png') }}" class="img-fluid" alt=""></a>
                        </div>
                        <div class="header_inner_flex">
                            <div class="header_nav">
                                <ul>
                                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                                    <li><a href="{{ url('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About Us</a></li>
                                    <li><a href="{{ url('room') }}" class="{{ request()->is('room') || request()->is('booking') ? 'active' : '' }}">Rooms</a></li>
                                    <li><a href="{{ url('memberships') }}" class="{{ request()->is('memberships') ? 'active' : '' }}">Memberships</a></li>
                                    <li><a href="{{ url('gallery') }}" class="{{ request()->is('gallery') ? 'active' : '' }}">Gallery</a></li>
                                    <li><a href="{{ url('contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact Us</a></li>
                                </ul>
                            </div>
                            <div class="header_btn">
                                <a href="{{ url('booking') }}" class="common_dark_btn">Book Now <i class="fa-solid fa-circle-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>