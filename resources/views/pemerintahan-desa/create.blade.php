@extends('layouts.app')

@section('title', 'Tambah Aparat Pemerintahan Desa')

@section('styles')
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<style>
    .upload-image:hover{
        cursor: pointer;
        opacity: 0.7;
    }
</style>
@endsection

@section('content-header')
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card shadow h-100">
                    <div class="card-header border-0">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-between text-center text-md-left">
                            <div class="mb-3">
                                <h2 class="mb-0">Tambah Aparat Pemerintahan Desa</h2>
                                <p class="mb-0 text-sm">Kelola Pemerintahan Desa</p>
                            </div>
                            <div class="mb-3">
                                <a href="{{ request('atasan') ? route("pemerintahan-desa.show", request('atasan')) : route("pemerintahan-desa.index") }}?page={{ request('page') }}" class="btn btn-success" title="Kembali"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('layouts.components.alert')
<div class="row">
    <div class="col">
        <div class="card bg-secondary shadow h-100">
            <div class="card-body">
                <form autocomplete="off" action="{{ route('pemerintahan-desa.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group text-center">
                                <label class="form-control-label" for="foto">Foto</label> <br>
                                <img onclick="$(this).siblings('.images').click()" class="mw-100 upload-image" style="max-height: 300px" src="{{ asset('storage/upload.jpg') }}" alt="">
                                <input accept="image/*" onchange="uploadImage(this)" type="file" name="foto" id="foto" class="images" style="display: none">
                                <input type="hidden" name="gambar">
                                @error('foto')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-6">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="form-control-label" for="penduduk_id">Cari dari data penduduk</label> <img style="display: none" id="loading" height="20px" src="{{ asset('storage/loading.gif') }}" alt="Loading">
                                    <select class="form-control @error('penduduk_id') is-invalid @enderror" name="penduduk_id" id="penduduk_id">
                                        <option selected value="">Pilih NIK - Nama</option>
                                        @foreach ($penduduk as $item)
                                            <option value="{{ $item->id }}" {{ old('penduduk_id') == $item->id ? 'selected="true"' : ''  }}>NIK : {{ $item->nik }} - {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('penduduk_id')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-lg-2 col-md-6">
                                    <label class="form-control-label" for="urutan">Urutan</label>
                                    <input type="number" onkeypress="return hanyaAngka(event)" class="form-control @error('urutan') is-invalid @enderror" name="urutan" id="urutan" placeholder="Masukkan Urutan ..." value="{{ old('urutan', request('atasan') ? (App\PemerintahanDesa::where('atasan',request('atasan'))->select('urutan')->orderBy('urutan','desc')->first() ? App\PemerintahanDesa::where('atasan',request('atasan'))->select('urutan')->orderBy('urutan','desc')->first()->urutan + 1 : 1) : (App\PemerintahanDesa::select('urutan')->orderBy('urutan','desc')->first() ? App\PemerintahanDesa::select('urutan')->orderBy('urutan','desc')->first()->urutan + 1 : 1)) }}">
                                    @error('urutan')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-lg-5 col-md-6">
                                    <label class="form-control-label" for="nik">NIK</label>
                                    <input type="text" onkeypress="return hanyaAngka(event)" class="form-control @error('nik') is-invalid @enderror" name="nik" id="nik" placeholder="Masukkan NIK ..." value="{{ old('nik') }}">
                                    @error('nik')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group col-lg-5 col-md-12">
                                    <label class="form-control-label" for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Masukkan Nama ..." value="{{ old('nama') }}">
                                    @error('nama')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-4 col-md-6">
                            <label class="form-control-label" for="nrpd">NRPD</label>
                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control @error('nrpd') is-invalid @enderror" name="nrpd" placeholder="Masukkan NRPD ..." value="{{ old('nrpd') }}">
                            @error('nrpd')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-control-label" for="status_pegawai_desa">Status Pegawai Desa</label>
                            <select class="form-control @error('status_pegawai_desa') is-invalid @enderror" name="status_pegawai_desa" id="status_pegawai_desa">
                                <option selected value="">Pilih Status Pegawai Desa</option>
                                <option value="1" {{ old('status_pegawai_desa') == 1 ? 'selected="true"' : ''  }}>Aktif</option>
                                <option value="2" {{ old('status_pegawai_desa') == 2 ? 'selected="true"' : ''  }}>Tidak Aktif</option>
                            </select>
                            @error('status_pegawai_desa')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-lg-4 col-md-6">
                            <label class="form-control-label" for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" name="tempat_lahir" id="tempat_lahir" placeholder="Masukkan Tempat Lahir ..." value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-lg-4 col-md-6">
                            <label class="form-control-label" for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" name="tanggal_lahir" id="tanggal_lahir" placeholder="Masukkan Tanggal Lahir ..." value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-control-label" for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin">
                                <option selected value="">Pilih Jenis Kelamin</option>
                                <option value="1" {{ old('jenis_kelamin') == 1 ? 'selected="true"' : ''  }}>Laki-laki</option>
                                <option value="2" {{ old('jenis_kelamin') == 2 ? 'selected="true"' : ''  }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-lg-4">
                            <label class="form-control-label" for="pendidikan_id">Pendidikan</label>
                            <select class="form-control @error('pendidikan_id') is-invalid @enderror" name="pendidikan_id" id="pendidikan_id">
                                <option selected value="">Pilih Pendidikan</option>
                                @foreach ($pendidikan as $item)
                                    <option value="{{ $item->id }}" {{ old('pendidikan_id') == $item->id ? 'selected="true"' : ''  }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('pendidikan_id')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-lg-6 col-md-6">
                            <label class="form-control-label" for="agama_id">Agama</label>
                            <select class="form-control @error('agama_id') is-invalid @enderror" name="agama_id" id="agama_id">
                                <option selected value="">Pilih Agama</option>
                                @foreach ($agama as $item)
                                    <option value="{{ $item->id }}" {{ old('agama_id') == $item->id ? 'selected="true"' : ''  }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('agama_id')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="pangkat_atau_golongan">Pangkat/Golongan</label>
                            <input type="text" class="form-control @error('pangkat_atau_golongan') is-invalid @enderror" name="pangkat_atau_golongan" id="pangkat_atau_golongan" placeholder="Masukkan Pangkat/Golongan ..." value="{{ old('pangkat_atau_golongan') }}">
                            @error('pangkat_atau_golongan')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="jabatan">Jabatan</label>
                            <input type="text" class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" id="jabatan" placeholder="Masukkan Jabatan ..." value="{{ old('jabatan') }}">
                            @error('jabatan')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="atasan">Atasan</label>
                            <select class="form-control @error('atasan') is-invalid @enderror" name="atasan" id="atasan">
                                <option selected value="">Pilih Atasan</option>
                                @foreach (App\PemerintahanDesa::where('atasan',null)->orderBy('urutan')->get() as $item)
                                    <option value="{{ $item->id }}" {{ old('atasan', request('atasan')) == $item->id ? 'selected="true"' : ''  }}>{{ $item->nama }} - {{ $item->jabatan }}</option>
                                @endforeach
                            </select>
                            @error('atasan')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="masa_jabatan">Masa Jabatan</label>
                            <input type="text" class="form-control @error('masa_jabatan') is-invalid @enderror" name="masa_jabatan" id="masa_jabatan" placeholder="Ex: 6 Tahun Periode Pertama (2019-2025)" value="{{ old('masa_jabatan') }}">
                            @error('masa_jabatan')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="nomor_sk_pengangkatan">Nomor SK Pengangkatan </label>
                            <input type="text" class="form-control @error('nomor_sk_pengangkatan') is-invalid @enderror" name="nomor_sk_pengangkatan" id="nomor_sk_pengangkatan" placeholder="Masukkan Nomor SK Pengangkatan  ..." value="{{ old('nomor_sk_pengangkatan') }}">
                            @error('nomor_sk_pengangkatan')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="tanggal_sk_pengangkatan">Tanggal SK Pengangkatan</label>
                            <input type="date" class="form-control @error('tanggal_sk_pengangkatan') is-invalid @enderror" name="tanggal_sk_pengangkatan" id="tanggal_sk_pengangkatan" placeholder="Masukkan Tanggal SK Pengangkatan ..." value="{{ old('tanggal_sk_pengangkatan') }}">
                            @error('tanggal_sk_pengangkatan')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-control-label" for="alamat">Alamat</label>
                            <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" id="alamat" placeholder="Masukkan Alamat  ..." value="{{ old('alamat') }}">
                            @error('alamat')<span class="invalid-feedback font-weight-bold">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" id="simpan">SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#penduduk_id').select2({
            placeholder: "Pilih Penduduk",
            allowClear: true
        });

        $("#penduduk_id").change(function () {
            $("#loading").css('display','block');
            $.getJSON("{{ url('/detail-penduduk') }}/" + $(this).val(), function (response) {
                $("#nama").val(response.data.nama);
                $("#nik").val(response.data.nik);
                $("#tempat_lahir").val(response.data.tempat_lahir);
                $("#tanggal_lahir").val(response.data.tanggal_lahir);
                $("#jenis_kelamin").val(response.data.jenis_kelamin);
                $("#pendidikan_id").val(response.data.pendidikan_id);
                $("#agama_id").val(response.data.agama_id);
                $("#alamat").val(response.data.alamat_sekarang);
                let path = response.data.foto;
                if (path) {
                    path = path.replace('public','/storage');
                    $('#foto').siblings('img').attr('src', "{{ url('/') }}" + path);
                    $('input[name="gambar"]').val(response.data.foto);
                }
            });
            $("#loading").css('display','none');
        });
    });
</script>
@endpush
