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

  audio {
    height: 35px;
    outline: none;
  }

  audio::-webkit-media-controls-panel {
    background-color: #f1f1f1;
    color: #333;
    border-radius: 8px;
    padding: 0px;
  }

  audio::-webkit-media-controls-play-button,
  audio::-webkit-media-controls-pause-button {
    background-color: #696cff;
    color: #fff;
    border-radius: 50%;
    padding: 0px;
    border: none;
    cursor: pointer;
  }
</style>
@endsection
<div class="flash-message" data-add-materi="@if(session()->has('addMateriSuccess')) {{ session('addMateriSuccess') }} @endif" data-edit-materi="@if(session()->has('editMateriSuccess')) {{ session('editMateriSuccess') }} @endif" data-delete-materi="@if(session()->has('deleteMateriSuccess')) {{ session('deleteMateriSuccess') }} @endif"></div>
<div class="row">
  <div class="col-md-12 col-lg-12 order-2 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between" style="margin-bottom: -0.7rem;">
        <div class="justify-content-start">
          <button type="button" class="btn btn-xs btn-dark fw-bold p-2 buttonAddMateri" data-bs-toggle="modal" data-bs-target="#formModalAdminMateri">
            <i class='bx bx-book-content fs-6'></i>&nbsp;TAMBAH MATERI
          </button>
        </div>
        <div class="justify-content-end">
          <form action="/admin/data-materi/search">
            <div class="input-group">
              <input type="search" class="form-control" value="{{ request('q') }}" name="q" id="search" style="border: 1px solid #d9dee3;" placeholder="Cari Data Materi..." autocomplete="off" />
            </div>
          </form>
        </div>
      </div>
      <div class="card-body">
        <ul class="p-0 m-0">
          <div class="table-responsive text-nowrap" style="border-radius: 3px;">
            <table class="table table-striped">
              <thead class="table-dark">
                <tr>
                  <th class="text-white">No</th>
                  <th class="text-white">Gambar</th>
                  <th class="text-white text-center">Nama Aksara</th>
                  <th class="text-white text-center">Kategori</th>
                  <th class="text-white text-center">Audio</th>
                  <th class="text-white">Tanggal Pembuatan</th>
                  <th class="text-white">Tanggal Update</th>
                  <th class="text-white text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($materis as $index => $materi)
                <tr>
                  <td>{{ $materis->firstItem() + $index }}</td>
                  <td><img src="@if(Storage::disk('public')->exists($materi->image)) {{ asset('storage/'. $materi->image) }} @else {{ asset('assets/img/'. $materi->image) }} @endif" alt="Materi Image - {{ $materi->title }}" class="materiImage" data-url-img="@if(Storage::disk('public')->exists($materi->image)) {{ asset('storage/'. $materi->image) }} @else {{ asset('assets/img/'. $materi->image) }} @endif" data-title-materi="{{ $materi->title }}" @if($materi->category == 'huruf') style="width: 40px;" @elseif($materi->category == 'pasangan') style="width: 35px;" @else style="width: 23px;" @endif></td>
                  <td class="text-capitalize text-center">{{ $materi->title }}</td>
                  <td class="text-center">@if($materi->category == 'huruf')<span class="badge bg-label-success fw-bold">{{ 'Huruf' }}</span>@elseif ($materi->category == 'pasangan')<span class="badge bg-label-info fw-bold">{{ 'Pasangan'}}</span>@else<span class="badge bg-label-warning fw-bold">{{ 'Sandhangan'}}</span>@endif</td>
                  <td>@if($materi->audio)<audio controls>
                      <source src="@if(Storage::disk('public')->exists($materi->audio)) {{ asset('storage/'. $materi->audio) }} @else {{ asset('assets/'. $materi->audio) }} @endif" type="audio/mpeg">
                    </audio>@else Tidak Ada Audio @endif
                  </td>
                  <td>{{ $materi->created_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td>{{ $materi->updated_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td class="text-center">
                    <button type="button" class="btn btn-icon btn-primary btn-sm buttonEditMateri" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Edit Materi" data-code-materi="{{ encrypt($materi->id) }}" data-title-materi="{{ $materi->title }}" data-category-materi="{{ $materi->category }}">
                      <span class="tf-icons bx bx-edit" style="font-size: 15px;"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger btn-sm buttonDeleteMateri" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Hapus Materi" data-code-materi="{{ encrypt($materi->id) }}" data-title-materi="{{ $materi->title }}">
                      <span class="tf-icons bx bx-trash" style="font-size: 14px;"></span>
                    </button>
                  </td>
                </tr>
                @endforeach
                @if($materis->isEmpty())
                <tr>
                  <td colspan="100" class="text-center">Data tidak ditemukan dengan keyword pencarian: <b>"{{request('q')}}"</b></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </ul>
        @if(!$materis->isEmpty())
        <div class="mt-3 pagination-mobile">{{ $materis->withQueryString()->onEachSide(1)->links() }}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div id="errorModalAddMateri" data-error-title="@error('title') {{ $message }} @enderror" data-error-image="@error('image') {{ $message }} @enderror" data-error-audio="@error('audio') {{ $message }} @enderror" data-error-category="@error('category') {{ $message }} @enderror"></div>
<!-- Modal Add Materi-->
<div class="modal fade" id="formModalAdminMateri" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/data-materi" method="post" class="modalAdminMateri" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Tambah Materi Baru&nbsp;<i class='bx bx-book-content fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalAddMateri" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="title" class="form-label required-label">Nama Aksara</label>
              <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul Materi" autocomplete="off" required>
              @error('title')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="image" class="form-label required-label">Upload Gambar</label>
              <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
              @error('image')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
              <div class="form-text @error('image') d-none @enderror">Ukuran maks 500 KB dengan rasio 1:1. Format: JPG, PNG, JPEG.</div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="audio" class="form-label">Upload Audio</label>
              <input type="file" id="audio" name="audio" class="form-control @error('audio') is-invalid @enderror">
              @error('audio')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
              <div class="form-text @error('audio') d-none @enderror">Ukuran audio maks 250 KB</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="category" class="form-label required-label">Kategori</label>
              <select class="form-select @error('category') is-invalid @enderror" name="category" id="category" style="cursor: pointer;">
                <option value="" selected disabled>Pilih Kategori</option>
                <option @if(old('category')=='huruf' ) selected @endif value="huruf">Huruf Aksara</option>
                <option @if(old('category')=='pasangan' ) selected @endif value="pasangan">Pasangan</option>
                <option @if(old('category')=='sandhangan' ) selected @endif value="sandhangan">Sandhangan</option>
              </select>
              @error('category')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalAddMateri" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div id="errorModalEditMateri" data-error-edit-title="@error('titleEdit') {{ $message }} @enderror" data-error-edit-image="@error('imageEdit') {{ $message }} @enderror" data-error-edit-audio="@error('audioEdit') {{ $message }} @enderror" data-error-edit-category="@error('categoryEdit') {{ $message }} @enderror"></div>
<!-- Modal Edit Materi-->
<div class="modal fade" id="formEditModalAdminMateri" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/data-materi/update" method="post" class="modalAdminMateri" enctype="multipart/form-data">
      @csrf
      <input type="hidden" class="codeMateri" value="{{ old('codeMateri') }}" name="codeMateri">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Edit Materi&nbsp;<i class='bx bx-joystick fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalEditMateri" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="titleEdit" class="form-label required-label">Nama Aksara</label>
              <input type="text" id="titleEdit" name="titleEdit" value="{{ old('titleEdit') }}" class="form-control @error('titleEdit') is-invalid @enderror" autocomplete="off" placeholder="Masukkan Nama Materi" required>
              @error('titleEdit')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="imageEdit" class="form-label">Upload Gambar</label>
              <input type="file" id="imageEdit" name="imageEdit" class="form-control @error('imageEdit') is-invalid @enderror">
              @error('imageEdit')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
              <div class="form-text @error('imageEdit') d-none @enderror">Ukuran maks 500 KB dengan rasio 1:1. Format: JPG, PNG, JPEG.</div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="audioEdit" class="form-label">Upload Audio</label>
              <input type="file" id="audioEdit" name="audioEdit" class="form-control @error('audioEdit') is-invalid @enderror">
              @error('audioEdit')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
              <div class="form-text @error('audioEdit') d-none @enderror">Ukuran audio maks 250 KB</div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="categoryEdit" class="form-label required-label">Kategori</label>
              <select class="form-select @error('categoryEdit') is-invalid @enderror" name="categoryEdit" id="categoryEdit" style="cursor: pointer;">
                <option id="huruf" @if(old('categoryEdit')=='huruf' ) selected @endif value="huruf">Huruf Aksara</option>
                <option id="pasangan" @if(old('categoryEdit')=='pasangan' ) selected @endif value="pasangan">Pasangan</option>
                <option id="sandhangan" @if(old('categoryEdit')=='sandhangan' ) selected @endif value="sandhangan">Sandhangan</option>
              </select>
              @error('categoryEdit')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalEditMateri" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-save fs-6' style="margin-bottom: 3px;"></i>&nbsp;Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- modal delete Materi -->
<div class="modal fade" id="deleteMateriConfirm" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/data-materi/delete" method="post" id="formDeleteMateri">
      @csrf
      <input type="hidden" class="codeMateri" value="{{ old('codeMateri') }}" name="codeMateri">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body" style="margin-top: -10px;">
          <div class="col-sm fs-6 materiMessagesDelete"></div>
        </div>
        <div class="modal-footer" style="margin-top: -5px;">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tidak</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-trash fs-6' style="margin-bottom: 3px;"></i>&nbsp;Ya, Hapus!</button>
        </div>
      </div>
    </form>
  </div>
</div>

@section('script')
<script src="{{ asset('assets/js/datamateri/index.js') }}"></script>
@endsection
@endsection