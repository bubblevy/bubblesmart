<!DOCTYPE html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>{{ $app[0]->name_app }} - {{ $title }}</title>
  <meta name="description" content="{{ $app[0]->description_app }}" />
  <link rel="icon" type="image/x-icon" href="@if(Storage::disk('public')->exists('logo-aplikasi')) {{ asset('storage/' . $app[0]->logo) }} @else {{ asset('assets/img/logo-aplikasi/logo.png') }} @endif" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/theme.css') }}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/pages/page-auth.css') }}" />
  <script src="{{ asset('assets/vendors/assets/vendor/js/helpers.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('assets/vendors/libs/sweetalert2/sweetalert.css') }}">
  <script src="{{ asset('assets/vendors/libs/sweetalert2/sweetalert.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('assets/css/toast.css') }}">
  <script src="{{ asset('assets/vendors/assets/js/config.js') }}"></script>
</head>

<body>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
            <div class="app-brand justify-content-center">
              <a href="/" class="app-brand-link gap-2">
                <img src="@if(Storage::disk('public')->exists('logo-aplikasi')) {{ asset('storage/' . $app[0]->logo) }} @else {{ asset('assets/img/logo-aplikasi/logo.png') }} @endif" class="h-auto bx-tada" style="width: 28px;" alt="Logo-{{ $app[0]->name_app }}"><span class="app-brand-text text-body fw-bolder text-primary" style="font-size: 1.7rem; font-family: 'Lobster', cursive; letter-spacing:1px;">{{ $app[0]->name_app }}</span>
              </a>
            </div>
            <h4 class="mb-2">Welcome Back!</h4>
            <p class="mb-3">Silahkan login dan mulai belajar.</p>
            <div class="flash-message" data-flash-message="@if(session()->has('loginError')) {{ session('loginError') }} @endif"></div>
            <div class="flash-message-register" data-flash-message="@if(session()->has('registerBerhasil')) {{ session('registerBerhasil') }} @endif"></div>
            <form id="formAuthentication" class="mb-3" action="/login" method="POST">
              @csrf
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" placeholder="Enter your username" autocomplete="off" required />
                @error('username')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="mb-4 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autocomplete="off" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3 divBtn" style="cursor: not-allowed;">
                <button class="btn btn-primary d-grid w-100 tombolLogin disabled" type="submit">Log in</button>
              </div>
            </form>
            <p class="text-center">
              <span>Belum punya akun?</span>
              <a href="/register">
                <span>Sign Up</span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/vendors/assets/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('assets/vendors/assets/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assets/vendors/assets/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/vendors/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assets/vendors/assets/vendor/js/menu.js') }}"></script>
  <script src="{{ asset('assets/vendors/assets/js/main.js') }}"></script>
  <script src="{{ asset('assets/vendors/js/buttons.js') }}"></script>
  <script src="{{ asset('assets/js/login.js') }}"></script>
</body>

</html>