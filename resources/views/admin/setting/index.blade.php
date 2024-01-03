@extends('layouts.main.index')
@section('container')
@section('style')
<style>
  .required-label::after {
    content: " *";
    color: red;
  }
</style>
@endsection
<div class="infoupdate" data-user-updated="@if(session()->has('updateUserBerhasil')) {{ session('updateUserBerhasil') }} @endif" data-update-app="@if(session()->has('updateAppBerhasil')) {{ session('updateAppBerhasil') }} @endif"></div>
<div class="infoupdatepass" data-pass-lama-failed="@if(session()->has('passwordLamaSalah')) {{ session('passwordLamaSalah') }} @endif" data-updated-pass="@if(session()->has('passwordUpdateSuccess')) {{ session('passwordUpdateSuccess') }} @endif"></div>
<div class="row">
  <div class="col-md-12">
    <div class="nav-align-top">
      <ul class="nav nav-fill nav-tabs col-lg-4" role="tablist">
        <li class="nav-item">
          <button type="button" class="nav-link @unless ($errors->has('passwordLama') || $errors->has('passwordBaru') || session()->has('passwordLamaSalah') || $errors->has('logo') || $errors->has('name_app') || $errors->has('description_app') || session()->has('updateAppBerhasil')) active @endunless" role="tab" data-bs-toggle="tab" data-bs-target="#navs-profil" aria-controls="navs-profil"><i class="tf-icons bx bxs-user fs-6 me-1" style="margin-bottom: 2px;"></i>&nbsp;Profil</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link @if($errors->has('passwordLama') || $errors->has('passwordBaru') || session()->has('passwordLamaSalah')) active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-akun" aria-controls="navs-akun"><i class="tf-icons bx bxs-lock-alt fs-6 me-1" style="margin-bottom: 3px;"></i>&nbsp;Akun</button>
        </li>
        <li class="nav-item">
          <button type="button" class="nav-link @if($errors->has('logo') || $errors->has('name_app') || $errors->has('description_app') || session()->has('updateAppBerhasil')) active @endif" role="tab" data-bs-toggle="tab" data-bs-target="#navs-aplikasi" aria-controls="navs-aplikasi"><i class="tf-icons bx bxs-wrench fs-6 me-1" style="margin-bottom: 3px;"></i>&nbsp;Aplikasi</button>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane fade @unless ($errors->has('passwordLama') || $errors->has('passwordBaru') || session()->has('passwordLamaSalah') || $errors->has('logo') || $errors->has('name_app') || $errors->has('description_app') || session()->has('updateAppBerhasil')) show active @endunless" id="navs-profil" role="tabpanel">
          <h5 class="card-header" style="margin-top: -0.5rem;">Profil Saya</h5>
          <p style="padding-left: 1.5rem; margin-top:-1.3rem; margin-bottom:-5px;">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun
          </p>
          <!-- Profile  -->
          <div class="card-body">
            <form id="formAccountSettings" action="/admin/pengaturan" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img src="@if(Storage::disk('public')->exists(auth()->user()->image)) {{ asset('storage/'. auth()->user()->image) }} @else {{ asset('assets/img/'. auth()->user()->image) }} @endif" alt="profile" class="d-block rounded cursor-pointer fotoProfile" height="100" width="100" id="uploadedPhotoProfil" data-url-img="@if(Storage::disk('public')->exists('profil-images')) {{ asset('storage/'. auth()->user()->image) }} @else {{ asset('assets/img/'. auth()->user()->image) }} @endif" />
                <div class="button-wrapper">
                  <label for="upload" class="btn btn-outline-primary me-2 mb-4" tabindex="0">
                    <span><i class="bx bx-image-alt fs-6" style="margin-bottom: 2px;"></i>&nbsp;Upload</span>
                    <input type="file" name="image" id="upload" class="account-file-input" hidden />
                  </label>
                  @error('image')<div style="color: #ff3e1d; font-size:80%; margin-top:0.3rem;">{{ $message }}</div>@else
                  <p class="text-muted mb-0" style="margin-top: -5px;">Ukuran maks 500 KB dengan rasio 1:1. Format: JPG, PNG, JPEG.</p>@enderror
                </div>
              </div>
          </div>
          <hr class="my-0">
          <div class="card-body">
            <div class="row mb-2 mb-lg-3">
              <label class="col-sm-2 col-form-label" for="namaLengkap">Nama Lengkap</label>
              <div class="col-sm-10">
                <input type="text" class="form-control  @error('name') is-invalid @enderror" id="namaLengkap" name="name" autocomplete="off" placeholder="Enter your name" value="{{ old('name') ?? auth()->user()->name}}" />
                @error('name') <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div> @enderror
              </div>
            </div>
            <div class="row mb-2 mb-lg-3">
              <label class="col-sm-2 col-form-label" for="username">Username</label>
              <div class="col-sm-10">
                <input type="text" class="form-control  @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') ?? auth()->user()->username }}" autocomplete="off" />
                @error('username') <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div> @enderror
              </div>
            </div>
            <div class="row mb-2 mb-lg-3">
              <label class="col-sm-2 col-form-label" for="email">Email&nbsp;<i class='bx bx-edit fs-6 text-primary buttonEditEmailUser' data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Edit Email"></i></label>
              <div class="col-sm-10">
                <input type="email" id="email" class="form-control" name="email" autocomplete="off" placeholder="Enter your email" disabled value="{{ substr(auth()->user()->email, 0, 3) . str_repeat('*', strlen(substr(auth()->user()->email, 0, strpos(auth()->user()->email, '@'))) - 3) . substr(auth()->user()->email, -10)}}" />
              </div>
            </div>
            <div class="row mb-2 mb-lg-3">
              <label class="col-sm-2 col-form-label" for="jenisKelamin">Jenis Kelamin</label>
              <div class="col-sm-10">
                <div class="form-check form-check-inline" style="margin-top: 5px;">
                  <input class="form-check-input" type="radio" name="gender" id="lakiLaki" value="Laki-Laki" @if(auth()->user()->gender == 'Laki-Laki') checked @endif />
                  <label class="form-check-label" for="lakiLaki">Laki-Laki</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="perempuan" value="Perempuan" @if(auth()->user()->gender == 'Perempuan') checked @endif />
                  <label class="form-check-label" for="perempuan">Perempuan</label>
                </div>
                @error('gender') <div style="color: #ff3e1d; font-size:80%; margin-top:0.3rem;">{{ $message }}</div> @enderror
              </div>
            </div>
            <div class="row mb-2 mb-lg-3">
              <label class="col-sm-2 col-form-label" for="tanggalLahir">Tanggal Lahir</label>
              <div class="col-sm-10">
                <input type="date" id="tanggalLahir" name="tanggal_lahir" class="form-control" @if(old('tanggal_lahir')) value="{{ date('Y-m-d', strtotime(old('tanggal_lahir'))) }}" @endif @if(auth()->user()->tanggal_lahir) value="{{ date('Y-m-d', strtotime(auth()->user()->tanggal_lahir)) }}" @endif />
              </div>
            </div>
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
              <div class="col-sm-10">
                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" autocomplete="off" placeholder="Masukkan alamat tempat tinggal Anda yang sekarang. (max 255 karakter)" rows="3">{{ auth()->user()->alamat ?? old('alamat') }}</textarea>
                @error('alamat') <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div> @enderror
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save fs-6" style="margin-bottom: 2px;"></i>&nbsp;Simpan</button>
              </div>
            </div>
            </form>
          </div>
        </div>

        <div class="tab-pane fade @if($errors->has('passwordLama') || $errors->has('passwordBaru') || session()->has('passwordLamaSalah')) show active @endif" id="navs-akun" role="tabpanel">
          <h5 class="card-header" style="margin-top: -0.5rem;">Ubah Password</h5>
          <p style="padding-left: 1.5rem; margin-top:-1.3rem; margin-bottom:-5px;">Kelola informasi data Anda untuk mengontrol, melindungi dan mengamankan akun
          </p>
          <!-- Akun  -->
          <form id="formAccount" action="/admin/pengaturan/changepassword" method="POST">
            @csrf
            <div class="card-body">
              <div class="row mb-2 mb-lg-3">
                <label class="col-sm-2 col-form-label required-label" for="passwordLama">Password Lama</label>
                <div class="col-sm-10 col-md-4">
                  <input type="password" class="form-control  @error('passwordLama') is-invalid @enderror" id="passwordLama" name="passwordLama" autocomplete="off" />
                  @error('passwordLama') <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div> @enderror
                </div>
              </div>
              <div class="row mb-2 mb-lg-3">
                <label class="col-sm-2 col-form-label required-label" for="passwordBaru">Password Baru</label>
                <div class="col-sm-10 col-md-4">
                  <input type="password" class="form-control  @error('passwordBaru') is-invalid @enderror" id="passwordBaru" name="passwordBaru" autocomplete="off" />
                  @error('passwordBaru')<div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div>@enderror
                  <div class="form-text @error('passwordBaru') d-none @enderror"><i class='bx bx-error' style="font-size: 100%;"></i>&nbsp;Password minimal 8 karakter termasuk huruf kapital & kecil (A-Z), (a-z), angka (1-9), dan karakter unik (@,#,%,dll)</div>
                </div>
              </div>
              <div class="row mb-4">
                <label class="col-sm-2 col-form-label required-label" for="ulangiPasswordBaru">Ulangi Password Baru</label>
                <div class="col-sm-10 col-md-4">
                  <input type="password" class="form-control" id="ulangiPasswordBaru" name="passwordBaru_confirmation" autocomplete="off" />
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary"><i class="bx bx-save fs-6" style="margin-bottom: 2px;"></i>&nbsp;Simpan</button>
                </div>
              </div>
            </div>
          </form>
        </div>

        <div class="tab-pane fade @if($errors->has('logo') || $errors->has('name_app') || $errors->has('description_app') || session()->has('updateAppBerhasil')) show active @endif" id="navs-aplikasi" role="tabpanel">
          <h5 class="card-header" style="margin-top: -0.5rem;">Pengaturan Aplikasi</h5>
          <p style="padding-left: 1.5rem; margin-top:-1.3rem; margin-bottom:-5px;">Atur aplikasi anda sesuai dengan keinginan</p>
          <!-- setting aplikasi -->
          <div class="card-body">
            <form id="formAppSettings" action="/admin/pengaturan/app" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img src="@if(Storage::disk('public')->exists('logo-aplikasi')) {{ asset('storage/'. $app[0]->logo) }} @else {{ asset('assets/img/'. $app[0]->logo) }} @endif" alt="logo-aplikasi" class="d-block rounded cursor-pointer logoImage" height="100" width="100" id="uploadedLogo" data-url-img="@if(Storage::disk('public')->exists('logo-aplikasi')) {{ asset('storage/'. $app[0]->logo) }} @else {{ asset('assets/img/'. $app[0]->logo) }} @endif" />
                <div class="button-wrapper">
                  <label for="uploadLogo" class="btn btn-outline-primary me-2 mb-4" tabindex="0">
                    <span><i class="bx bx-image-alt fs-6" style="margin-bottom: 2px;"></i>&nbsp;Upload</span>
                    <input type="file" name="logo" id="uploadLogo" class="account-file-input" hidden />
                  </label>
                  @error('logo')<div style="color: #ff3e1d; font-size:80%;">{{ $message }}</div>@else<p class="text-muted mb-0" style="margin-top: -5px;">Ukuran logo: Maks 500 KB dengan rasio 1:1. Format logo: JPG, PNG, JPEG.</p>@enderror
                </div>
              </div>
          </div>
          <hr class="my-0">
          <div class="card-body">
            <div class="row mb-2 mb-lg-3">
              <label class="col-sm-2 col-form-label required-label" for="name_app">Nama Aplikasi</label>
              <div class="col-sm-10">
                <input type="text" class="form-control  @error('name_app') is-invalid @enderror" id="name_app" name="name_app" autocomplete="off" placeholder="Masukkan nama aplikasi" value="{{ old('name_app') ?? $app[0]->name_app }}" />
                @error('name_app') <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div> @enderror
              </div>
            </div>
            <div class="row mb-4">
              <label class="col-sm-2 col-form-label" for="description_app">Deskripsi Aplikasi</label>
              <div class="col-sm-10">
                <textarea class="form-control @error('description_app') is-invalid @enderror" id="description_app" name="description_app" autocomplete="off" placeholder="Masukkan deskripsi aplikasi disini. (max 255 karakter)" rows="3">{{ old('description_app') ?? $app[0]->description_app }}</textarea>
                @error('description_app') <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div> @enderror
              </div>
            </div>
            <div class="row justify-content-end">
              <div class="col-sm-10">
                <button type="submit" class="btn btn-primary"><i class="bx bx-save fs-6" style="margin-bottom: 2px;"></i>&nbsp;Simpan</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="validateMessages" data-username-required="@error('usernameverify') {{ $message }} @enderror" data-password-required="@error('password') {{ $message }} @enderror"></div>
<div class="modal fade" id="formModalUsersEditEmail" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/pengaturan/verify" method="post" class="modalUsersEditEmail">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Verifikasi&nbsp;<i class='bx bxs-user fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow btnCancelVeify" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="usernameVerivy" class="form-label required-label">Username</label>
              <input type="text" id="usernameVerivy" name="usernameverify" value="{{ old('usernameverify') ?? auth()->user()->username }}" class="form-control @error('usernameverify') is-invalid @enderror" placeholder="Masukkan username Anda" autocomplete="off" readonly required>
              @error('username')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="passwordVerify" class="form-label required-label">Password</label>
              <input type="password" id="passwordVerify" name="password" value="{{ old('password') }}" class="form-control @error('password') is-invalid @enderror @if(session()->has('statusverifyfailed')) is-invalid @endif" placeholder="Masukkan pasword Anda" autocomplete="off" required>
              @error('password')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
              @if(session()->has('statusverifyfailed'))
              <div class="invalid-feedback" style="margin-bottom: -3px;">Password anda salah!</div>
              @endif
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger btnCancelVeify" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bxs-user fs-6' style="margin-bottom: 3px;"></i>&nbsp;Konfirmasi</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="statusUpdateEmail" data-update-email-success="@if(session()->has('updateEmailUser')) {{ session('updateEmailUser') }} @endif"></div>
<div class="statusverify" data-status-verify-success="@if(session()->has('statusverifysuccess')) {{ session('statusverifysuccess') }} @endif" data-status-verify-failed="@if(session()->has('statusverifyfailed')) {{ session('statusverifyfailed') }} @endif"></div>

@if(session()->has('statusverifysuccess') || $errors->has('email'))
<div class="validatedEmail" data-email="@error('email') {{ $message }} @enderror"></div>
<div class="modal fade" id="formModalUsersSetEmail" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/pengaturan/setemail" method="post" class="modalUsersSetEmail">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Ubah Email&nbsp;<i class='bx bx-envelope fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <label for="emailSet" class="form-label required-label">Email Baru</label>
              <input type="text" id="emailSet" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email baru" autocomplete="off" required>
              @error('email')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-save fs-6' style="margin-bottom: 3px;"></i>&nbsp;Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endif

<!-- image show -->
<div class="modal fade" id="gambarModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title text-primary fw-bold">My Profile Picture</h5>
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
      </div>
      <div class="modal-body" style="margin-top: -10px;">
        <img src="" class="img-fluid rounded urlShowProfilImg" width="100%">
      </div>
    </div>
  </div>
</div>

<!-- logo show -->
<div class="modal fade" id="logoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title text-primary fw-bold">Logo Aplikasi</h5>
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
      </div>
      <div class="modal-body" style="margin-top: -10px;">
        <img src="" class="img-fluid rounded urlShowLogo" width="100%">
      </div>
    </div>
  </div>
</div>

@section('script')
<script src="{{ asset('assets/js/settings/index.js') }}"></script>
@endsection
@endsection