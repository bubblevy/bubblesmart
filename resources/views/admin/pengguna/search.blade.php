@extends('layouts.main.index')
@section('container')
@section('style')
<style>
  ::-webkit-scrollbar {
    display: none;
  }

  @media screen and (min-width: 1320px) {
    #search {
      width: 250px;
    }
  }

  .required-label::after {
    content: " *";
    color: red;
  }

  @media screen and (max-width: 575px) {
    .pagination-mobile {
      display: flex;
      justify-content: end;
    }
  }
</style>
@endsection
<div class="flash-message-pengguna" data-add-p-user="@if(session()->has('adduserSuccess')) {{ session('adduserSuccess') }} @endif" data-edit-p-user="@if(session()->has('updateUserSuccess')) {{ session('updateUserSuccess') }} @endif" data-delete-p-user="@if(session()->has('deleteUserSuccess')) {{ session('deleteUserSuccess') }} @endif" data-error-delete-p-user="@if(session()->has('deleteUserError')) {{ session('deleteUserError') }} @endif"></div>
<div class="row">
  <div class="col-md-12 col-lg-12 order-2 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between" style="margin-bottom: -0.7rem;">
        <div class="justify-content-start">
          <button type="button" class="btn btn-xs btn-dark fw-bold p-2" data-bs-toggle="modal" data-bs-target="#formModalAdminAddPengguna">
            <i class='bx bxs-user-account fs-6'></i>&nbsp;TAMBAH AKUN
          </button>
        </div>
        <div class="justify-content-end">
          <!-- Search -->
          <form action="/admin/pengguna/search">
            <div class="input-group">
              <input type="search" class="form-control" name="q" id="search" style="border: 1px solid #d9dee3;" value="{{ request('q') }}" placeholder="Cari Data Pengguna..." autocomplete="off" />
            </div>
          </form>
          <!-- /Search -->
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          <div class="table-responsive text-nowrap" style="border-radius: 3px;">
            <table class="table table-striped">
              <thead class="table-dark">
                <tr>
                  <th class="text-white">No</th>
                  <th class="text-white">Foto</th>
                  <th class="text-white">Nama Lengkap</th>
                  <th class="text-white">Username</th>
                  <th class="text-white">Email</th>
                  <th class="text-white">Jenis Kelamin</th>
                  <th class="text-white">Tanggal Lahir</th>
                  <th class="text-white">Alamat</th>
                  <th class="text-white">Tanggal Pembuatan Akun</th>
                  <th class="text-white">Tanggal Update Akun</th>
                  <th class="text-white text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($users as $index => $user)
                <tr>
                  <td>{{ $users->firstItem() + $index }}</td>
                  <td>
                    <img src="@if(Storage::disk('public')->exists($user->image)) {{ asset('storage/'. $user->image) }} @else {{ asset('assets/img/'. $user->image) }} @endif" alt="Foto Profil - {{ $user->name }}" class="rounded avatar avatar-sm fotoProfile" data-url-img="@if(Storage::disk('public')->exists($user->image)) {{ asset('storage/'. $user->image) }} @else {{ asset('assets/img/'. $user->image) }} @endif" data-name-user="{{ $user->name }}">
                  </td>
                  <td class="text-capitalize">{{ $user->name }}</td>
                  <td>{{ '@' . $user->username }}</td>
                  <td>{{ substr($user->email , 0, 3) . str_repeat('*', strlen(substr($user->email, 0, strpos($user->email, '@'))) - 3) . substr($user->email, -10) }}</td>
                  <td>@if($user->gender == 'Laki-Laki')<span class="badge bg-label-primary fw-bold">Laki-Laki</span>@else<span class="badge fw-bold" style="color: #ff6384 !important; background-color: #ffe5eb !important;">Perempuan</span>@endif</td>
                  <td>@if($user->tanggal_lahir) {{ \Carbon\Carbon::parse($user->tanggal_lahir)->locale('id')->isoFormat('D MMMM YYYY') }} @else Belum diinput pengguna! @endif</td>
                  <td>@if($user->alamat) {{ $user->alamat }} @else Belum diinput pengguna! @endif</td>
                  <td>{{ $user->created_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td>{{ $user->updated_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td class="text-center">
                    <button type="button" class="btn btn-icon btn-primary btn-sm buttonEditPengguna" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Edit Pengguna" data-id="{{ encrypt($user->id) }}">
                      <span class="tf-icons bx bx-edit" style="font-size: 15px;"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger btn-sm buttonDeletePengguna" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Hapus Pengguna" data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                      <span class="tf-icons bx bx-trash" style="font-size: 14px;"></span>
                    </button>
                  </td>
                </tr>
                @endforeach
                @if($users->isEmpty())
                <tr>
                  <td colspan="100" class="text-center">Data pengguna tidak ditemukan dengan keyword pencarian: <b>"{{request('q')}}"</b></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </ul>
        @if(!$users->isEmpty())
        <div class="mt-3 pagination-mobile">{{ $users->withQueryString()->onEachSide(1)->links() }}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div id="errorModalAddUser" data-error-p-name="@error('name') {{ $message }} @enderror" data-error-p-username="@error('username') {{ $message }} @enderror" data-error-p-email="@error('email') {{ $message }} @enderror" data-error-p-gender="@error('gender') {{ $message }} @enderror" data-error-p-image="@error('image') {{ $message }} @enderror" data-error-p-pass="@error('password') {{ $message }} @enderror"></div>
<!-- Modal Add Pengguna-->
<div class="modal fade" id="formModalAdminAddPengguna" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post" class="modalAdminAddPengguna" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Tambah Pengguna Baru&nbsp;<i class='bx bxs-user fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalAddUser" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nama_lengkap_user" class="form-label required-label">Nama Lengkap</label>
              <input type="text" id="nama_lengkap_user" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama pengguna" autocomplete="off" required>
              @error('name')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="username_user" class="form-label required-label">Username</label>
              <input type="text" id="username_user" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username pengguna" autocomplete="off" required>
              @error('username')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
              <div class="form-text @error('username') d-none @enderror">Username minimal 5 karakter (Hanya boleh huruf & angka).</div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="email_user" class="form-label required-label">Email</label>
              <input type="text" id="email_user" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email pengguna" autocomplete="off" required>
              @error('email')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="gender_user" class="form-label required-label">Jenis Kelamin</label>
              <select class="form-select @error('gender') is-invalid @enderror" name="gender" id="gender_user" style="cursor: pointer;">
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
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="profil_user" class="form-label">Upload Foto</label>
              <input type="file" id="profil_user" name="image" class="form-control @error('image') is-invalid @enderror">
              @if($errors->has('image'))
              @foreach($errors->get('image') as $error)
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $error }}
              </div>
              @endforeach
              @endif
              <div class="form-text @error('image') d-none @enderror">Ukuran maks 500 KB dengan rasio 1:1. Format: JPG, PNG, JPEG.</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="password_user" class="form-label required-label">Password</label>
              <input type="password" id="password_user" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" autocomplete="off" required>
              @if($errors->has('password'))
              @foreach($errors->get('password') as $error)
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $error }}
              </div>
              @endforeach
              @endif
              <div class="form-text @error('password') d-none @enderror"><i class='bx bx-error' style="font-size: 100%;"></i>&nbsp;Password minimal 8 karakter termasuk huruf kapital & kecil (A-Z), (a-z), angka (1-9), dan karakter unik (@,#,%,dll)</div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalAddUser" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>

@if(session('validationErrors'))
<div id="errorModalEditUser" data-error-p-name="@if(session('validationErrors')) @foreach (session('validationErrors')['name'] ?? [] as $errorMessage) {{ $errorMessage }} @endforeach @endif" data-error-p-username="@if(session('validationErrors')) @foreach (session('validationErrors')['username'] ?? [] as $errorMessage) {{ $errorMessage }} @endforeach @endif" data-error-p-email="@if(session('validationErrors')) @foreach (session('validationErrors')['email'] ?? [] as $errorMessage) {{ $errorMessage }} @endforeach @endif" data-error-p-gender="@if(session('validationErrors')) @foreach (session('validationErrors')['gender'] ?? [] as $errorMessage) {{ $errorMessage }} @endforeach @endif" data-error-p-pass="@if(session('validationErrors')) @foreach (session('validationErrors')['password'] ?? [] as $errorMessage) {{ $errorMessage }} @endforeach @endif" data-error-p-image="@if(session('validationErrors')) @foreach (session('validationErrors')['image'] ?? [] as $errorMessage) {{ $errorMessage }} @endforeach @endif"></div>
@endif
<!-- Modal Edit Pengguna-->
<div class="modal fade" id="formModalAdminEditPengguna" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/pengguna/edit" method="post" class="modalAdminEditPengguna" enctype="multipart/form-data">
      <input type="hidden" name="codeUser" value="{{ old('codeUser') }}" id="codeUser">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Edit Pengguna&nbsp;<i class='bx bxs-user fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalEditUser" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="edit_nama_lengkap_user" class="form-label required-label">Nama Lengkap</label>
              <input type="text" id="edit_nama_lengkap_user" name="name" value="{{ old('name') }}" class="form-control @if(session('validationErrors')) @foreach (session('validationErrors')['name'] ?? [] as $errorMessage) is-invalid @endforeach @endif" placeholder="Masukkan nama pengguna" autocomplete="off" required>
              @if(session('validationErrors')) @foreach (session('validationErrors')['name'] ?? [] as $errorMessage)
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $errorMessage }}
              </div>
              @endforeach @endif
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="edit_username_user" class="form-label required-label">Username</label>
              <input type="text" id="edit_username_user" name="username" value="{{ old('username') }}" class="form-control @if(session('validationErrors')) @foreach (session('validationErrors')['username'] ?? [] as $errorMessage) is-invalid @endforeach @endif" placeholder="Masukkan username pengguna" autocomplete="off" required>
              @if(session('validationErrors')) @foreach (session('validationErrors')['username'] ?? [] as $errorMessage)
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $errorMessage }}
              </div>
              @endforeach
              @endif
              <div class="form-text @if(session('validationErrors')) @foreach (session('validationErrors')['username'] ?? [] as $errorMessage) d-none @endforeach @endif">Username minimal 5 karakter (Hanya boleh huruf & angka).</div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="edit_email_user" class="form-label required-label">Email</label>
              <input type="text" id="edit_email_user" name="email" value="{{ old('email') }}" class="form-control @if(session('validationErrors')) @foreach (session('validationErrors')['email'] ?? [] as $errorMessage) is-invalid @endforeach @endif" placeholder="Masukkan email pengguna" autocomplete="off" required>
              @if(session('validationErrors')) @foreach (session('validationErrors')['email'] ?? [] as $errorMessage)
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $errorMessage }}
              </div>
              @endforeach
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="edit_gender_user" class="form-label required-label">Jenis Kelamin</label>
              <select class="form-select @if(session('validationErrors')) @foreach (session('validationErrors')['gender'] ?? [] as $errorMessage) is-invalid @endforeach @endif" name="gender" id="edit_gender_user" style="cursor: pointer;">
                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                <option id="gender_laki-laki" @if(old('gender')=='Laki-Laki' ) selected @endif value="Laki-Laki">Laki-Laki</option>
                <option id="gender_perempuan" @if(old('gender')=='Perempuan' ) selected @endif value="Perempuan">Perempuan</option>
              </select>
              @if(session('validationErrors')) @foreach (session('validationErrors')['gender'] ?? [] as $errorMessage)
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $errorMessage }}
              </div>
              @endforeach
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="edit_profil_user" class="form-label">Upload Foto</label>
              <input type="file" id="edit_profil_user" name="image" class="form-control @if(session('validationErrors')) @foreach (session('validationErrors')['image'] ?? [] as $errorMessage) is-invalid @endforeach @endif">
              @if(session('validationErrors')) @foreach (session('validationErrors')['image'] ?? [] as $errorMessage)
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $errorMessage }}
              </div>
              @endforeach
              @endif
              <div class="form-text @if(session('validationErrors')) @foreach (session('validationErrors')['image'] ?? [] as $errorMessage) d-none @endforeach @endif">Ukuran maks 500 KB dengan rasio 1:1. Format: JPG, PNG, JPEG.</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="edit_password_user" class="form-label">Password</label>
              <input type="password" id="edit_password_user" name="password" class="form-control @if(session('validationErrors')) @foreach (session('validationErrors')['password'] ?? [] as $errorMessage) is-invalid @endforeach @endif" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" autocomplete="off">
              @if(session('validationErrors')) @foreach (session('validationErrors')['password'] ?? [] as $errorMessage)
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $errorMessage }}
              </div>
              @endforeach
              @endif
              <div class="form-text @if(session('validationErrors')) @foreach (session('validationErrors')['password'] ?? [] as $errorMessage) d-none @endforeach @endif"><i class='bx bx-error' style="font-size: 100%;"></i>&nbsp;Password minimal 8 karakter termasuk huruf kapital & kecil (A-Z), (a-z), angka (1-9), dan karakter unik (@,#,%,dll)</div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalEditUser" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-save fs-6' style="margin-bottom: 3px;"></i>&nbsp;Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- modal Delete Pengguna -->
<div class="modal fade" id="deleteUserConfirm" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post" id="formDeleteUser">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body" style="margin-top: -10px;">
          <div class="col-sm fs-6 userMessagesDelete"></div>
        </div>
        <div class="modal-footer" style="margin-top: -5px;">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tidak</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-trash fs-6' style="margin-bottom: 3px;"></i>&nbsp;Ya, Hapus!</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- image show -->
<div class="modal fade" id="gambarModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title text-primary fw-bold nameShowProfilImg">Nama</h5>
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
      </div>
      <div class="modal-body" style="margin-top: -10px;">
        <img src="" class="img-fluid rounded urlShowProfilImg" width="100%">
      </div>
    </div>
  </div>
</div>
@section('script')
<script src="{{ asset('assets/js/pengguna/index.js') }}"></script>
@endsection
@endsection