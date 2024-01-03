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
<div class="flash-message" data-add-quiz="@if(session()->has('quizSuccess')) {{ session('quizSuccess') }} @endif" data-edit-quiz="@if(session()->has('updateQuizSuccess')) {{ session('updateQuizSuccess') }} @endif" data-delete-quiz="@if(session()->has('deleteQuizSuccess')) {{ session('deleteQuizSuccess') }} @endif" data-error-delete-quiz="@if(session()->has('deleteQuizError')) {{ session('deleteQuizError') }} @endif"></div>
<div class="row">
  <div class="col-md-12 col-lg-12 order-2 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between" style="margin-bottom: -0.7rem;">
        <div class="justify-content-start">
          <button type="button" class="btn btn-xs btn-dark fw-bold p-2 buttonAddQuiz" data-bs-toggle="modal" data-bs-target="#formModalAdminQuiz">
            <i class='bx bx-joystick fs-6'></i>&nbsp;TAMBAH QUIZ
          </button>
        </div>
        <div class="justify-content-end">
          <form action="/admin/data-quiz/search">
            <div class="input-group">
              <input type="search" class="form-control" name="q" id="search" style="border: 1px solid #d9dee3;" value="{{ request('q') }}" placeholder="Cari Data Quiz..." autocomplete="off" />
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
                  <th class="text-white">Judul Quiz</th>
                  <th class="text-white">Deskripsi Quiz</th>
                  <th class="text-white text-center">Total Soal</th>
                  <th class="text-white">Tanggal Pembuatan Quiz</th>
                  <th class="text-white">Tanggal Update Quiz</th>
                  <th class="text-white">Status</th>
                  <th class="text-white text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($allQuiz as $index => $quiz)
                <tr>
                  <td>{{ $allQuiz->firstItem() + $index }}</td>
                  @if (preg_match("/[\x{0000}-\x{007F}]/u", $quiz->title))
                  <td>{{ Str::limit($quiz->title, 40, '...') }}</td>
                  @else
                  <td style="font-size: 18px;">{{ Str::limit($quiz->title, 31, '...') }}</td>
                  @endif
                  <td>{{ Str::limit($quiz->description, 50, '...')}}</td>
                  <td class="text-center"><span class="badge badge-center bg-dark rounded-pill">{{ $quiz->question->count() }}</span></td>
                  <td>{{ $quiz->created_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td>{{ $quiz->updated_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td>@if($quiz->status == 'Aktif')<span class="badge bg-label-success fw-bold">{{ $quiz->status }}</span>@else<span class="badge bg-label-danger fw-bold">{{ $quiz->status }}</span>@endif</td>
                  <td class="text-center">
                    <button type="button" class="btn btn-icon btn-primary btn-sm" onclick="window.location.href='/admin/data-quiz/q&a/{{ $quiz->slug }}'" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Pertanyaan & Jawaban">
                      <span class="tf-icons bx bx-show" style="font-size: 15px;"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-warning btn-sm buttonEditQuiz" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Edit Quiz" data-title-quiz="{{ $quiz->title }}" data-code-quiz="{{ $quiz->slug }}" data-desc-quiz="{{ $quiz->description }}" data-status-quiz="{{ $quiz->status }}">
                      <span class="tf-icons bx bx-edit" style="font-size: 15px;"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger btn-sm buttonDeleteQuiz" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Hapus Quiz" data-code-quiz="{{ $quiz->slug }}" data-title-quiz="{{ $quiz->title }}">
                      <span class="tf-icons bx bx-trash" style="font-size: 14px;"></span>
                    </button>
                  </td>
                </tr>
                @endforeach
                @if($allQuiz->isEmpty())
                <tr>
                  <td colspan="100" class="text-center">Data tidak ditemukan dengan keyword pencarian: <b>"{{request('q')}}"</b></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </ul>
        @if(!$allQuiz->isEmpty())
        <div class="mt-3 pagination-mobile">{{ $allQuiz->withQueryString()->onEachSide(1)->links() }}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div id="errorModalAddQuiz" data-error-title="@error('title') {{ $message }} @enderror" data-error-desc="@error('description') {{ $message }} @enderror"></div>
<!-- Modal Add Quiz-->
<div class="modal fade" id="formModalAdminQuiz" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/data-quiz" method="post" class="modalAdminQuiz">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Buat Quiz Baru&nbsp;<i class='bx bx-joystick fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalAddQuiz" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="title" class="form-label required-label">Judul Quiz</label>
              <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul quiz" autocomplete="off" required>
              @error('title')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="deskripsi" class="form-label required-label">Deskripsi</label>
              <textarea class="form-control @error('description') is-invalid @enderror" id="deskripsi" name="description" autocomplete="off" placeholder="Masukkan deskripsi quiz. (max 255 karakter)" rows="4" required>{{ old('description') }}</textarea>
              @error('description')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalAddQuiz" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div id="errorModalEditQuiz" data-error-edit-title="@error('titleQuiz') {{ $message }} @enderror" data-error-edit-desc="@error('descriptionQuiz') {{ $message }} @enderror" data-error-edit-status="@error('status') {{ $message }} @enderror"></div>
<!-- Modal Edit Quiz-->
<div class="modal fade" id="formEditModalAdminQuiz" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/data-quiz/update" method="post" class="modalAdminQuiz">
      @csrf
      <input type="hidden" class="codeQuiz" value="{{ old('codeQuiz') }}" name="codeQuiz">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Edit Quiz&nbsp;<i class='bx bx-joystick fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalEditQuiz" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="titleEdit" class="form-label required-label">Judul Quiz</label>
              <input type="text" id="titleEdit" name="titleQuiz" value="{{ old('titleQuiz') }}" class="form-control @error('titleQuiz') is-invalid @enderror" autocomplete="off" placeholder="Masukkan judul quiz" required>
              @error('titleQuiz')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="deskripsiEdit" class="form-label required-label">Deskripsi</label>
              <textarea class="form-control @error('descriptionQuiz') is-invalid @enderror" id="deskripsiEdit" name="descriptionQuiz" placeholder="Masukkan deskripsi quiz. (max 255 karakter)" rows="4" autocomplete="off" required>{{ old('descriptionQuiz') }}</textarea>
              @error('descriptionQuiz')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row statusQuiz">
            <div class="col mb-0 mt-3">
              <label for="status" class="form-label required-label">Status Quiz</label>
              <select class="form-select @error('status') is-invalid @enderror" name="status" id="status" style="cursor: pointer;">
                <option id="aktif" value="Aktif">Aktif</option>
                <option id="nonaktif" value="Nonaktif">Nonaktif</option>
              </select>
              @error('status')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalEditQuiz" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-save fs-6' style="margin-bottom: 3px;"></i>&nbsp;Update</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- modal delete quiz -->
<div class="modal fade" id="deleteQuizConfirm" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post" id="formDeleteQuiz">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body" style="margin-top: -10px;">
          <div class="col-sm fs-6 quizMessagesDelete"></div>
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
<script src="{{ asset('assets/js/dataquiz/index.js') }}"></script>
@endsection
@endsection