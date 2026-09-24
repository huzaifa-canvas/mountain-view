@php
  $mvUser  = Auth::user();
  $mvName  = $mvUser->name ?? 'Admin';
  $mvInit  = collect(preg_split('/\s+/', trim($mvName)))
                ->filter()
                ->take(2)
                ->map(fn ($p) => mb_substr($p, 0, 1))
                ->implode('');
  $pageTitle = $pageTitle ?? 'Dashboard';
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="theme-color" content="#123A59">

  <title>{{ $pageTitle }} &middot; MountainView Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  {{-- Apply the saved theme before first paint so there is no flash of the wrong mode --}}
  <script>
    (function () {
      try {
        var saved = localStorage.getItem('mv-admin-theme');
        var theme = saved || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', theme);
      } catch (e) {}
    })();
  </script>

  <!-- Favicons -->
  <link rel="icon" href="{{ asset('assets/front/images/favicon.ico') }}">

  <!-- Google Fonts -->
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Base template + MountainView theme (theme.css must load last) -->
  <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/css/theme.css')}}?v=2" rel="stylesheet">

</head>

<body>

  <!-- ======= Topbar ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="mv-topbar">

      <i class="bi bi-list toggle-sidebar-btn" role="button" aria-label="Toggle navigation"></i>

      <h2 class="mv-topbar-title d-none d-sm-block">{{ $pageTitle }}</h2>

      <div class="mv-topbar-actions">

        <a href="{{ url('/') }}" target="_blank" class="mv-icon-btn d-none d-sm-inline-flex" title="View website">
          <i class="bi bi-box-arrow-up-right"></i>
        </a>

        <button type="button" class="mv-icon-btn" data-mv-theme-toggle title="Toggle dark mode" aria-label="Toggle dark mode">
          <i class="bi bi-moon-stars" data-mv-theme-icon></i>
        </button>

        <div class="dropdown">
          <a class="mv-topbar-user" href="#" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="mv-avatar">{{ $mvInit ?: 'A' }}</span>
            <span class="d-none d-md-block">{{ $mvName }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li class="dropdown-header">
              <h6>{{ $mvName }}</h6>
              <span>Administrator</span>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/profile') }}">
                <i class="bi bi-person"></i><span>My Profile</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/global-setting') }}">
                <i class="bi bi-gear"></i><span>Global Settings</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/cache-clear') }}">
                <i class="bi bi-arrow-repeat"></i><span>Clear Cache</span>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('logout') }}">
                <i class="bi bi-box-arrow-right"></i><span>Sign Out</span>
              </a>
            </li>
          </ul>
        </div>

      </div>
    </div>
  </header><!-- End Topbar -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <a href="{{ url('admin/dashboard') }}" class="mv-brand">
      <span class="mv-brand-logo">
        <img src="{{ asset('assets/front/images/logo.png') }}" alt="Mountain View Hope Motel">
      </span>
      <span class="mv-brand-sub">Admin Panel</span>
    </a>

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin') || request()->is('admin/dashboard') ? '' : 'collapsed' }}" href="{{url('admin/dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/listings*') ? '' : 'collapsed' }}" href="{{ url('admin/listings') }}">
          <i class="bi bi-door-open"></i>
          <span>Listings</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/members*') ? '' : 'collapsed' }}" href="{{ route('admin.members.index') }}">
          <i class="bi bi-people"></i>
          <span>Members</span>
        </a>
      </li>

      <li class="nav-heading">Bookings &amp; Orders</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/orders') || (request()->is('admin/orders/*') && !request()->is('admin/orders/calendar*')) ? '' : 'collapsed' }}" href="{{ route('admin.orders.index') }}">
          <i class="bi bi-cart-check"></i>
          <span>Orders List</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/orders/calendar*') ? '' : 'collapsed' }}" href="{{ route('admin.orders.calendar') }}">
          <i class="bi bi-calendar-event"></i>
          <span>Calendar View</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/feedbacks*') ? '' : 'collapsed' }}" href="{{ route('admin.feedbacks.index') }}">
          <i class="bi bi-chat-square-text"></i>
          <span>Guest Feedbacks</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/email-templates*') ? '' : 'collapsed' }}" href="{{ route('admin.emails.index') }}">
          <i class="bi bi-envelope"></i>
          <span>Email Templates</span>
        </a>
      </li>

      <li class="nav-heading">General Setting</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/global-setting*') ? '' : 'collapsed' }}" href="{{url('admin/global-setting')}}">
          <i class="bi bi-sliders"></i>
          <span>Global Setting</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/profile*') ? '' : 'collapsed' }}" href="{{ url('admin/profile') }}">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>

    </ul>

    <div class="mv-side-foot">
      <div class="mv-side-user">
        <span class="mv-avatar">{{ $mvInit ?: 'A' }}</span>
        <div class="min-w-0">
          <div class="mv-side-user-name">{{ $mvName }}</div>
          <div class="mv-side-user-role">Administrator</div>
        </div>
      </div>

      <button type="button" class="mv-theme-toggle" data-mv-theme-toggle>
        <span class="mv-switch"></span>
        <span>Dark mode</span>
      </button>

      <a href="{{ url('logout') }}" class="mv-side-signout">Sign out</a>
    </div>

  </aside><!-- End Sidebar -->

  <div class="mv-backdrop" data-mv-backdrop></div>
