@extends('layouts.app')

@section('title', 'Artikel')

@section('styles')
<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
<style>
    .animate-up:hover {
        top: -5px;
    }
</style>
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
                                <h2 class="mb-0">Artikel</h2>
                                <p class="mb-0 text-sm">Kelola Artikel</p>
                            </div>
                            <div class="mb-3">
                                <a href="{{ route('artikel.create') }}?page={{ request('page') }}" class="btn btn-success" title="Tambah"><i class="fas fa-plus"></i> Tambah Artikel</a>
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
<div class="row mt-4 justify-content-center">
    @forelse ($artikel as $item)
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card animate-up shadow">
                <a href="{{ url('') }}{{ $item->menu ? '/' . Str::slug($item->menu) : '' }}{{ $item->submenu ? '/' . Str::slug($item->submenu) : '' }}{{ $item->sub_submenu ? '/' . Str::slug($item->sub_submenu) : '' }}{{ '/' . $item->id . '/' . Str::slug($item->judul) }}">
                    <div class="card-img" style="background-image: url('{{ $item->gambar ? url(Storage::url($item->gambar)) : url(Storage::url('noimage.jpg')) }}'); background-size: cover; height: 200px;"></div>
                </a>
                <div class="card-body text-center">
                    <a href="{{ url('') }}{{ $item->menu ? '/' . Str::slug($item->menu) : '' }}{{ $item->submenu ? '/' . Str::slug($item->submenu) : '' }}{{ $item->sub_submenu ? '/' . Str::slug($item->sub_submenu) : '' }}{{ '/' . $item->id . '/' . Str::slug($item->judul) }}">
                        <h3>{{ $item->judul }}</h3>
                        <p class="text-sm text-muted">{{ $item->menu ? $item->menu : '' }}{{ $item->submenu ? ', '. $item->submenu : '' }}{{ $item->sub_submenu ? ', '. $item->sub_submenu : '' }}</p>
                        <div class="mt-3 d-flex justify-content-between text-sm text-muted">
                            <i class="fas fa-clock"> {{ $item->created_at->diffForHumans() }}</i>
                            <i class="fas fa-eye"> {{ $item->dilihat }} Kali Dibaca</i>
                        </div>
                    </a>
                    <div class="mt-3">
                        @if ($item->slide == 1)
                            <a href="#slide" class="btn btn-sm btn-info slide" data-toggle="tooltip" title="Keluarkan Dari Slide"><i class="fas fa-pause"></i></a>
                        @else
                            <a href="#slide" class="btn btn-sm btn-info slide" data-toggle="tooltip" title="Masukkan Ke Dalam Slide"><i class="fas fa-play"></i></a>
                        @endif
                        <a href="{{ route('artikel.edit', $item) }}?page={{ request('page') }}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Edit"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger hapus-data" data-nama="{{ $item->judul }}" data-action="{{ route('artikel.destroy',$item) }}" data-toggle="tooltip" href="#modal-hapus" title="Hapus"><i class="fas fa-trash"></i></a>
                        <form action="{{ route('artikel.slide', $item) }}" method="post">@csrf</form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col">
            <div class="single-service bg-white rounded shadow">
                <h4>Data belum tersedia</h4>
            </div>
        </div>
    @endforelse

    <div class="col-12">
        {{ $artikel->links('layouts.components.pagination') }}
    </div>
</div>

@include('layouts.components.hapus', ['nama_hapus' => 'artikel'])
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $(".hapus-data").click(function (){
            $("#modal-hapus").show();
        });

        $(".slide").click(function (event) {
            event.preventDefault();
            $(this).siblings('form').submit();
        });
    });
</script>
@endpush
