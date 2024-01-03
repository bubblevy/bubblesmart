@extends('layouts.main.index')
@section('container')
@section('style')
<style>
  .required-label::after {
    content: " *";
    color: red;
  }

  .accordion-button::after {
    filter: grayscale(100%) brightness(1000%);
  }

  .rounded-custom {
    border-top-left-radius: 0.3rem !important;
    border-top-right-radius: 0.3rem !important;
  }

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

  .stick-top {
    position: sticky;
    bottom: 0;
    top: 10px;
  }

  .stick-top.course-content-fixed {
    top: 80px;
  }

  @media screen and (max-width: 1320px) {
    .navbreadcrumb {
      font-size: 14px;
    }
  }


  @media screen and (min-width: 1320px) {
    .navbreadcrumb {
      font-size: 14px;
    }
  }

  @media screen and (max-width: 575px) {
    .navbreadcrumb {
      font-size: small;
    }

    .pagination-mobile {
      display: flex;
      justify-content: end;
    }
  }
</style>
@endsection
<div class="flash-message" data-add-topic="@if(session()->has('addTopicSuccess')) {{ session('addTopicSuccess') }} @endif" data-edit-materi="@if(session()->has('editMateriSuccess')) {{ session('editMateriSuccess') }} @endif" data-delete-materi="@if(session()->has('deleteMateriSuccess')) {{ session('deleteMateriSuccess') }} @endif"></div>
<div class="card mb-4">
  <div class="card-body">
    <nav aria-label="breadcrumb" class="navbreadcrumb mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="/view/discuss" class="text-primary">Forum</a>
        </li>
        <li class="breadcrumb-item active">Details</li>
      </ol>
    </nav>
    <div class="row gy-4 mb-4">
      <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-2 gap-1">
          <div class="me-1 mb-2">
            <h5 class="mb-1 text-truncate text-wrap text-capitalize">{{ $thread->title }}</h5>
            <small class="text-muted">Dipost oleh <strong class="text-primary">{{ $thread->user->name }}</strong> {{ $thread->created_at->locale('id')->diffForHumans() }}</small>
          </div>
          <div class="d-flex">
            <div class="dropdown">
              <div class="d-flex align-items-center d-lg-block d-none cursor-pointer me-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class='bx bxs-heart text-danger fs-5 bx-sm mx-1' style="margin-bottom: 2px;"></i>{{ $thread->like->count() }} Suka
              </div>
              <div class="dropdown-menu dropdown-menu">
                @foreach($thread->like->load('thread','user') as $userLikes)
                <a class="dropdown-item">{{ $userLikes->user->name }} <strong class="text-danger" style="font-size: 10px;">Liked</strong></a>
                @endforeach
              </div>
            </div>
            <div class="d-flex align-items-center d-lg-none cursor-pointer me-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class='bx bxs-heart text-danger fs-5 bx-sm mx-1' style="margin-bottom: 2px;"></i>{{ $thread->like->count() }}
            </div>
            <div class="dropdown">
              <div class="d-flex align-items-center cursor-pointer" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class='bx bxs-share-alt fs-5 bx-sm mx-1'></i>Share
              </div>
              <div class="dropdown-menu dropdown-menu">
                <a class="dropdown-item" target="_blank" href="https://api.whatsapp.com/send?phone=&text={{ $thread->title . '%0A%0A' . url()->current() }}"><i class='bx bxl-whatsapp fs-5 bx-sm mb-1 me-2' style="color:#25D366"></i>WhatsApp</a>
                <a class="dropdown-item" target="_blank" href="https://www.facebook.com/sharer.php?u={{ url()->current() }}"><i class='bx bxl-facebook-square fs-5 bx-sm mb-1 me-2' style="color:#3b5998"></i>Facebook</a>
              </div>
            </div>
          </div>
        </div>
        <p class="mb-4 mt-4">
          {{ $thread->content }}
        </p>
        <hr class="my-4">
        <form class="mb-5" action="" method="post">
          @csrf
          <div>
            <label for="comment" class="form-label required-label">Tambah Komentar</label>
            <textarea class="form-control komentar mb-3 @error('comment') is-invalid @enderror" id="comment" name="comment" autocomplete="off" placeholder="Masukkan komentar anda di sini" rows="5" required>{{ old('comment') }}</textarea>
            @error('comment')
            <div class="invalid-feedback" style="margin-bottom: 5px; margin-top:-5px">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div>
            <button type="submit" class="btn btn-label-primary btn-comment disabled"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Kirim</button>
          </div>
        </form>
        <h5 class="mb-4" id="comments">({{ $thread->comment->count() }}) Komentar</h5>
        @if($comments->isEmpty())
        <span class="d-flex justify-content-lg-start justify-content-center mb-2"><i class='bx bx-info-circle fs-5' style="margin-top: 3px;"></i>&nbsp;Belum ada komentar!</span>
        @endif
        @foreach($comments as $comment)
        <div>
          <div class="d-flex justify-content-start align-items-center user-name mb-2">
            <div class="avatar-wrapper">
              <div class="avatar avatar-sm me-2"><img src="@if(Storage::disk('public')->exists($comment->user->image)) {{ asset('storage/'. $comment->user->image) }} @else {{ asset('assets/img/'. $comment->user->image) }} @endif" alt="Author" class="rounded-circle"></div>
            </div>
            <div class="d-flex flex-column">
              <span class="fw-bold">{{ $comment->user->name }}@if($comment->user->is_admin) <i class='bx bxs-badge-check text-primary' style="margin-bottom: 1px; font-size:13px" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Administrator"></i> @endif</span>
              <small class="text-muted">{{ $comment->created_at->locale('id')->diffForHumans() }}</small>
            </div>
          </div>
          <p style="margin-left: 2.5rem;">{{ $comment->comment }}</p>
          <div class="d-flex cursor-pointer" style="margin-left: 2.5rem; font-size:14px;">
            <div class="me-2 text-primary fw-bold toggle-reply-form" data-target=".comment-reply-{{ $comment->id }}"><i class='bx bx-share fs-6 bx-sm mx-1'></i>Balas</div>
            @if($comment->user->id == auth()->user()->id)
            <div class="text-danger fw-bold button-delete-comment" data-message-comment="{{ $comment->comment }}" data-id-comment="{{ $comment->id }}"><i class='bx bx-trash fs-6 bx-sm mx-1'></i>Hapus</div>
            @endif
          </div>

          <div class="mt-3 comment-reply comment-reply-{{ $comment->id }} d-none" style="margin-left: 2.5rem;">
            <form class="mb-2" action="" method="post">
              @csrf
              <input type="hidden" value="{{ $comment->id }}" name="parent_id">
              <div>
                <label for="comment-{{ $comment->id }}" class="form-label required-label">Balas Komentar</label>
                <textarea class="form-control komentar mb-3 @error('comment') is-invalid @enderror" id="comment-{{ $comment->id }}" name="comment" autocomplete="off" placeholder="Masukkan balasan komentar anda di sini" rows="5" required>{{ old('comment') }}</textarea>
                @error('comment')
                <div class="invalid-feedback" style="margin-bottom: 5px; margin-top:-5px">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="divBtn" style="cursor: not-allowed;">
                <button type="submit" class="btn btn-label-primary btn-comment disabled me-1"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Kirim</button>
                <button type="button" class="btn btn-outline-secondary batal-reply-button" data-cancel-comment="{{ $comment->id }}"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
              </div>
            </form>
          </div>
        </div>
        <hr>
        @if($comment->replies->count() > 0)
        @foreach($comment->replies as $reply)
        <div style="margin-left: 2.5rem;">
          <div class="d-flex justify-content-start align-items-center user-name mb-2">
            <div class="avatar-wrapper">
              <div class="avatar avatar-sm me-2"><img src="@if(Storage::disk('public')->exists($reply->user->image)) {{ asset('storage/'. $reply->user->image) }} @else {{ asset('assets/img/'. $reply->user->image) }} @endif" alt="Author" class="rounded-circle"></div>
            </div>
            <div class="d-flex flex-column">
              <span class="fw-bold">{{ $reply->user->name }}@if($reply->user->is_admin) <i class='bx bxs-badge-check text-primary' style="margin-bottom: 1px; font-size:13px" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Administrator"></i> @endif</span>
              <small class="text-muted">{{ $reply->created_at->locale('id')->diffForHumans() }}</small>
            </div>
          </div>
          <p style="margin-left: 2.5rem;">{{ $reply->comment }}</p>
          <div class="d-flex cursor-pointer" style="margin-left: 2.5rem; font-size:14px;">
            <div class="me-2 text-primary fw-bold toggle-reply-form" data-target=".comment-reply-{{ $reply->id }}"><i class='bx bx-share fs-6 bx-sm mx-1'></i>Balas</div>
            @if($reply->user->id == auth()->user()->id)
            <div class="text-danger fw-bold button-delete-comment" data-message-comment="{{ $reply->comment }}" data-id-comment="{{ $reply->id }}"><i class='bx bx-trash fs-6 bx-sm mx-1'></i>Hapus</div>
            @endif
          </div>

          <div class="mt-3 comment-reply comment-reply-{{ $reply->id }} d-none" style="margin-left: 2.5rem;">
            <form class="mb-2" action="" method="post">
              @csrf
              <input type="hidden" value="{{ $comment->id }}" name="parent_id">
              <div>
                <label for="comment-{{ $reply->id }}" class="form-label required-label">Balas Komentar</label>
                <textarea class="form-control komentar mb-3 @error('comment') is-invalid @enderror" id="comment-{{ $reply->id }}" name="comment" autocomplete="off" placeholder="Masukkan balasan komentar anda di sini" rows="5" required>{{ old('comment') }}</textarea>
                @error('comment')
                <div class="invalid-feedback" style="margin-bottom: 5px; margin-top:-5px">
                  {{ $message }}
                </div>
                @enderror
              </div>
              <div class="divBtn" style="cursor: not-allowed;">
                <button type="submit" class="btn btn-label-primary btn-comment disabled me-1"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Kirim</button>
                <button type="button" class="btn btn-outline-secondary batal-reply-button" data-cancel-comment="{{ $reply->id }}"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
              </div>
            </form>
          </div>
        </div>
        <hr>
        @endforeach
        @endif
        @endforeach
      </div>
      <div class="col-lg-4">
        <div class="accordion stick-top accordion-bordered">
          <div class="accordion-item shadow-none border border-primary border-bottom active mb-0">
            <div class="accordion-header">
              <button type="button" class="accordion-button bg-primary rounded-custom" data-bs-toggle="collapse" data-bs-target="#topic" aria-expanded="true">
                <span class="d-flex flex-column">
                  <span class="h5 mb-1 text-white ">Topik Terbaru</span>
                </span>
              </button>
            </div>
            <div id="topic" class="accordion-collapse collapse show">
              <div class="accordion-body py-3 border-top">
                @php $i=1; @endphp
                @foreach($threads as $newsthread)
                @if($newsthread->id != $thread->id && $i <= 5) <div class=" d-flex align-items-center mb-3" onclick="window.location.href='/view/discuss/thread/{{$newsthread->id}}'">
                  <label class="form-check-label cursor-pointer">
                    <span class="mb-0 h6"> {{ $i++ }}. {{ $newsthread->title }} </span>
                    <small class="text-muted d-block">Dipost oleh <strong class="text-primary">{{ $newsthread->user->name }}</strong> {{ $newsthread->created_at->locale('id')->diffForHumans() }}</small>
                  </label>
              </div>
              @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- modal delete Comment -->
<div class="modal fade" id="deleteCommentConfirm" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post" id="formDeleteComment">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body" style="margin-top: -10px;">
          <div class="col-sm fs-6 commentMessagesDelete"></div>
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
<script src="{{ asset('assets/js/forum/detail.js') }}"></script>
@endsection
@endsection