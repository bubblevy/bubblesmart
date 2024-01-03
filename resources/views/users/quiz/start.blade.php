@extends('layouts.main.index')
@section('container')
@section('style')
<style>
  @media screen and (max-width: 1320px) {
    ::-webkit-scrollbar {
      display: none;
    }

    .navbreadcrumb {
      font-size: 14px;
    }
  }

  @media screen and (min-width: 1320px) {
    .navbreadcrumb {
      font-size: 14px;
    }
  }

  @media screen and (max-width: 576px) {
    .navbreadcrumb {
      font-size: small;
    }
  }

  .answer {
    word-wrap: break-word;
    white-space: normal;
    display: block;
  }
</style>
@endsection
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between mb-2">
      <nav aria-label="breadcrumb" class="navbreadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/quiz" class="text-primary">Quiz</a>
          </li>
          <li class="breadcrumb-item active">{{ $titleQuiz }}</li>
        </ol>
      </nav>
      <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="modal" data-bs-target="#petunjukQuiz"><i class="bx bx-bulb text-primary mb-3 iconPetunjukQuiz" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Petunjuk Quiz" style="font-size: 20px;"></i></button>
    </div>
    <div class="flash-message" data-flash-message="@if(session()->has('messages')) {{ session('messages') }} @endif"></div>
    <form action="/quiz" method="post" id="quizForm">
      @csrf
      <input type="hidden" name="quizCode" value="{{ encrypt($codeQuiz) }}">
      <input type="hidden" name="bubblesmart" value="{{ encrypt($bubblesmart) }}">
      @foreach ($quizzes->shuffle() as $index => $quiz)
      <div class="d-flex">
        <div>{{ $index + 1 }}.</div>
        @if (preg_match("/[\x{0000}-\x{007F}]/u", $quiz->question))
        <p style="font-size: 1rem; margin-left: 10px;">{{ $quiz->question }}</p>
        @else
        <p class="mb-4" style="font-size: 1.3rem; margin-top:-5px; margin-left: 10px;">{{ $quiz->question }}</p>
        @endif
      </div>
      <ol type="A" style="margin-top: -10px; margin-left: 10px; font-size: 1rem;">
        @foreach($quiz->answer->shuffle() as $answer)
        <div class="d-flex">
          <li>
            <input type="radio" id="{{ $answer->id }}" name="answer[{{ $quiz->id }}]" value="{{ encrypt($answer->id) }}" class="form-check-input" hidden>
            @if (preg_match("/[\x{0000}-\x{007F}]/u", $answer->answer))
            <label for="{{ $answer->id }}" class="form-check-label mb-1 answer cursor-pointer text-capitalize">{{ $answer->answer }}</label>
            @else
            <label for="{{ $answer->id }}" style="font-size:1.2rem;" class="form-check-label mb-1 answer cursor-pointer mt-1">{{ $answer->answer }}</label>
            @endif
          </li>
        </div>
        @endforeach
      </ol>
      @endforeach
      <button type="button" onclick="window.location.href='/quiz'" class="btn btn-danger mt-2 me-1 mb-2 btlQuiz"><i class='bx bx-share fs-5' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
      <button type="submit" class="btn btn-primary mt-2 mb-2 buttonSumbitQuiz"><i class='bx bx-task fs-5' style="margin-bottom: 3px;"></i>&nbsp;Selesai</button>
    </form>
    @if($quizzes->isEmpty())
    <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
      <span style="font-size: medium;"><i class='bx bx-info-circle fs-5' style="margin-bottom: 2px;"></i>&nbsp;Belum ada pertanyaan disini!</span>
    </div>
    @endif
  </div>
</div>


<!-- Modal Petunjuk -->
<div class="modal fade" id="petunjukQuiz" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title text-primary fw-bold">Petunjuk Quiz&nbsp;<i class='bx bx-bulb fs-5' style="margin-bottom: 3px;"></i></h5>
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
      </div>
      <div class="modal-body" style="margin-top: -10px;">
        <div class="row mb-2">
          <div class="col-sm">
            <div class="mb-1"><strong style="font-weight: normal;">1. Klik pada jawaban untuk menjawab soal.</strong></div>
            <div class="mb-1"><strong style="font-weight: normal;">2. Minimal mengerjakan satu soal.</strong></div>
            <div class="mb-1"><strong style="font-weight: normal;">3. Tidak ada batas waktu saat mengerjakan.</strong></div>
            <div><strong style="font-weight: normal;">4. Klik tombol <b>Selesai</b> jika anda sudah selesai mengerjakan.</strong></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Confirm -->
<div class="modal fade" id="submitQuiz" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between">
        <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
      </div>
      <div class="modal-body" style="margin-top: -10px;">
        <div class="col-sm fs-6">Jika Anda sudah yakin dengan jawaban Anda, tekan <strong>'Kirim'</strong> untuk mengirim jawaban Anda.</div>
      </div>
      <div class="modal-footer" style="margin-top: -5px;">
        <button type="button" class="btn btn-outline-danger cancelConfirmQuiz" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
        <button type="button" class="btn btn-primary confirmQuiz"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Kirim</button>
      </div>
    </div>
  </div>
</div>

@section('script')
<script src="{{ asset('assets/js/quiz/start.js') }}"></script>
@endsection
@endsection