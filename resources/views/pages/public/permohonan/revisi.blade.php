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
                        </a> Detail Permohonan Ijin
                    </h3>
                </div>
            </div>
        </div>
        <section class="section mb-3">
            <x-landing.progress-stepper-bar :steps=$steps />
            <h5>Data Diri Pemohon</h5>
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
                                           class_input="border-0 text-end text-xsm"
                                           label="Nomor Telepon"
                                           name="telepon"
                                           readonly
                                           value="{{ $permohonan->user->telepon }}" />
            <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                           class_input="border-0 text-end text-xsm"
                                           label="Memohon Untuk"
                                           name="memohon_untuk"
                                           readonly
                                           value="{{ $permohonan->memohon_untuk }}" />
            <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                           class_input="border-0 text-end text-xsm"
                                           label="Nama"
                                           name="nama"
                                           readonly
                                           value="{{ $permohonan->nama }}" />
            <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                           class_input="border-0 text-end text-xsm"
                                           label="NIK"
                                           name="nik"
                                           readonly
                                           value="{{ $permohonan->nik }}" />
            <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                           class_input="border-0 text-end text-xsm"
                                           label="NPWP"
                                           name="npwp"
                                           readonly
                                           value="{{ $permohonan->npwp }}" />
            <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                           class_input="border-0 text-end text-xsm"
                                           label="Tempat Lahir"
                                           name="tempat_lahir"
                                           readonly
                                           value="{{ $permohonan->tempat_lahir }}" />
            <h5 class="mt-4">Data Detail Permohonan</h5>
            @foreach ($permohonan->formPermohonan as $form_permohonan)
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="{{ $form_permohonan->label }}"
                                               name="{{ $form_permohonan->kode_isian }}"
                                               readonly
                                               value="{{ $form_permohonan->value ?? '-' }}" />
            @endforeach
            <h5 class="mt-4">Data Berkas Permohonan</h5>
            @foreach ($permohonan->berkasPermohonan as $berkas_permohonan)
                @if ($berkas_permohonan->is_revisi)
                    <x-dashboard.input-inline-file-upload :required="$berkas_permohonan->is_required"
                                                          :upload_revisi="$berkas_permohonan->validasiBerkas
                                                              ->where('status', 'revisi')
                                                              ->count() == 0"
                                                          class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                          class_input="text-xsm"
                                                          downloadUrl="{{ $berkas_permohonan->filepath ? Storage::url($berkas_permohonan->filepath) : '' }}"
                                                          label="{{ $berkas_permohonan->nama }}"
                                                          name="{{ $berkas_permohonan->id }}"
                                                          revisi="{{ $berkas_permohonan->catatan }}"
                                                          uploadUrl="{{ route('public.permohonan.store-berkas', $permohonan->id) }}" />
                @else
                    <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                          :required="$berkas_permohonan->is_required"
                                                          class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                          class_input="text-xsm"
                                                          downloadUrl="{{ $berkas_permohonan->filepath ? Storage::url($berkas_permohonan->filepath) : '' }}"
                                                          label="{{ $berkas_permohonan->nama }}"
                                                          name="{{ $berkas_permohonan->id }}"
                                                          uploadUrl="{{ route('public.permohonan.store-berkas', $permohonan->id) }}" />
                @endif
            @endforeach
            {{-- <h5 class="mt-4">Data Kelengkapan Verifikator</h5>
            @foreach ($permohonan->kelengkapanPermohonan as $kelengkapan_permohonan)
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="{{ $kelengkapan_permohonan->label }}"
                                               name="{{ $kelengkapan_permohonan->kode_isian }}"
                                               readonly
                                               value="{{ $kelengkapan_permohonan->value ?? '-' }}" />
            @endforeach --}}
            <form action="{{ route('public.permohonan.revisi', $permohonan->id) }}"
                  method="POST">
                @csrf
                <button class="btn btn-primary bg-primary mt-4 w-100 d-block"
                        type="submit">Simpan dan Lanjutkan Permohonan</button>
            </form>
        </section>
    </div>
@endsection
