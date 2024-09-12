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
        <section class="section">
            <form action="{{ route('verifikator.verifikasi.verifikasi', $permohonan->id) }}"
                  method="POST">
                @csrf
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
                @foreach ($berkas_permohonans as $berkas_permohonan)
                    <div class="form-group mb-3 mx-1 p-3 bg-white text-xsm">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <label class="text-primary col-form-label fw-bold text-xsm"
                                       for="{{ $berkas_permohonan->kode_berkas }}">{{ $berkas_permohonan->nama }}
                                    @if ($berkas_permohonan->is_required)
                                        <span class="badge bg-primary fw-normal"><i class="isax isax-warning-2"></i>
                                            Required</span>
                                    @else
                                        <span class="badge bg-secondary fw-normal"><i class="isax isax-warning-2"></i>
                                            Optional</span>
                                    @endif
                                    @if ($berkas_permohonan->is_revisi)
                                        <span class="badge bg-danger fw-normal"><i class="isax isax-warning-2"></i>
                                            Revisi</span>
                                    @elseif (!$berkas_permohonan->is_need_validation)
                                        <span class="badge bg-success fw-normal"><i class="isax isax-tick-circle"></i>
                                            Valid</span>
                                    @else
                                        <span class="badge bg-warning fw-normal"><i class="isax isax-tick-circle"></i>
                                            Pending</span>
                                    @endif
                                </label>
                            </div>
                            <div class="col-2"></div>
                            @if ($berkas_permohonan->is_need_validation)
                                <div class="col-2">
                                    <button class="btn btn-sm btn-success d-block w-100"
                                            data-detail-id="{{ encrypt($berkas_permohonan->id) }}"
                                            data-nama="{{ $berkas_permohonan->nama }}"
                                            data-url="{{ $berkas_permohonan->filepath }}"
                                            onclick="validasiBerkas(this)"
                                            type="button">
                                        Verifikasi</button>
                                </div>
                            @else
                                <div class="col-2"></div>
                            @endif
                            <div class="col-2">
                                @if ($berkas_permohonan->filepath)
                                    <a class="btn btn-outline-primary text-xsm d-block w-100"
                                       href="{{ Storage::url($berkas_permohonan->filepath) }}"
                                       target="_blank">
                                        <i class="isax isax-download"></i> Lihat File
                                    </a>
                                @else
                                    <span class="badge bg-warning">Belum diunggah</span>
                                @endif
                            </div>
                        </div>
                        @if ($berkas_permohonan->is_revisi)
                            <span class="badge bg-danger w-100 d-block mt-2 fw-normal text-xsm">Revisi terakhir:
                                {{ $berkas_permohonan->catatan }}</span>
                        @endif
                    </div>
                @endforeach
                <h5 class="mt-4">Data Kelengkapan Verifikator</h5>
                @foreach ($permohonan->kelengkapanPermohonan as $kelengkapan_permohonan)
                    @if (
                        $alur_permohonan->jenis_verifikator == App\Enums\JenisVerifikatorEnum::BO->value &&
                            $permohonan->status != App\Enums\StatusPermohonanEnum::SELESAI->value &&
                            $is_all_berkas_valid && $is_verifikator_turn)
                        <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                       class_input="text-xsm"
                                                       label="{{ $kelengkapan_permohonan->label }}"
                                                       name="{{ $kelengkapan_permohonan->kode_isian }}"
                                                       placeholder="Masukkan {{ $kelengkapan_permohonan->label }}"
                                                       value="{{ old($kelengkapan_permohonan->kode_isian, $kelengkapan_permohonan->value) }}" />
                    @else
                        <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                       class_input="border-0 text-end text-xsm"
                                                       label="{{ $kelengkapan_permohonan->label }}"
                                                       name="{{ $kelengkapan_permohonan->kode_isian }}"
                                                       readonly
                                                       value="{{ $kelengkapan_permohonan->value ?? '-' }}" />
                    @endif
                @endforeach
                <h5 class="mt-4">Data Berkas Verifikator</h5>
                @if (
                    $alur_permohonan->jenis_verifikator == App\Enums\JenisVerifikatorEnum::FO->value &&
                        $permohonan->status != App\Enums\StatusPermohonanEnum::SELESAI->value)
                    <x-dashboard.input-inline-file-upload :is_readonly="false"
                                                          :is_show_badge="false"
                                                          class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                          class_input="text-xsm"
                                                          downloadUrl="{{ $permohonan->surat_permohonan_rekomendasi_filepath ? Storage::url($permohonan->surat_permohonan_rekomendasi_filepath) : '' }}"
                                                          label="Surat Permohonan Rekomendasi"
                                                          name="surat_permohonan_rekomendasi"
                                                          uploadUrl="{{ route('verifikator.verifikasi.upload-surat-permohonan-rekomendasi', $permohonan->id) }}" />
                @else
                    <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                          :is_show_badge="false"
                                                          class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                          class_input="text-xsm"
                                                          downloadUrl="{{ $permohonan->surat_permohonan_rekomendasi_filepath ? Storage::url($permohonan->surat_permohonan_rekomendasi_filepath) : '' }}"
                                                          label="Surat Permohonan Rekomendasi"
                                                          name="surat_permohonan_rekomendasi" />
                    @if (
                        $alur_permohonan->jenis_verifikator == App\Enums\JenisVerifikatorEnum::OPD->value &&
                            $permohonan->status != App\Enums\StatusPermohonanEnum::SELESAI->value)
                        <x-dashboard.input-inline-file-upload :is_show_badge="false"
                                                              class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                              class_input="text-xsm"
                                                              downloadUrl="{{ $permohonan->surat_rekomendasi_filepath ? Storage::url($permohonan->surat_rekomendasi_filepath) : '' }}"
                                                              label="Surat Rekomendasi"
                                                              name="surat_rekomendasi"
                                                              uploadUrl="{{ route('verifikator.verifikasi.upload-surat-rekomendasi', $permohonan->id) }}" />
                    @else
                        <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                              :is_show_badge="false"
                                                              class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                              class_input="text-xsm"
                                                              downloadUrl="{{ $permohonan->surat_rekomendasi_filepath ? Storage::url($permohonan->surat_rekomendasi_filepath) : '' }}"
                                                              label="Surat Rekomendasi"
                                                              name="surat_rekomendasi" />
                        <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                              :is_show_badge="false"
                                                              class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                              class_input="text-xsm"
                                                              downloadUrl="{{ $permohonan->template_surat_filepath ? Storage::url($permohonan->template_surat_filepath) : '' }}"
                                                              label="Ijin Terbit"
                                                              name="ijin_terbit" />
                    @endif
                @endif

                @if ($is_verifikator_turn && $is_can_verified)
                    <div class="mt-4">

                        <button class="d-block btn w-100 btn-primary">
                            <i class="isax isax-tick-circle me-2"></i> Simpan
                        </button>
                    </div>
                @endif
            </form>

            @if ($is_verifikator_approvable_berkas)
                @include('components.dashboard.modal-validasi')
            @endif
        </section>
    </div>
@endsection
