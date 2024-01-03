@extends('layouts.main.index')
@section('container')
<div class="row">
  <div class="col-md-12 col-lg-12 order-2 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <ul class="p-0 m-0">
          <div class="d-lg-flex justify-content-between">
            <div class="col mb-4 mb-lg-0">
              <div class="d-flex">
                <label for="textBiasa" class="form-label fw-bold">Masukkan Teks Biasa</label>
              </div>
              <textarea class="form-control fs-5" style="height: 250px;" id="textBiasa" rows="6"></textarea>
            </div>
            <div class="col ms-lg-3">
              <div class="d-flex justify-content-between">
                <label for="textResult" class="form-label fw-bold">Hasil</label>
                <button type="button" class="btn copyBtn p-0 dropdown-toggle hide-arrow d-none"><i id="copyButton" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Copy to Clipboard" class='bx bx-copy cursor-pointer fs-6'></i></button>
              </div>
              <textarea class="form-control fs-3" style="background-color: #fff; height: 250px;" id="textResult" disabled rows="6"></textarea>
            </div>
          </div>
        </ul>
      </div>
    </div>
  </div>
</div>
@section('script')
<script src="{{ asset('assets/js/index.js') }}"></script>
<script src="{{ asset('assets/js/ubahteks.js') }}"></script>
@endsection
@endsection