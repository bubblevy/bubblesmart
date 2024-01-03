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
  <style>
    .required-label::after {
      content: " *";
      color: red;
    }

    ::-webkit-scrollbar {
      width: 5px;
    }

    ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
      background: #696cff !important;
      border-radius: 6px;
    }
  </style>

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
            <h4 class="mb-2">Welcome to {{ $app[0]->name_app }}</h4>
            <p class="mb-3">Silahkan daftar dan mulai belajar.</p>
            <form id="formAuthentication" class="mb-3" action="/register" method="POST">
              @csrf
              <div class="mb-2">
                <label for="namaLengkap" class="form-label required-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="namaLengkap" name="name" value="{{ old('name') }}" placeholder="Enter your name" autocomplete="off" required />
                @error('name')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="mb-2">
                <label for="username" class="form-label label-username required-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Enter your username" value="{{ old('username') }}" autocomplete="off" required />
                @error('username')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @else
                <div class="form-text descUsername">Username minimal 5 karakter (Hanya boleh huruf & angka).</div>
                @enderror
              </div>
              <div class="mb-2">
                <label for="email" class="form-label label-email required-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" autocomplete="off" required>
                @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="mb-2">
                <label for="gender" class="form-label required-label">Jenis Kelamin</label>
                <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender" style="cursor: pointer;">
                  <option value="" disabled selected>Pilih Jenis Kelamin</option>
                  <option id="laki-laki" @if(old('gender')=='Laki-Laki' ) selected @endif value="Laki-Laki">Laki-Laki</option>
                  <option id="perempuan" @if(old('gender')=='Perempuan' ) selected @endif value="Perempuan">Perempuan</option>
                </select>
                @error('gender')
                <div class="invalid-feedback" style="margin-bottom: -3px;">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="mb-2 form-password-toggle">
                <label class="form-label required-label" for="password">Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autocomplete="off" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
                @error('password')
                <div class="form-text" style="color: #ff3e1d;">
                  {{ $message }}
                </div>
                @else
                <div class="form-text"><i class='bx bx-error' style="font-size: 100%;"></i>&nbsp;Password minimal 8 karakter termasuk huruf kapital & kecil (A-Z), (a-z), angka (1-9), dan karakter unik (@,#,%,dll)</div>
                @enderror
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label required-label" for="password2">Ulangi Password</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password2" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" autocomplete="off" required />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox" id="terms-conditions" name="terms">
                  <label class="form-check-label" for="terms-conditions">
                    Saya setuju dengan&nbsp;<a @error('terms') style="color:#ff3e1d;" @enderror href="/terms">syarat & ketentuan</a>
                  </label>
                </div>
              </div>
              <div class="mb-3 divBtn" style="cursor: not-allowed;">
                <button class="btn btn-primary d-grid w-100 tombolDaftar disabled" type="submit">Sign Up</button>
              </div>
            </form>
            <p class="text-center">
              <span>Sudah punya akun?</span>
              <a href="/login">
                <span>Log in</span>
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
  <script src="{{ asset('assets/js/register.js') }}"></script>
  <script src="{{ asset('assets/vendors/js/buttons.js') }}"></script>
</body>

</html>