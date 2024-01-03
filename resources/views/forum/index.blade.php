@extends('layouts.main.index')
@section('container')
@section('style')
<style>
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
<div class="flash-message" data-add-topic="@if(session()->has('addTopicSuccess')) {{ session('addTopicSuccess') }} @endif" data-delete-topic="@if(session()->has('deleteTopicSuccess')) {{ session('deleteTopicSuccess') }} @endif"></div>
<div class="card mb-4">
  <div class="card-header mb-1">
    <div class="d-flex justify-content-between">
      <div>
        <button type="button" class="btn btn-xs btn-dark fw-bold p-2" data-bs-toggle="modal" data-bs-target="#formModalAddTopic">
          <i class='bx bx-message-dots fs-6'></i>&nbsp;TAMBAH THREAD
        </button>
      </div>
      <div>
        <form action="/view/discuss/search">
          <div class="input-group">
            <input type="search" class="form-control" name="q" id="search" style="border: 1px solid #d9dee3; width:300px" placeholder="Cari Topik Diskusi..." autocomplete="off" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row gy-4 mb-4">
      @foreach($threads as $thread)
      <div class="col-md-6 col-xl-4">
        <div class="card h-100 shadow-none border">
          <div class="card-header flex-grow-0">
            <div class="d-flex">
              <div class="avatar flex-shrink-0 me-3">
                <img src="@if(Storage::disk('public')->exists($thread->user->image)) {{ asset('storage/'. $thread->user->image) }} @else {{ asset('assets/img/'. $thread->user->image) }} @endif" alt="Author" class="rounded-circle">
              </div>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-1">
                <div class="me-2">
                  <h5 class="mb-0 fw-semibold">{{ $thread->user->name }}@if($thread->user->is_admin) <i class='bx bxs-badge-check text-primary fs-6' style="margin-bottom: 1px;" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Administrator"></i> @endif</h5>
                  <small class="text-muted">Dipost {{ $thread->created_at->locale('id')->diffForHumans() }}</small>
                </div>
                @if($thread->user->id == auth()->user()->id)
                <div class="dropdown">
                  <button class="btn p-0" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-chevron-down"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item cursor-pointer button-delete-topic" data-message-topic="{{ $thread->title }}" data-code="{{ encrypt($thread->id) }}"><i class='bx bx-trash fs-5 mb-1 me-2'></i>Hapus</a>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>
          <div class="card-body">
            <h1 class="text-truncate text-capitalize cursor-pointer" style="font-size: 1rem;" onclick="window.location.href='/view/discuss/thread/{{$thread->id}}'">{{ $thread->title }}</h1>
            <div class="d-flex mt-4 align-items-center justify-content-between">
              <div class="card-actions">
                @php
                $userLiked = false;
                foreach ($thread->like as $like) {
                if ($like->user_id == auth()->user()->id && $like->thread_id == $thread->id) {
                $userLiked = true;
                break;
                }
                }
                @endphp
                <div class="d-flex">
                  <div class="like-container">
                    <a data-thread="{{ $thread->id }}" class="text-muted likebutton cursor-pointer me-3">
                      @if ($userLiked)
                      <i class="bx bxs-heart text-danger mb-1 me-1"></i>
                      @else
                      <i class="bx bx-heart mb-1 me-1"></i>
                      @endif
                      {{ $thread->like->count() }}
                    </a>
                  </div>
                  <a onclick="window.location.href='/view/discuss/thread/{{$thread->id}}#comments'" class="text-muted cursor-pointer"><i class="bx bx-chat me-1" style="margin-bottom: 1px;"></i> {{ $thread->comment->count() }}</a>
                </div>
              </div>
              <div>
                <a style="font-size: 0.875rem;" href="/view/discuss/thread/{{$thread->id}}">Lihat Detail <i class='bx bx-right-arrow-alt mb-1'></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    @if($threads->isEmpty())
    <span class="d-flex justify-content-center mb-2"><i class='bx bx-info-circle fs-5' style="margin-top: 3px;"></i>&nbsp;Data tidak ditemukan!</span>
    @endif

    @if(!$threads->isEmpty() && $threads->lastPage() != 1)
    <nav aria-label="Page navigation" class="d-flex align-items-center justify-content-center">
      <ul class="pagination">
        <li class="page-item {{ $threads->previousPageUrl() ? '' : 'disabled' }}">
          <a class="page-link" href="{{ $threads->previousPageUrl() }}">&lsaquo;</a>
        </li>
        @foreach ($threads->getUrlRange(1, $threads->lastPage()) as $page => $url)
        <li class="page-item {{ $page == $threads->currentPage() ? 'active' : '' }}">
          <a class="page-link" href="{{ $url }}">{{ $page }}</a>
        </li>
        @endforeach
        <li class="page-item {{ $threads->nextPageUrl() ? '' : 'disabled' }}">
          <a class="page-link" href="{{ $threads->nextPageUrl() }}">&rsaquo;</a>
        </li>
      </ul>
    </nav>
    @endif

  </div>
</div>

<div id="errorModalAddTopic" data-error-title="@error('title') {{ $message }} @enderror" data-error-content="@error('content') {{ $message }} @enderror"></div>
<!-- Modal Add New Topic Thread-->
<div class="modal fade" id="formModalAddTopic" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post" class="modalAddTopic">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Tambah Thread Baru&nbsp;<i class='bx bx-message-dots fs-5' style="margin-bottom: 1px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalAddTopic" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="title" class="form-label required-label">Judul</label>
              <input type="text" id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul thread" autocomplete="off" required>
              @error('title')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col">
              <label for="content" class="form-label required-label">Deskripsi</label>
              <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" autocomplete="off" placeholder="Masukkan deskripsi thread" rows="4" required>{{ old('content') }}</textarea>
              @error('content')
              <div class="invalid-feedback" style="margin-bottom: -3px;">
                {{ $message }}
              </div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger cancelModalAddTopic" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-paper-plane fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- Modal Delete Topic Thread -->
<div class="modal fade" id="deleteTopicConfirm" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post" id="formDeleteTopic">
      @csrf
      <input type="hidden" id="code-thread" name="code" value="old('code')">
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body" style="margin-top: -10px;">
          <div class="col-sm fs-6 topicMessagesDelete"></div>
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
<script src="{{ asset('assets/js/forum/index.js') }}"></script>
@endsection
@endsection