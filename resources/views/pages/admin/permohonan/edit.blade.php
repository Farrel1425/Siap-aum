@extends('layouts.dashboard.dashboard-base')


@section('content')
    <div class="page-heading">
        <div class="page-title mb-3">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last d-flex align-items-center">
                    <h3 class="d-inline mb-0">
                        <a class="text-color-heading fs-4"
                           href="{{ route('admin.permohonan.index') }}">
                            <i class="isax-bold isax-arrow-circle-left"></i>
                        </a> Edit Permohonan Ijin
                    </h3>
                </div>
            </div>
        </div>
        <section class="section">
            <x-landing.progress-stepper-bar :steps=$steps />
            <x-log-aktivitas-table :permohonan=$permohonan />
            <h5>Data Diri Pemohon</h5>
            <form action="{{ route('admin.permohonan.update', $permohonan->id) }}",
                  method="POST">
                @csrf
                @method('PUT')
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="No Registrasi"
                                               name="nomor_registrasi"
                                               readonly
                                               value="{{ $permohonan->nomor_registrasi }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="Status"
                                               name="status"
                                               readonly
                                               value="{{ $permohonan->status_name }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="Jenis Perijinan"
                                               name="jenis_izin"
                                               readonly
                                               value="{{ $permohonan->jenisIzin->nama }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border text-xsm"
                                               label="Nama"
                                               name="nama"
                                               value="{{ $permohonan->nama }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border text-xsm"
                                               label="NIK"
                                               name="nik"
                                               value="{{ $permohonan->nik }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border text-xsm"
                                               label="NPWP"
                                               name="npwp"
                                               value="{{ $permohonan->npwp }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border text-xsm"
                                               label="Tempat Lahir"
                                               name="tempat_lahir"
                                               value="{{ $permohonan->tempat_lahir }}" />
                <h5 class="mt-4">Data Detail Permohonan</h5>
                @foreach ($permohonan->formPermohonan as $form_permohonan)
                    <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                   class_input="text-xsm"
                                                   label="{{ $form_permohonan->label }}"
                                                   name="{{ $form_permohonan->kode_isian }}"
                                                   placeholder="Masukkan {{ $form_permohonan->label }}"
                                                   required
                                                   type="{{ $form_permohonan->tipe }}"
                                                   value="{{ old($form_permohonan->kode_isian, $form_permohonan->value) }}" />
                @endforeach
                <h5 class="mt-4">Data Kelengkapan Verifikator</h5>
                @foreach ($permohonan->kelengkapanPermohonan as $kelengkapan_permohonan)
                    <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                   class_input="text-xsm"
                                                   label="{{ $kelengkapan_permohonan->label }}"
                                                   name="{{ $kelengkapan_permohonan->kode_isian }}"
                                                   placeholder="Masukkan {{ $kelengkapan_permohonan->label }}"
                                                   required
                                                   type="{{ $kelengkapan_permohonan->tipe }}"
                                                   value="{{ old($kelengkapan_permohonan->kode_isian, $kelengkapan_permohonan->value) }}" />
                @endforeach
                <div class="mt-4 mb-4">
                    <button class="d-block btn w-100 btn-primary">
                        <i class="isax isax-tick-circle me-2"></i> Simpan
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
