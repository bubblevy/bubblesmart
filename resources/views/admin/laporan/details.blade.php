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

  .badge {
    word-wrap: break-word;
    white-space: normal;
    display: block;
  }
</style>
@endsection
<nav aria-label="breadcrumb" class="navbreadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/admin/laporan" class="text-primary">Laporan</a>
    </li>
    <li class="breadcrumb-item">
      <a href="/admin/laporan/{{ $dataquiz->slug }}" class="text-primary">{{ $dataquiz->title }}</a>
    </li>
    <li class="breadcrumb-item active">Details</li>
  </ol>
</nav>
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between mb-3">
      <button type="button" onclick="window.location.href='/admin/laporan/{{ $dataquiz->slug }}'" class="btn btn-primary btn-sm"><i class='bx bx-left-arrow-alt bx-xs' style="margin-bottom: 3px;"></i>&nbsp;Kembali</button>
      <div style="margin-top: 3px;"><i class='bx bx-history bx-spin text-primary mb-1' data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tanggal Sumbit Quiz"></i>&nbsp;{{ $dataresult->created_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</div>
    </div>
    <div class="table-responsive text-nowrap mb-3">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama Lengkap</th>
            <th>Judul Quiz</th>
            <th>Total Soal</th>
            <th>Jawaban Benar</th>
            <th>Jawaban Salah</th>
            <th>Nilai</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $dataresult->user->name }}</td>
            @if (preg_match("/[\x{0000}-\x{007F}]/u", $dataquiz->title))
            <td>{{ Str::limit($dataquiz->title, 40, '...') }}</td>
            @else
            <td style="font-size: 18px;">{{ Str::limit($dataquiz->title, 31, '...') }}</td>
            @endif
            <td>{{ $questions->count() }} Soal</td>
            <td>{{ $correct->count() }} Soal</td>
            <td>{{ $questions->count() - $correct->count() }} Soal</td>
            <td>{{ $totalScore }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    @foreach ($scores as $index => $score)
    <div class="d-flex">
      <div>{{ $index + 1 }}.</div>
      @if (preg_match("/[\x{0000}-\x{007F}]/u", $score->question->question))
      <p style="font-size: 1rem; margin-left: 10px;">{{ $score->question->question }}</p>
      @else
      <p style="font-size: 1.3rem; margin-top:-5px; margin-left: 10px;">{{ $score->question->question }}</p>
      @endif
    </div>
    <ol type="A" style="margin-top: -10px; margin-left:10px; font-size: 1rem;">
      @foreach($score->question->answer as $answer)
      @if($score->answer_id !== null)
      <li>
        <label class="form-check-label mb-1 text-capitalize" style="display:block; word-wrap: break-word; white-space: normal;">
          @if($score->correct && $answer->answer === $score->answer->answer)
          <div class="d-flex">
            @if (preg_match("/[\x{0000}-\x{007F}]/u", $answer->answer))
            <span class="badge bg-label-success text-capitalize" style="text-transform:none; font-size: 0.9125em; padding: 0.42em 0.493em; text-align:start; line-height: 1;">{{ $answer->answer }}</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Anda Benar!" class="bx bx-check bx-tada text-success d-flex align-items-center cursor-pointer" style="font-size: 20px;"></i>
            @else
            <span class="badge bg-label-success mt-2" style="text-transform:none; font-size: 1.2rem; padding: 0.42em 0.493em; text-align:start; line-height: 1;">{{ $answer->answer }}</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Anda Benar!" class="bx bx-check bx-tada text-success d-flex align-items-center cursor-pointer" style="font-size: 20px;"></i>
            @endif
          </div>
          @elseif(!$score->correct && $answer->answer === $score->answer->answer)
          <div class="d-flex">
            @if (preg_match("/[\x{0000}-\x{007F}]/u", $answer->answer))
            <span class="badge bg-label-danger text-capitalize" style="text-transform:none; font-size: 0.9125em; padding: 0.42em 0.493em; text-align:start; line-height: 1;">{{ $answer->answer }}</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Anda Salah!" class="bx bx-x bx-tada text-danger d-flex align-items-center cursor-pointer" style="font-size: 20px;"></i>
            @else
            <span class="badge bg-label-danger mt-2" style="text-transform:none; font-size: 1.2rem; padding: 0.42em 0.493em; text-align:start; line-height: 1;">{{ $answer->answer }}</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Anda Salah!" class="bx bx-x bx-tada text-danger d-flex align-items-center cursor-pointer" style="font-size: 20px;"></i>
            @endif
          </div>
          @else
          @if (preg_match("/[\x{0000}-\x{007F}]/u", $answer->answer))
          <div>{{ $answer->answer }}</div>
          @else
          <div style="font-size: 1.3rem;">{{ $answer->answer }}</div>
          @endif
          @endif
        </label>
      </li>
      @else
      <li>
        @if (preg_match("/[\x{0000}-\x{007F}]/u", $answer->answer))
        <label class="form-check-label mb-1">
          {{ $answer->answer }}
        </label>
        @else
        <label class="form-check-label mb-1" style="font-size: 1.2rem;">
          {{ $answer->answer }}
        </label>
        @endif
      </li>
      @endif
      @endforeach
    </ol>
    @if($score->answer_id == null)<div class="d-flex" style="margin-left: 20px; margin-top:-10px; margin-bottom:20px"><span class="badge bg-label-warning" style="text-transform:none; font-size: 0.9125em; padding: 0.42em 0.493em;">Anda tidak menjawab soal ini!</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Anda Salah!" class="bx bx-error text-warning bx-flashing d-flex align-items-center cursor-pointer" style="font-size: 20px;"></i></div>@endif
    @endforeach
  </div>
</div>
@endsection