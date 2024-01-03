@extends('layouts.main.index')
@section('container')
@section('style')
<style>
  @media screen and (max-width: 1320px) {
    .navbreadcrumb {
      font-size: 14px;
    }
  }

  .required-label::after {
    content: " *";
    color: red;
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

  ::-webkit-scrollbar {
    display: none;
  }
</style>
@endsection
<nav aria-label="breadcrumb" class="navbreadcrumb ">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/admin/data-quiz" class="text-primary">Data Quiz</a>
    </li>
    <li class="breadcrumb-item">
      <a href="/admin/data-quiz/q&a/{{ $code }}" class="text-primary">Q&A</a>
    </li>
    <li class="breadcrumb-item active">{{ $titleQuiz }}</li>
  </ol>
</nav>
<div class="flash-message" data-add-question="@if(session()->has('questionSuccess')) {{ session('questionSuccess') }} @endif" data-add-question-failed="@if(session()->has('questionFailed')) {{ session('questionFailed') }} @endif" data-update-question-error="@if(session()->has('updateQuestionError')) {{ session('updateQuestionError') }} @endif" data-edit-question="@if(session()->has('updateQuestionSuccess')) {{ session('updateQuestionSuccess') }} @endif" data-edit-question-failed="@if(session()->has('editQuestionFailed')) {{ session('editQuestionFailed') }} @endif" data-delete-question="@if(session()->has('deleteQuestion')) {{ session('deleteQuestion') }} @endif" data-error-delete-question="@if(session()->has('deleteQuestionError')) {{ session('deleteQuestionError') }} @endif"></div>
<div class="row">
  <div class="col-md-12 col-lg-12 order-2 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between" style="margin-bottom: -0.7rem;">
        <div class="justify-content-start">
          <button type="button" class="btn btn-xs btn-dark fw-bold p-2" data-bs-toggle="modal" data-bs-target="#formModalAdminAddQuestions">
            <i class='bx bx-notepad fs-6' style="margin-bottom: 3px;"></i>&nbsp;TAMBAH SOAL
          </button>
        </div>
        <div class="justify-content-end">
          <form action="/admin/data-quiz/q&a/{{ $code }}/search">
            <div class="input-group">
              <input type="search" class="form-control" name="q" id="search" style="border: 1px solid #d9dee3;" value="{{ request('q') }}" placeholder="Cari Pertanyaan..." autocomplete="off" />
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
                  <th class="text-white">Pertanyaan</th>
                  <th class="text-white">Option 1</th>
                  <th class="text-white">Option 2</th>
                  <th class="text-white">Option 3</th>
                  <th class="text-white">Option 4</th>
                  <th class="text-white text-center">Score</th>
                  <th class="text-white">Tanggal Pembuatan Soal</th>
                  <th class="text-white">Tanggal Update Soal</th>
                  <th class="text-white text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($questions as $index => $q)
                <tr>
                  <td>{{ $questions->firstItem() + $index }}</td>
                  @if (preg_match("/[\x{0000}-\x{007F}]/u", $q->question))
                  <td>{{ $q->question }}</td>
                  @else
                  <td style="font-size: 18px;">{{ $q->question }}</td>
                  @endif
                  @foreach($q->answer as $answer)
                  @if($answer->correct === 1)
                  @if (preg_match("/[\x{0000}-\x{007F}]/u", $answer->answer))
                  <td><span class="badge bg-label-success text-capitalize" style="font-size: 14px;">{{ $answer->answer }}</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Benar!" class="bx bx-check bx-tada text-success" style="font-size: 20px;"></i></td>
                  @else
                  <td><span class="badge bg-label-success text-capitalize" style="font-size: 17px;">{{ $answer->answer }}</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Benar!" class="bx bx-check bx-tada text-success" style="font-size: 20px;"></i></td>
                  @endif
                  @else
                  @if (preg_match("/[\x{0000}-\x{007F}]/u", $answer->answer))
                  <td><span class="badge bg-label-danger text-capitalize" style="font-size: 14px;">{{ $answer->answer }}</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Salah!" class="bx bx-x bx-tada text-danger" style="font-size: 20px;"></i></td>
                  @else
                  <td><span class="badge bg-label-danger text-capitalize" style="font-size: 17px;">{{ $answer->answer }}</span>&nbsp;<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Jawaban Salah!" class="bx bx-x bx-tada text-danger" style="font-size: 20px;"></i></td>
                  @endif
                  @endif
                  @endforeach
                  <td class="text-center"><span class="badge badge-center bg-dark rounded-pill">{{ $q->score }}</span></td>
                  <td>{{ $q->created_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td>{{ $q->updated_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td class="text-center">
                    <button type="button" class="btn btn-icon btn-primary btn-sm buttonEditQuestion" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Edit Quiz" data-edit-question="{{ $q->question  }}" data-code-question="{{ encrypt($q->id)  }}" data-edit-score="{{ $q->score  }}">
                      <span class="tf-icons bx bx-edit" style="font-size: 15px;"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger btn-sm buttonDeleteQuestion" data-action="{{ $q->id  }}" data-delete-question="{{ $q->question  }}" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Hapus History Quiz">
                      <span class="tf-icons bx bx-trash" style="font-size: 14px;"></span>
                    </button>
                  </td>
                </tr>
                @endforeach
                @if($questions->isEmpty())
                <tr>
                  <td colspan="100" class="text-center">Data tidak ditemukan dengan keyword pencarian: <b>"{{request('q')}}"</b></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </ul>
        @if(!$questions->isEmpty())
        <div class="mt-3 pagination-mobile">{{ $questions->withQueryString()->onEachSide(1)->links() }}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<div id="errorModaladdQuestion" data-error-question="@error('question') {{ $message }} @enderror" data-error-option1="@error('option1') {{ $message }} @enderror" data-error-option2="@error('option2') {{ $message }} @enderror" data-error-option3="@error('option3') {{ $message }} @enderror" data-error-option4="@error('option4') {{ $message }} @enderror" data-error-score="@error('score') {{ $message }} @enderror" data-error-correct="@error('correct') {{ $message }} @enderror"></div>
<!-- Modal add question-->
<div class="modal fade" id="formModalAdminAddQuestions" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/data-quiz/q&a/{{ $code }}" method="post" class="modalAdminAddQuestions">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Tambah Pertanyaan <i class='bx bx-notepad fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalAddQuestion" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="question" class="form-label required-label">Pertanyaan</label>
              <textarea class="form-control @error('question') is-invalid @enderror" id="question" name="question" placeholder="Masukkan pertanyaan disini." rows="3" autocomplete="off" required>{{ old('question') }}</textarea>
              @error('question')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row g-2 mb-3">
            <div class="col">
              <label for="option1" class="form-label required-label">Option 1</label>
              <input type="text" id="option1" name="option[1]" value="{{ old('option.1') }}" class="form-control @error('option.1') is-invalid @enderror" autocomplete="off" placeholder="Option pertama" required>
              @error('option.1')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="col">
              <label for="option2" class="form-label required-label">Option 2</label>
              <input type="text" id="option2" name="option[2]" value="{{ old('option.2') }}" class="form-control @error('option.2') is-invalid @enderror" autocomplete="off" placeholder="Option kedua" required>
              @error('option.2')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row g-2 mb-3">
            <div class="col">
              <label for="option3" class="form-label required-label">Option 3</label>
              <input type="text" id="option3" name="option[3]" value="{{ old('option.3') }}" class="form-control @error('option.3') is-invalid @enderror" autocomplete="off" placeholder="Option ketiga" required>
              @error('option.3')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="col">
              <label for="option4" class="form-label required-label">Option 4</label>
              <input type="text" id="option4" name="option[4]" value="{{ old('option.4') }}" class="form-control @error('option.4') is-invalid @enderror" autocomplete="off" placeholder="Option keempat" required>
              @error('option.4')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row g-2">
            <div class="col">
              <label for="correct" class="form-label required-label">Jawaban Benar</label>
              <select class="form-select @error('correctAnswer') is-invalid @enderror" name="correctAnswer" id="correct" style="cursor: pointer;">
                <option value="" selected disabled>Pilih Jawaban</option>
                <option value="1" @if(old('correctAnswer')==1) selected @endif>Option 1</option>
                <option value="2" @if(old('correctAnswer')==2) selected @endif>Option 2</option>
                <option value="3" @if(old('correctAnswer')==3) selected @endif>Option 3</option>
                <option value="4" @if(old('correctAnswer')==4) selected @endif>Option 4</option>
              </select>
              @error('correctAnswer')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="col">
              <label for="score" class="form-label required-label">Score</label>
              <input type="number" id="score" name="score" value="{{ old('score') }}" class="form-control @error('score') is-invalid @enderror" autocomplete="off" placeholder="Score untuk pertanyaan" required>
              @error('score')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalAddQuestion" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div id="errorModalEditQuestion" data-error-edit-question="@error('editQuestion') {{ $message }} @enderror" data-error-edit-option1="@error('editOption.1') {{ $message }} @enderror" data-error-edit-option2="@error('editOption.2') {{ $message }} @enderror" data-error-edit-option3="@error('editOption.3') {{ $message }} @enderror" data-error-edit-option4="@error('editOption.4') {{ $message }} @enderror" data-error-edit-score="@error('editScore') {{ $message }} @enderror" data-error-edit-correct="@error('editCorrect') {{ $message }} @enderror"></div>
<!-- Modal edit question-->
<div class="modal fade" id="formModalAdminEditQuestion" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="/admin/data-quiz/q&a/update/question" method="post" class="modalAdminEditQuestion">
      @csrf
      <input type="hidden" name="codeQuestion" value="{{ old('codeQuestion') }}" id="codeQuestion">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Edit Soal&nbsp;<i class='bx bx-notepad fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalEditQuestion" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="editquestion" class="form-label required-label">Pertanyaan</label>
              <textarea class="form-control @error('editQuestion') is-invalid @enderror" id="editquestion" name="editQuestion" placeholder="Masukkan pertanyaan disini." rows="3" autocomplete="off" required>{{ old('editQuestion') }}</textarea>
              @error('editQuestion')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row g-2 mb-3">
            <div class="col">
              <label for="editOption1" class="form-label required-label">Option 1</label>
              <input type="text" id="editOption1" name="editOption[1]" value="{{ old('editOption.1') }}" class="form-control @error('editOption.1') is-invalid @enderror" autocomplete="off" placeholder="Option pertama" required>
              @error('editOption.1')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="col">
              <label for="editOption2" class="form-label required-label">Option 2</label>
              <input type="text" id="editOption2" name="editOption[2]" value="{{ old('editOption.2') }}" class="form-control @error('editOption.2') is-invalid @enderror" autocomplete="off" placeholder="Option kedua" required>
              @error('editOption.2')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row g-2 mb-3">
            <div class="col">
              <label for="editOption3" class="form-label required-label">Option 3</label>
              <input type="text" id="editOption3" name="editOption[3]" value="{{ old('editOption.3') }}" class="form-control @error('editOption.3') is-invalid @enderror" autocomplete="off" placeholder="Option ketiga" required>
              @error('editOption.3')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="col">
              <label for="editOption4" class="form-label required-label">Option 4</label>
              <input type="text" id="editOption4" name="editOption[4]" value="{{ old('editOption.4') }}" class="form-control @error('editOption.4') is-invalid @enderror" autocomplete="off" placeholder="Option keempat" required>
              @error('editOption.4')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row g-2">
            <div class="col">
              <label for="editCorrect" class="form-label required-label">Jawaban Benar</label>
              <select class="form-select @error('editCorrectAnswer') is-invalid @enderror" name="editCorrectAnswer" id="editCorrect" style="cursor: pointer;">
                <option value="" selected disabled>Pilih Jawaban</option>
                <option class="dipilih1" value="1" @if(old('editCorrectAnswer')==1) selected @endif>Option 1</option>
                <option class="dipilih2" value="2" @if(old('editCorrectAnswer')==2) selected @endif>Option 2</option>
                <option class="dipilih3" value="3" @if(old('editCorrectAnswer')==3) selected @endif>Option 3</option>
                <option class="dipilih4" value="4" @if(old('editCorrectAnswer')==4) selected @endif>Option 4</option>
              </select>
              @error('editCorrectAnswer')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
            <div class="col">
              <label for="editScore" class="form-label required-label">Score</label>
              <input type="number" id="editScore" name="editScore" value="{{ old('editScore') }}" class="form-control @error('editScore') is-invalid @enderror" autocomplete="off" placeholder="Score untuk pertanyaan" required>
              @error('editScore')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalEditQuestion" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-save fs-6' style="margin-bottom: 3px;"></i>&nbsp;Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- modal delete question -->
<div class="modal fade" id="deleteQuestionConfirm" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post" id="formDeleteQuestion">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body" style="margin-top: -10px;">
          <div class="col-sm fs-6 questionMessagesDelete"></div>
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
<script src="{{ asset('assets/js/dataquiz/show.js') }}"></script>
@endsection
@endsection