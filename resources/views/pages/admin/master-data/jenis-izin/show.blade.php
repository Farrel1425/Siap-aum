@extends('layouts.dashboard.dashborad-base')


@section('content')
    <div class="page-heading">
        <div class="page-title mb-3">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last d-flex align-items-center">
                    <h3 class="d-inline mb-0">
                        <a class="text-color-heading fs-4"
                           href="{{ route('admin.master-data.jenis-izin.index') }}">
                            <i class="isax-bold isax-arrow-circle-left"></i>
                        </a> Tambah Jenis Ijin
                    </h3>
                </div>
            </div>
        </div>
        <section class="section">
            <form action="{{ route('admin.master-data.jenis-izin.update', $jenis_izin->id) }}"
                  enctype="multipart/form-data"
                  method="POST">
                @method('PUT')
                @csrf
                <h5 class="text-black mb-3 mt-4">Tambah Jenis Perijinan</h5>
                <div class="card mb-3">
                    <div class="card-body p-4">
                        <x-dashboard.input-inline-text :required=True
                                                       class=""
                                                       id="nama"
                                                       label="Nama"
                                                       name="nama"
                                                       placeholder="Masukkan nama jenis ijin"
                                                       value="{{ old('nama', $jenis_izin->nama) }}" />
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body p-4">
                        <x-dashboard.input-inline-ckeditor :required=True
                                                           id="deskripsi"
                                                           label="Masukkan deskripsi syarat ijin"
                                                           name="deskripsi"
                                                           value="{{ old('deskripsi', $jenis_izin->deskripsi) }}" />
                    </div>
                </div>
                <hr>
                <h5 class="text-black mt-4">Syarat Form Detail Pemohon</h5>
                <x-dashboard.input-syarat-form />
                <hr>
                <h5 class="text-black mt-4">Syarat Upload Berkas Pemohon</h5>
                <x-dashboard.input-syarat-berkas />
                <hr>
                <h5 class="text-black mt-4">Alur Verifikator</h5>
                <x-dashboard.input-syarat-alur-verifikator />
                <hr>
                <h5 class="text-black mt-4">Kelengkapan Laporan</h5>
                <div class="bg-warning w-100 d-block p-2 text-center text-white text-xsm rounded">
                    <span class="isax isax-warning-2 me-2"></span>Kelengkapan ijin adalah isian pendukung pada surat ijin
                    yang
                    akan dikirim ke
                    pihak pemohon. Yang akan dilengkapi oleh petugas <span class="fw-bold">Verifikator + Kelengkapan</span>
                </div>
                <x-dashboard.input-syarat-kelengkapan />
                <hr>
                <h5 class="text-black mt-4">Template Laporan</h5>
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-9">
                            <input class="form-control"
                                   id="template_laporan"
                                   name="template_laporan"
                                   type="file">
                        </div>
                        <div class="col-3">
                            <a class="btn btn-secondary w-100 d-block text-sm"
                               href="{{ Storage::url($jenis_izin->template_surat) }}"
                               target="_blank">Lihat Template</a>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary w-100 d-block fw-bold"
                        type="submit">Simpan Jenis Ijin</button>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            @if ($old_values = old('syarat_berkas', $jenis_izin->berkasJenisIzin))
                @foreach ($old_values as $key => $value)
                    tambahDataBerkas('{{ $value['nama'] }}', '{{ $value['is_required'] }}');
                @endforeach
            @endif

            @if ($old_values = old('syarat_form', $jenis_izin->formJenisIzin))
                @foreach ($old_values as $key => $value)
                    tambahDataForm('{{ $value['nama'] }}', '{{ $value['kode_isian'] }}',
                        '{{ $value['tipe_form'] }}');
                @endforeach
            @endif

            @if ($old_values = old('alur_verifikator', $jenis_izin->alurJenisIzin))
                @foreach ($old_values as $key => $value)
                    tambahAlurVerifikator('{{ $value['nama'] }}', '{{ $value['id'] }}',
                        '{{ $value['jenis_verifikator'] }}');
                @endforeach
            @endif

            @if ($old_values = old('syarat_kelengkapan', $jenis_izin->kelengkapanJenisIzin))
                @foreach ($old_values as $key => $value)
                    tambahDataKelengkapan('{{ $value['nama'] }}', '{{ $value['kode_isian'] }}',
                        '{{ $value['tipe_form'] }}');
                @endforeach
            @endif
        });
    </script>
@endpush
