@extends('layouts.app')

@section('title', 'Penduduk')

@section('styles')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
@endsection

@section('content-header')
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url({{ asset('/img/cover-bg.jpg') }}); background-size: cover; background-position: center top;">
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <div class="card shadow h-100">
                    <div class="card-header border-0">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between text-center text-md-left">
                            <div class="mb-3">
                                <h2 class="mb-0">Penduduk</h2>
                                <p class="mb-0 text-sm">Kelola Penduduk</p>
                            </div>
                            <div class="mb-3">
                                <button type="button" data-toggle="tooltip" title="Hapus data terpilih" class="mb-1 btn btn-danger" id="delete" name="delete" >
                                    <i class="fas fa-trash"></i>
                                </button>
                                <a target="_blank" href="{{ route('penduduk.print_all') }}" data-toggle="tooltip" class="mb-1 btn btn-secondary" title="Cetak"><i class="fas fa-print"></i></a>
                                <a href="{{ route('penduduk.create') }}?page={{ request('page') }}" data-toggle="tooltip" class="mb-1 btn btn-success" title="Tambah Penduduk"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats shadow h-100">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Kepala Keluarga</h5>
                                <span class="h2 font-weight-bold mb-0">{{ App\Penduduk::whereHas('statusHubunganDalamKeluarga', function ($status) {$status->where('nama', 'Kepala Keluarga');})->count() }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats shadow h-100">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Penduduk</h5>
                                <span class="h2 font-weight-bold mb-0">{{ App\Penduduk::count() }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats shadow h-100">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Laki-laki</h5>
                                <span class="h2 font-weight-bold mb-0">{{ App\Penduduk::where('jenis_kelamin',1)->count() }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
                <div class="card card-stats shadow h-100">
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Perempuan</h5>
                                <span class="h2 font-weight-bold mb-0">{{ App\Penduduk::where('jenis_kelamin',2)->count() }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-gradient-pink text-white rounded-circle shadow">
                                    <i class="fas fa-user"></i>
                                </div>
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
            <input class="form-control" placeholder="Cari ...." type="serach" name="cari" value="{{ request('cari') }}">
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
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm table-striped table-bordered">
                <thead>
                    <th class="text-center">
                        <input type="checkbox" name="check_all" id="check_all">
                    </th>
                    <th class="text-center">No</th>
                    <th class="text-center">Opsi</th>
                    <th class="text-center">NIK</th>
                    <th class="text-center">KK</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jenis Kelamin</th>
                    <th class="text-center">TTL</th>
                    <th class="text-center">Golongan Darah</th>
                    <th class="text-center">Agama</th>
                    <th class="text-center">Pendidikan</th>
                    <th class="text-center">Pekerjaan</th>
                    <th class="text-center">Status Perkawinan</th>
                    <th class="text-center">Status Hub. dalam Keluarga</th>
                    <th class="text-center">Kewarganegaraan</th>
                    <th class="text-center">Nama Ayah</th>
                    <th class="text-center">Nama Ibu</th>
                </thead>
                <tbody>
                    @forelse ($penduduk as $item)
                        <tr>
                            <td style="vertical-align: middle">
                                <input type="checkbox" class="penduduk-checkbox" id="delete{{ $item->id }}" name="delete[]" value="{{ $item->id }}">
                            </td>
                            <td style="vertical-align: middle" class="text-center">{{ ($penduduk->currentpage()-1) * $penduduk->perpage() + $loop->index + 1 }}</td>
                            <td style="vertical-align: middle">
                                <a href="{{ route('penduduk.show', $item->nik) }}?page={{ request('page') }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('penduduk.edit', $item) }}?page={{ request('page') }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-sm btn-danger hapus-data" data-nama="{{ $item->nama }}" data-action="{{ route("penduduk.destroy", $item) }}" data-toggle="tooltip" title="Hapus" href="#modal-hapus"><i class="fas fa-trash"></i></a>
                            </td>
                            <td style="vertical-align: middle"><a href="{{ route('penduduk.show', $item->nik) }}">{{ $item->nik }}</a></td>
                            <td style="vertical-align: middle"><a href="{{ route('penduduk.keluarga.show', $item->kk) }}">{{ $item->kk }}</a></td>
                            <td style="vertical-align: middle">{{ $item->nama }}</td>
                            <td style="vertical-align: middle">{{ $item->jenis_kelamin == 1 ? "Laki-laki" : "Perempuan" }}</td>
                            <td style="vertical-align: middle">{{ $item->tempat_lahir }}, {{ date('d/m/Y',strtotime($item->tanggal_lahir)) }}</td>
                            <td style="vertical-align: middle">{{ $item->darah->golongan ?? '-' }}</td>
                            <td style="vertical-align: middle">{{ $item->agama->nama ?? '-' }}</td>
                            <td style="vertical-align: middle">{{ $item->pendidikan->nama ?? '-' }}</td>
                            <td style="vertical-align: middle">{{ $item->pekerjaan->nama ?? '-' }}</td>
                            <td style="vertical-align: middle">{{ $item->statusPerkawinan->nama ?? '-' }}</td>
                            <td style="vertical-align: middle">{{ $item->statusHubunganDalamKeluarga->nama ?? '-' }}</td>
                            <td style="vertical-align: middle">
                                @php
                                    switch ($item->kewarganegaraan) {
                                        case 1:
                                            echo "WNI";
                                            break;
                                        case 2:
                                            echo "WNA";
                                            break;
                                        case 3:
                                            echo "Dua Kewarganegaraan";
                                            break;
                                    }
                                @endphp
                            </td>
                            <td style="vertical-align: middle">{{ $item->nama_ayah ? $item->nama_ayah : '-' }}</td>
                            <td style="vertical-align: middle">{{ $item->nama_ibu ? $item->nama_ibu : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="17" align="center">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $penduduk->links('layouts.components.pagination') }}
        </div>
    </div>
</div>

@include('layouts.components.hapus', ['nama_hapus' => 'penduduk'])
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $(document).on('click', '#delete', function(){
            let id = [];
            if (confirm("Apakah anda yakin ingin menghapus data ini?")) {
                $(".penduduk-checkbox:checked").each(function () {
                    id.push($(this).val());
                });
                if (id.length > 0) {
                    $.ajax({
                        url     : "{{ route('penduduk.destroys') }}",
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
                    alertFail('Harap pilih salah satu penduduk');
                }
            }
        });

        $("#check_all").click(function(){
            if (this.checked) {
                $(".penduduk-checkbox").prop('checked',true);
            } else {
                $(".penduduk-checkbox").prop('checked',false);
            }
        });
    });
</script>
@endpush
