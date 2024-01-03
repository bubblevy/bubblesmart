@extends('layouts.main.index')
@section('container')
<h1 class="fs-5">Huruf Aksara</h1>
<div class="row">
  <div class="d-flex flex-wrap" id="icons-container">
    @foreach ($materis as $huruf)
    @if($huruf->category == "huruf")
    <div class="box card icon-card cursor-pointer text-center mb-4 mx-2" data-source-audio="{{ $huruf->audio }}">
      <div class="card-body">
        <h2><img src="@if(Storage::disk('public')->exists($huruf->image)) {{ asset('storage/'. $huruf->image) }} @else {{ asset('assets/img/'. $huruf->image) }} @endif" style="width: 45px;" alt="aksara {{ $huruf->title }}"></h2>
        <p class="icon-name text-capitalize text-truncate mb-0">{{ $huruf->title }}</p>
      </div>
    </div>
    @endif
    @endforeach
  </div>
</div>
<div class="row">
  <h1 class="fs-5 mt-2">Pasangan</h1>
  <div class="d-flex flex-wrap" id="icons-container">
    @foreach ($materis as $pasangan)
    @if($pasangan->category == "pasangan")
    <div class="box card icon-card cursor-pointer text-center  mb-4 mx-2">
      <div class="card-body">
        <h2><img src="@if(Storage::disk('public')->exists($pasangan->image)) {{ asset('storage/'. $pasangan->image) }} @else {{ asset('assets/img/'. $pasangan->image) }} @endif" style="width: 40px;" alt="pasangan {{ $pasangan->title }}"></h2>
        <p class="icon-name text-capitalize text-truncate mb-0">{{ $pasangan->title }}</p>
      </div>
    </div>
    @endif
    @endforeach
  </div>
</div>

<div class="row">
  <h1 class="fs-5 mt-3">Sandhangan</h1>
  <div class="d-flex flex-wrap" id="icons-container">
    @foreach ($materis as $sandhangan)
    @if($sandhangan->category == "sandhangan")
    <div class="box card icon-card cursor-pointer text-center mb-4 mx-2">
      <div class="card-body">
        <h2><img src="@if(Storage::disk('public')->exists($sandhangan->image)) {{ asset('storage/'. $sandhangan->image) }} @else {{ asset('assets/img/'. $sandhangan->image) }} @endif" style="width: 30px;" alt="sandhangan {{ $sandhangan->title }}"></h2>
        @if($sandhangan->title == 'taling_tarung')
        <p class="icon-name text-capitalize text-truncate mb-0" style="font-size: 12px;">Taling Tarung</p>
        @else
        <p class="icon-name text-capitalize text-truncate mb-0">{{ $sandhangan->title }}</p>
        @endif
      </div>
    </div>
    @endif
    @endforeach
  </div>
</div>


@foreach($materis as $audio)
@if($audio->audio)
<audio class="d-none" id="{{ $audio->audio }}" controls>
  <source src="@if(Storage::disk('public')->exists($audio->audio)) {{ asset('storage/'. $audio->audio) }} @else {{ asset('assets/'. $audio->audio) }} @endif" type="audio/mpeg">
</audio>
@endif
@endforeach

@section('script')
<script src="{{ asset('assets/js/materi/index.js') }}"></script>
@endsection
@endsection