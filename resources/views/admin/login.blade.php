<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="theme-color" content="#123A59">

  <title>Sign in &middot; MountainView Admin</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

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

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

  <!-- Base template + MountainView theme -->
  <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
  <link href="{{asset('assets/admin/css/theme.css')}}?v=2" rel="stylesheet">

  <style>
    .mv-login {
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr;
      background: var(--mv-bg);
    }
    @media (min-width: 992px) {
      .mv-login { grid-template-columns: 1.05fr 1fr; }
    }

    /* Left-hand brand panel — hidden on small screens */
    .mv-login-aside {
      display: none;
      position: relative;
      overflow: hidden;
      padding: 56px 60px;
      color: #DCE8F2;
      background: linear-gradient(160deg, #123A59 0%, #0A1F33 100%);
    }
    @media (min-width: 992px) {
      .mv-login-aside { display: flex; flex-direction: column; justify-content: space-between; }
    }
    .mv-login-aside::after {
      content: "";
      position: absolute;
      bottom: -120px;
      right: -110px;
      width: 420px;
      height: 420px;
      border-radius: 50%;
      background-image: radial-gradient(circle at 50% 50%, rgba(214, 227, 239, .12) 0%, transparent 70%);
      pointer-events: none;
    }
    .mv-login-aside > * { position: relative; z-index: 1; }
    .mv-login-quote {
      font-family: "Plus Jakarta Sans", system-ui, sans-serif;
      font-size: 2.1rem;
      line-height: 1.3;
      font-weight: 600;
      max-width: 15ch;
    }
    .mv-login-note { color: #9BB3C8; font-size: .9rem; max-width: 40ch; }

    .mv-login-form {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
    }
    .mv-login-card { width: 100%; max-width: 420px; }
    .mv-login-title { font-size: 1.75rem; margin-bottom: 6px; }
    .mv-login-sub { color: var(--mv-muted); font-size: .92rem; margin-bottom: 26px; }

    .mv-login-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 30px; }

    .mv-login-toggle {
      position: fixed;
      top: 18px;
      right: 18px;
      z-index: 5;
    }
  </style>
</head>

<body>

  <button type="button" class="mv-icon-btn mv-login-toggle" data-mv-theme-toggle title="Toggle dark mode" aria-label="Toggle dark mode">
    <i class="bi bi-moon-stars" data-mv-theme-icon></i>
  </button>

  <main class="mv-login">

    <aside class="mv-login-aside">
      <div class="mv-brand" style="padding:0;border:0;">
        <span class="mv-brand-logo">
          <img src="{{ asset('assets/front/images/logo.png') }}" alt="Mountain View Hope Motel">
        </span>
        <span class="mv-brand-sub">Admin Panel</span>
      </div>

      <p class="mv-login-quote">Every booking, room and guest in one place.</p>

      <p class="mv-login-note">
        Manage listings, track bookings and payments, and follow up with guests — all from a single dashboard.
      </p>
    </aside>

    <section class="mv-login-form">
      <div class="mv-login-card">

        <div class="mv-login-brand d-lg-none">
          <img src="{{ asset('assets/front/images/logo.png') }}" alt="Mountain View Hope Motel" style="max-width:200px;height:auto;">
        </div>

        <h1 class="mv-login-title">Welcome back</h1>
        <p class="mv-login-sub">Sign in with your administrator credentials to continue.</p>

        @if($errors->any())
          <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ $errors->first() }}
          </div>
        @endif
        @if(session('error'))
          <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
          </div>
        @endif

        <div class="card">
          <div class="card-body">
            <form method="post" action="{{url('auth')}}" class="row g-3">
              @csrf

              <div class="col-12">
                <label for="yourEmail" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="yourEmail"
                       value="{{ old('email') }}" autocomplete="username" required autofocus>
              </div>

              <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="yourPassword"
                       autocomplete="current-password" required>
              </div>

              <div class="col-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                  <label class="form-check-label" for="rememberMe" style="font-size:.88rem;color:var(--mv-text-2);">Keep me signed in</label>
                </div>
              </div>

              <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">
                  <i class="bi bi-box-arrow-in-right me-1"></i> Sign in
                </button>
              </div>
            </form>
          </div>
        </div>

        <p class="text-center mv-cell-sub mt-3 mb-0">
          &copy; {{ date('Y') }} Mountain View Hope Motel. All rights reserved.
        </p>

      </div>
    </section>

  </main>

  <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script>
    (function () {
      var root = document.documentElement;
      var STORE_KEY = 'mv-admin-theme';

      function syncIcons(theme) {
        document.querySelectorAll('[data-mv-theme-icon]').forEach(function (icon) {
          icon.className = theme === 'dark' ? 'bi bi-sun' : 'bi bi-moon-stars';
        });
      }

      syncIcons(root.getAttribute('data-theme') || 'light');

      document.addEventListener('click', function (e) {
        if (!e.target.closest('[data-mv-theme-toggle]')) return;
        var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        root.setAttribute('data-theme', next);
        try { localStorage.setItem(STORE_KEY, next); } catch (err) {}
        syncIcons(next);
      });
    })();
  </script>

</body>

</html>
