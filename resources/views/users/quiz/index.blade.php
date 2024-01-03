@extends('layouts.main.index')
@section('container')
@section('style')
<style>
  .btn-label-primary {
    color: #fff;
    border-color: rgba(0, 0, 0, 0);
    background: #696cff;
  }

  .btn-label-primary:hover {
    color: #696cff;
    border-color: rgba(0, 0, 0, 0);
    background: rgba(105, 108, 255, 0.16) !important;
  }

  @media screen and (max-width: 575px) {
    .pagination-mobile {
      display: flex;
      justify-content: end;
    }
  }
</style>
@endsection
<div class="card mb-4">
  <div class="card-header">
    <div class="card-title mb-0 me-1">
      <h5 class="mb-1">Quizzes&nbsp;<i class="bx bx-joystick fs-5"></i></h5>
      <p class="text-muted mb-0">Berikut @if($quizzes->count() > 1) kumpulan @endif quiz yang bisa anda kerjakan.</p>
    </div>
  </div>
  <div class="card-body">
    <div class="row gy-4 mb-4">
      @foreach ($quizzes as $quiz)
      <div class="col-sm-6 col-lg-4">
        <div class="card p-2 h-100 shadow-none border">
          <div class="card-body p-3 pt-2">
            <div class="d-flex justify-content-between mt-2">
              <h5 class="card-title text-capitalize"> @if (preg_match("/[\x{0000}-\x{007F}]/u", $quiz->title)) {{ Str::limit($quiz->title, 28, '...') }} @else {{ Str::limit($quiz->title, 20, '...') }} @endif</h5>
              <div>
                <button type="button" data-title-quiz="{{ $quiz->title }}" data-description-quiz="{{ $quiz->description }}" data-total-soal-quiz="{{ $quiz->question->count() }}" class="btn p-0 dropdown-toggle hide-arrow buttonDetails" data-bs-toggle="modal" data-bs-target="#quizDetails"><i class="bx bx-info-circle mb-2 text-primary" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Klik untuk melihat detail quiz"></i></button>
              </div>
            </div>
            <h6 class="card-subtitle text-muted" style="font-size: 12px; margin-bottom:10px;">Dibuat {{ $quiz->created_at->locale('id')->diffForHumans() }}</h6>
            <p class="mt-4">{{ Str::limit($quiz->description, 100, '...') }}</p>
            <button type="button" class="w-100 btn btn-label-primary" onclick="window.location.href='/quiz/start/{{ $quiz->slug }}'"><i class='bx bx-joystick fs-5' style="margin-bottom: 3px;"></i>&nbsp;Mulai Quiz</button>
          </div>
        </div>
      </div>
      @endforeach
    </div>


    @if($quizzes->isEmpty())
    <span class="d-flex justify-content-center mb-2"><i class='bx bx-info-circle fs-5' style="margin-top: 3px;"></i>&nbsp;Quiz tidak ditemukan!</span>
    @endif

    @if(!$quizzes->isEmpty() && $quizzes->lastPage() != 1)
    <nav aria-label="Page navigation" class="d-flex align-items-center justify-content-center">
      <ul class="pagination">
        <li class="page-item {{ $quizzes->previousPageUrl() ? '' : 'disabled' }}">
          <a class="page-link" href="{{ $quizzes->previousPageUrl() }}">&lsaquo;</a>
        </li>
        @foreach ($quizzes->getUrlRange(1, $quizzes->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $quizzes->currentPage() ? 'active' : '' }}">
          <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li>
        @endforeach
        <li class="page-item {{ $quizzes->nextPageUrl() ? '' : 'disabled' }}">
          <a class="page-link" href="{{ $quizzes->nextPageUrl() }}">&rsaquo;</a>
        </li>
      </ul>
    </nav>
    @endif

  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="quizDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title text-primary fw-bold">Detail Quiz&nbsp;<i class='bx bx-joystick fs-5' style="margin-bottom: 2px;"></i></h5>
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Judul</label>
          <div class="col-sm-9">
            <div class="form-control" id="titleQuiz"></div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Deskripsi</label>
          <div class="col-sm-9">
            <div class="form-control" id="descriptionQuiz"></div>
          </div>
        </div>
        <div class="row mb-3">
          <label class="col-sm-3 col-form-label">Total Soal</label>
          <div class="col-sm-9">
            <div class="form-control" id="totalSoalQuiz"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@section('script')
<script src="{{ asset('assets/js/quiz/index.js') }}"></script>
@endsection
@endsection