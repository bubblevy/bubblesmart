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

  @media screen and (max-width: 575px) {
    .pagination-mobile {
      display: flex;
      justify-content: end;
    }
  }
</style>
@endsection
<div class="row">
  <div class="col-md-12 col-lg-12 order-2 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between" style="margin-bottom: -0.7rem;">
        <div class="justify-content-start">
          <select id="score-filter" class="form-select" style="border: 1px solid #d9dee3;">
            <option disabled selected>Filter Nilai</option>
            <option value="teratas" @if(request('filter')==='teratas' ) selected @endif>Nilai Teratas</option>
            <option value="terendah" @if(request('filter')==='terendah' ) selected @endif>Nilai Terendah</option>
          </select>
        </div>
        <div class="justify-content-end">
          <form action="/nilai/search">
            <div class="input-group">
              <input type="search" class="form-control" name="q" id="search" style="border: 1px solid #d9dee3;" value="{{ request('q') }}" placeholder="Cari Histori Quiz..." autocomplete="off" />
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
                  <th class="text-white">Total Soal</th>
                  <th class="text-white">Soal Yang Dikerjakan</th>
                  <th class="text-white">Soal Tidak DIkerjakan</th>
                  <th class="text-white">Tanggal Submit Quiz</th>
                  <th class="text-white">Nilai</th>
                  <th class="text-white text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($histories as $index => $history)
                <tr>
                  <td>{{ $histories->firstItem() + $index }}</td>
                  @if (preg_match("/[\x{0000}-\x{007F}]/u",$history->quiz->title))
                  <td>{{ Str::limit($history->quiz->title, 30, '...') }}</td>
                  @else
                  <td style="font-size: 18px;">{{ Str::limit($history->quiz->title, 21, '...') }}</td>
                  @endif
                  <td>{{ Str::limit($history->quiz->description, 50, '...')}}</td>
                  <td class="text-center"><span class="badge badge-center bg-dark rounded-pill">{{ $history->quiz->load('question')->question->count() }}</span></td>
                  <td><i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Task Icon" class="bx bx-task bx-tada text-primary" style="font-size: 19px;"></i>&nbsp;<span class="badge bg-label-primary">{{ $history->answer_user->where('answer_id', !null)->count() }} Soal dikerjakan</span></td>
                  <td>{!! (($history->quiz->load('question')->question->count() - $history->answer_user->where('answer_id', !null)->count()) > 0) ? '<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Danger Icon" class="bx bx-error bx-flashing text-danger" style="font-size: 19px;"></i>&nbsp;<span class="badge bg-label-danger">'. $history->quiz->load('question')->question->count() - $history->answer_user->where('answer_id', !null)->count() . ' Soal tidak dikerjakan</span>' : '<i data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="right" title="Check Icon" class="bx bx-check-double bx-tada text-success" style="font-size: 20px;"></i>&nbsp;<span class="badge bg-label-dark">Dikerjakan Semua</span>' !!}</td>
                  <td>{{ $history->created_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}</td>
                  <td class="text-center"><span class="badge badge-center bg-dark rounded-pill">{{ $history->score }}</span></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-icon btn-primary btn-sm" onclick="window.location.href='/nilai/details/{{ $history->code }}'">
                      <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Details" class="tf-icons bx bx-show" style="font-size: 15px;"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger btn-sm buttonDeleteHistory" data-bs-toggle="modal" data-action="{{ $history->code }}" data-delete-tanggal="{{ $history->created_at->locale('id')->isoFormat('D MMMM YYYY | H:mm') }}" data-bs-target="#deleteConfirm">
                      <span data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Hapus History Quiz" class="tf-icons bx bx-trash" style="font-size: 14px;"></span>
                    </button>
                  </td>
                </tr>
                @endforeach
                @if($histories->isEmpty())
                <tr>
                  <td colspan="100" class="text-center">Data tidak ditemukan dengan keyword pencarian: <b>"{{request('q')}}"</b></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </ul>

        @if(!$histories->isEmpty())
        <div class="mt-3 pagination-mobile">{{ $histories->withQueryString()->onEachSide(1)->links() }}</div>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteConfirm" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="" method="post" id="formDeleteNilai">
      @csrf
      <div class="modal-content">
        <div class="modal-header d-flex justify-content-between">
          <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
        </div>
        <div class="modal-body">
          <div class="col-sm fs-6 tanggalHistory"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tidak</button>
          <button type="submit" class="btn btn-primary"><i class='bx bx-trash fs-6' style="margin-bottom: 3px;"></i>&nbsp;Ya, Hapus!</button>
        </div>
      </div>
    </form>
  </div>
</div>

@section('script')
<script src="{{ asset('assets/js/nilai/index.js') }}"></script>
@endsection
@endsection