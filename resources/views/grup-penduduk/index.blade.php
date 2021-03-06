@extends('layouts.app')

@section('title', 'Grup ' . $grup->nama_program)

@section('styles')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
@endsection

@section('content-header')
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="background-image: url({{ asset('/img/cover-bg.jpg') }}); background-size: cover; background-position: center top;">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card shadow h-100">
                    <div class="card-header border-0">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between text-center text-md-left">
                            <div class="mb-3">
                                <h2 class="mb-0">Grup {{ $grup->nama_program }}</h2>
                                <p class="mb-0 text-sm">Kelola Grup</p>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('grup-penduduk.print', $grup) }}" class="btn btn-secondary" title="Print" data-toggle="tooltip"><i class="fas fa-print"></i></a>
                                <a href="{{ route('grup-penduduk.create', $grup) }}?page={{ request('page') }}" class="btn btn-primary" title="Tambah" data-toggle="tooltip"><i class="fas fa-plus"></i></a>
                                <a href="{{ route('grup.index') }}" class="btn btn-success" title="Kembali" data-toggle="tooltip"><i class="fas fa-arrow-left"></i></a>
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
        <input type="search" name="cari" class="form-control form-control-rounded form-control-prepended" placeholder="cari" aria-label="cari" value="{{ request('cari') }}">
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
@include('grup-penduduk.detail')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Opsi</th>
                        <th class="text-center">NIK</th>
                        <th class="text-center">No. KK</th>
                        <th class="text-center">Nama Penduduk</th>
                        <th class="text-center">Tempat Lahir</th>
                        <th class="text-center">Tanggal Lahir</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grup_penduduk as $item)
                        <tr>
                            <td style="vertical-align: middle" class="text-center">{{ ($grup_penduduk->currentpage()-1) * $grup_penduduk->perpage() + $loop->index + 1 }}</td>
                            <td>
                                <a href="{{ route('grup-penduduk.edit', $item) }}?page={{ request('page') }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                                <a class="btn btn-sm btn-danger hapus-data" data-nama="{{ $item->nama }}" data-action="{{ route("grup-penduduk.destroy", $item) }}" data-toggle="tooltip" title="Hapus" href="#modal-hapus"><i class="fas fa-trash"></i></a>
                            </td>
                            <td style="vertical-align: middle">{{ $item->penduduk->nik }}</td>
                            <td style="vertical-align: middle">{{ $item->penduduk->kk }}</td>
                            <td style="vertical-align: middle">{{ $item->penduduk->nama }}</td>
                            <td style="vertical-align: middle">{{ $item->penduduk->tempat_lahir }}</td>
                            <td style="vertical-align: middle">{{ tgl($item->penduduk->tanggal_lahir) }}</td>
                            <td style="vertical-align: middle">{{ $item->penduduk->jenis_kelamin == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td style="vertical-align: middle">{{ $item->penduduk->alamat_sekarang ? $item->penduduk->alamat_sekarang : $item->penduduk->alamat_sebelumnya }}</td>
                            <td style="vertical-align: middle">{{ $item->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="15" align="center">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $grup_penduduk->links('layouts.components.pagination') }}
        </div>
    </div>
</div>

@include('layouts.components.hapus', ['nama_hapus' => 'peserta grup'])
@endsection
