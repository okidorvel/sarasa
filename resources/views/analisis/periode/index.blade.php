@extends('layouts.app')

@section('title', 'Periode')

@section('content-header')
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url({{ asset('/img/cover-bg.jpg') }}); background-size: cover; background-position: center top;">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card shadow h-100">
                    <div class="card-header border-0">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between text-center text-md-left">
                            <div class="mb-3">
                                <h2 class="mb-0">Periode</h2>
                                <p class="mb-0 text-sm">Kelola Analisis - {{ $analisis->nama }}</p>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('analisis.index') }}" class="btn btn-success" title="Kembali" data-toggle="tooltip"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('form-search')
<form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto" action="{{ URL::current() }}" method="GET">
    <div class="form-group mb-0">
        <div class="input-group input-group-alternative">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input class="form-control" placeholder="Cari ...." type="search" name="cari" value="{{ request('cari') }}">
        </div>
    </div>
</form>
@endsection

@section('form-search-mobile')
<form class="mt-4 mb-3 d-md-none" action="{{ URL::current() }}" method="GET">
    <div class="input-group input-group-rounded input-group-merge">
        <input type="search" name="cari" class="form-control form-control-rounded form-control-prepended" placeholder="cari" aria-label="Search" value="{{ request('cari') }}">
        <div class="input-group-prepend">
            <div class="input-group-text">
                <span class="fa fa-search"></span>
            </div>
        </div>
    </div>
</form>
@endsection

@section('content')
@include('layouts.components.alert')
@include('analisis.detail')
<div class="card shadow">
    <div class="card-header">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between text-center text-md-left">
            <div class="mb-1">
                <h2 class="mb-0">Periode</h2>
            </div>
            <div class="mb-1">
                <button type="button" data-toggle="tooltip" title="Hapus data terpilih" class="btn btn-sm btn-danger" id="delete" name="delete" >
                    <i class="fas fa-trash"></i>
                </button>
                <a href="{{ route('periode.create', $analisis) }}?page={{ request('page') }}" class="btn btn-sm btn-primary" title="Tambah" data-toggle="tooltip"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm table-striped table-bordered">
                <thead>
                    <th class="text-center" width="10px">
                        <input type="checkbox" name="check_all" id="check_all">
                    </th>
                    <th class="text-center" width="10px">No</th>
                    <th class="text-center" width="50px">Opsi</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Tahun Pelaksanaan</th>
                    <th class="text-center">Tahap Pendataan</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Aktif</th>
                </thead>
                <tbody>
                    @forelse ($periode as $item)
                        <tr>
                            <td style="vertical-align: middle">
                                <input type="checkbox" class="periode-checkbox" id="delete{{ $item->id }}" name="delete[]" value="{{ $item->id }}">
                            </td>
                            <td style="vertical-align: middle" class="text-center">{{ ($periode->currentpage()-1) * $periode->perpage() + $loop->index + 1 }}</td>
                            <td style="vertical-align: middle">
                                <a href="{{ route('periode.edit', ['periode' => $item, 'analisis' => $analisis]) }}?page={{ request('page') }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-sm btn-danger hapus-data" data-nama="{{ $item->nama }}" data-action="{{ route("periode.destroy", ['periode' => $item, 'analisis' => $analisis]) }}" data-toggle="tooltip" title="Hapus" href="#modal-hapus"><i class="fas fa-trash"></i></a>
                            </td>
                            <td style="vertical-align: middle">{{ $item->nama }}</td>
                            <td style="vertical-align: middle">{{ $item->tahun }}</td>
                            <td style="vertical-align: middle">{{ $item->tahap_pendataan == 1 ? 'Belum Pendataan' : ($item->tahap_pendataan == 2 ? 'Sedang Pendataan' : ($item->tahap_pendataan == 3 ? 'Selesai Pelaksanaan' : '-')) }}</td>
                            <td style="vertical-align: middle">{{ $item->keterangan }}</td>
                            <td style="vertical-align: middle">{{ $item->status == 1 ? 'Aktif' : 'Tidak Aktif' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" align="center">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $periode->links('layouts.components.pagination') }}
        </div>
    </div>
</div>

@include('layouts.components.hapus', ['nama_hapus' => 'periode'])
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '#delete', function(){
            let id = [];
            if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
                $(".periode-checkbox:checked").each(function () {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url     : "{{ route('periode.destroys') }}",
                        method  : 'delete',
                        data    : {
                            _token  : "{{ csrf_token() }}",
                            id      : id,
                        },
                        success : function(data){
                            alertSuccess(data.message);
                            location.reload();
                        }
                    });
                } else {
                    alertFail('Harap pilih salah satu periode');
                }
            }
        });

        $("#check_all").click(function(){
            if (this.checked) {
                $(".periode-checkbox").prop('checked',true);
            } else {
                $(".periode-checkbox").prop('checked',false);
            }
        });
    });
</script>
@endpush
