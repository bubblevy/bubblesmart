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
      <div class="card-body">
        <ul class="p-0 m-0">
          <div class="table-responsive text-nowrap" style="border-radius: 3px;">
            <table class="table table-striped">
              <thead class="table-dark">
                <tr>
                  <th class="text-white">No</th>
                  <th class="text-white">Judul Quiz</th>
                  <th class="text-white">Deskripsi Quiz</th>
                  <th class="text-white text-center">Total Yang Mengerjakan Quiz</th>
                  <th class="text-white text-center">Aksi</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach($reports as $index => $data)
                <tr>
                  <td>{{ $reports->firstItem() + $index }}</td>
                  @if (preg_match("/[\x{0000}-\x{007F}]/u", $data->title))
                  <td>{{ Str::limit($data->title, 30, '...') }}</td>
                  @else
                  <td style="font-size: 18px;">{{ Str::limit($data->title, 20, '...') }}</td>
                  @endif
                  <td>{{ Str::limit($data->description, 50, '...')}}</td>
                  <td class="text-center"><span class="badge bg-label-primary fw-bold">{{ $data->result->count() }}&nbsp;Orang</span></td>
                  <td class="text-center">
                    <button type="button" class="btn btn-icon btn-primary btn-sm" onclick="window.location.href='/admin/laporan/{{ $data->slug }}'" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Lihat yang mengerjakan">
                      <span class="tf-icons bx bx-show" style="font-size: 15px;"></span>
                    </button>
                  </td>
                </tr>
                @endforeach
                @if($reports->isEmpty())
                <tr>
                  <td colspan="100" class="text-center">Data laporan tidak ditemukan!</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
        </ul>
        @if(!$reports->isEmpty())
        <div class="mt-3 pagination-mobile">{{ $reports->withQueryString()->onEachSide(1)->links() }}</div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection