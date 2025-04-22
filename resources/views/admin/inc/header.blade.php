<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - MountainView</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('assets/front/images/favicon.png') }}">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/multi/multi-style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="{{url('admin/dashboard')}}" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">YoloElite Admin Panel</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
      <a href="{{url('admin/cache-clear')}}" class="btn btn-danger ms-3">
        Clear Cache
      </a>
    </div><!-- End Logo -->

   

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <!-- End Search Icon-->


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{Auth::user()->name}}</h6>
              <span>Admin</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{url('logout')}}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{url('admin/dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Page & Content Management</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{url('admin/homepage')}}">
              <i class="bi bi-circle"></i><span>HomePage</span>
            </a>
          </li>
          <li>
            <a href="{{url('admin/founder-page')}}">
              <i class="bi bi-circle"></i><span>Founder Page</span>
            </a>
          </li>
          <li>
            <a href="{{url('admin/teams')}}">
              <i class="bi bi-circle"></i><span>Teams</span>
            </a>
          </li>
          <a href="{{url('admin/services')}}">
            <i class="bi bi-circle"></i><span>Services</span>
          </a>
        </li>
          <li>
            <a href="{{url('admin/videos')}}">
              <i class="bi bi-circle"></i><span>Videos</span>
            </a>
          </li>
         
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('admin/memberships') }}">
          <i class="bi bi-person"></i>
          <span>Memberships</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('admin/providers') }}">
          <i class="bi bi-bag"></i>
          <span>Providers</span>
        </a>
      </li>
      <!-- End Forms Nav -->


      <li class="nav-heading">General Setting</li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('admin/global-setting')}}">
          <i class="bi bi-gear"></i>
          <span>Global Setting</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('admin/profile') }}">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->


    </ul>

  </aside><!-- End Sidebar-->