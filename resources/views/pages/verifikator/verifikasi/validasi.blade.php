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
        <section class="section mb-1">
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
                @if ($permohonan->surat_kuasa_filepath)
                    <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                          :is_show_badge="false"
                                                          class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                          class_input="text-xsm"
                                                          downloadUrl="{{ Storage::url($permohonan->surat_kuasa_filepath) }}"
                                                          label="Surat Kuasa"
                                                          name="surat_kuasa" />
                @endif
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
                            @if ($berkas_permohonan->is_need_validation && $is_verifikator_turn)
                                <div class="col-2">
                                    <button class="btn btn-sm btn-success d-block w-100"
                                            data-detail-id="{{ encrypt($berkas_permohonan->id) }}"
                                            data-nama="{{ $berkas_permohonan->nama }}"
                                            data-url="{{ Storage::url($berkas_permohonan->filepath) }}"
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
                <h5 class="mt-4">Data Berkas Verifikator</h5>
                @if (
                    $alur_permohonan->jenis_verifikator == App\Enums\JenisVerifikatorEnum::FO->value &&
                        $permohonan->status != App\Enums\StatusPermohonanEnum::SELESAI->value)
                    @if ($is_all_berkas_valid)
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
                    @endif
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
                        {{-- HANDLE REKLAME --}}
                        @if ($permohonan->jenis_izin_id == 9)
                            <x-dashboard.input-inline-file-upload :is_show_badge="false"
                                                                  class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                                  class_input="text-xsm"
                                                                  downloadUrl="{{ $permohonan->reklame?->skpd_filepath ? Storage::url($permohonan->reklame->skpd_filepath) : '' }}"
                                                                  label="SKPD"
                                                                  name="skpd"
                                                                  uploadUrl="{{ route('verifikator.verifikasi.upload-skpd', $permohonan->id) }}" />
                            @if ($permohonan->reklame?->skpd_filepath)
                                <x-dashboard.input-inline-file-upload :is_show_badge="false"
                                                                      class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                                      class_input="text-xsm"
                                                                      downloadUrl="{{ $permohonan->reklame?->bukti_bayar_filepath ? Storage::url($permohonan->reklame->bukti_bayar_filepath) : '' }}"
                                                                      label="Bukti Bayar SKPD (Opsional)"
                                                                      name="skpd"
                                                                      uploadUrl="{{ route('verifikator.verifikasi.upload-bukti-bayar-reklame', $permohonan->id) }}" />
                            @endif
                        @endif
                        {{-- HANDLE ALL PERMOHONAN --}}
                        @if ($permohonan->jenis_izin_id != 9)
                            @if ($is_all_berkas_valid)
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
                            @endif
                        @endif
                    @else
                        @if ($permohonan->jenis_izin_id != 9)
                            <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                                  :is_show_badge="false"
                                                                  class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                                  class_input="text-xsm"
                                                                  downloadUrl="{{ $permohonan->surat_rekomendasi_filepath ? Storage::url($permohonan->surat_rekomendasi_filepath) : '' }}"
                                                                  label="Surat Rekomendasi"
                                                                  name="surat_rekomendasi" />
                        @endif
                        @if ($permohonan->jenis_izin_id == 9)
                            <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                                  :is_show_badge="false"
                                                                  class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                                  class_input="text-xsm"
                                                                  downloadUrl="{{ $permohonan->reklame?->bukti_bayar_filepath ? Storage::url($permohonan->reklame->bukti_bayar_filepath) : '' }}"
                                                                  label="Bukti Bayar SKPD"
                                                                  name="bukti_bayar" />
                        @endif
                        @if (
                            $alur_permohonan->jenis_verifikator == App\Enums\JenisVerifikatorEnum::BO->value &&
                                $permohonan->status != App\Enums\StatusPermohonanEnum::SELESAI->value &&
                                !$permohonan->is_ttd)
                            @if ($alur_permohonan->is_done)
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                                              :is_show_badge="false"
                                                                              :is_ttd="$permohonan->is_ttd"
                                                                              :show_ttd_status="true"
                                                                              class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                                              class_input="text-xsm"
                                                                              downloadUrl="{{ route('download-izin-terbit', $permohonan->id) }}"
                                                                              label="Ijin Terbit"
                                                                              name="ijin_terbit" />
                                    </div>
                                    <div class="col-3">
                                        <button class="d-block text-xsm btn w-100 btn-primary mb-3"
                                                onclick="generateUlangIzinTerbit()"
                                                type="button">
                                            <i class="isax isax-refresh me-2"></i> Generate Ulang Ijin Terbit
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @elseif($permohonan->template_surat_filepath)
                            <x-dashboard.input-inline-file-upload :is_readonly="true"
                                                                  :is_show_badge="false"
                                                                  :is_ttd="$permohonan->is_ttd"
                                                                  :show_ttd_status="true"
                                                                  class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                                  class_input="text-xsm"
                                                                  downloadUrl="{{ route('download-izin-terbit', $permohonan->id) }}"
                                                                  label="Ijin Terbit"
                                                                  name="ijin_terbit" />
                        @endif
                    @endif
                @endif
                @if (
                    $alur_permohonan->jenis_verifikator != App\Enums\JenisVerifikatorEnum::FO->value &&
                        ($alur_permohonan->jenis_verifikator != App\Enums\JenisVerifikatorEnum::OPD->value ||
                            $permohonan->jenis_izin_id == 9))
                    <h5 class="mt-4">Data Kelengkapan Verifikator</h5>
                    @foreach ($permohonan->kelengkapanPermohonan as $kelengkapan_permohonan)
                        {{-- HANDLE REKLAME --}}
                        @if (
                            $permohonan->jenis_izin_id == 9 &&
                                $alur_permohonan->jenis_verifikator == App\Enums\JenisVerifikatorEnum::OPD->value &&
                                $permohonan->status != App\Enums\StatusPermohonanEnum::SELESAI->value &&
                                $is_all_berkas_valid &&
                                $is_verifikator_turn &&
                                ($kelengkapan_permohonan->kode_isian == 'NO_SKPD' ||
                                    $kelengkapan_permohonan->kode_isian == 'PAJAK_REKLAME_TERBILANG' ||
                                    $kelengkapan_permohonan->kode_isian == 'PAJAK_REKLAME') &&
                                $permohonan->reklame?->skpd_filepath)
                            @if ($kelengkapan_permohonan->kode_isian == 'PAJAK_REKLAME')
                                <x-dashboard.input-inline-text :is_currency=True
                                                               class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                               class_input="text-xsm"
                                                               label="{{ $kelengkapan_permohonan->label }}"
                                                               name="{{ $kelengkapan_permohonan->kode_isian }}"
                                                               placeholder="Masukkan {{ $kelengkapan_permohonan->label }}"
                                                               value="{{ old($kelengkapan_permohonan->kode_isian, $kelengkapan_permohonan->value) }}" />
                            @else
                                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                               class_input="text-xsm"
                                                               label="{{ $kelengkapan_permohonan->label }}"
                                                               name="{{ $kelengkapan_permohonan->kode_isian }}"
                                                               placeholder="Masukkan {{ $kelengkapan_permohonan->label }}"
                                                               value="{{ old($kelengkapan_permohonan->kode_isian, $kelengkapan_permohonan->value) }}" />
                            @endif
                        @elseif (
                            $alur_permohonan->jenis_verifikator == App\Enums\JenisVerifikatorEnum::BO->value &&
                                $permohonan->status != App\Enums\StatusPermohonanEnum::SELESAI->value &&
                                $is_all_berkas_valid &&
                                $is_verifikator_turn)
                            @if ($kelengkapan_permohonan->tipe == 'text')
                                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                               class_input="text-xsm"
                                                               label="{{ $kelengkapan_permohonan->label }}"
                                                               name="{{ $kelengkapan_permohonan->kode_isian }}"
                                                               placeholder="Masukkan {{ $kelengkapan_permohonan->label }}"
                                                               value="{{ old($kelengkapan_permohonan->kode_isian, $kelengkapan_permohonan->value) }}" />
                            @elseif($kelengkapan_permohonan->tipe == 'date')
                                <x-dashboard.input-inline-text :required=True
                                                               class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                               class_input="text-start text-xsm"
                                                               id="{{ $kelengkapan_permohonan->id }}"
                                                               label="{{ $kelengkapan_permohonan->label }}"
                                                               name="{{ $kelengkapan_permohonan->kode_isian }}"
                                                               placeholder="Masukkan {{ $kelengkapan_permohonan->label }}"
                                                               type="date"
                                                               value="{{ old($kelengkapan_permohonan->kode_isian, $kelengkapan_permohonan->value) }}" />
                            @endif
                        @else
                            <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                           class_input="border-0 text-end text-xsm"
                                                           label="{{ $kelengkapan_permohonan->label }}"
                                                           name="{{ $kelengkapan_permohonan->kode_isian }}"
                                                           readonly
                                                           value="{{ $kelengkapan_permohonan->value ?? '-' }}" />
                        @endif
                    @endforeach
                @endif

                @if ($is_verifikator_turn && $is_can_verified)
                    <div class="mt-4">
                        @if ($alur_permohonan->jenis_verifikator == App\Enums\JenisVerifikatorEnum::PENANDATANGAN->value)
                            <input id="passphrase"
                                   name="passphrase"
                                   type="hidden">
                            <button class="d-block btn w-100 btn-primary"
                                    onclick="promptTtd()">
                                <i class="isax isax-tick-circle me-2"></i> Tanda Tangan dan Selesaikan Permohonan
                            </button>
                        @else
                            <button class="d-block btn w-100 btn-primary">
                                <i class="isax isax-tick-circle me-2"></i> Simpan
                            </button>
                        @endif
                    </div>
                @endif
            </form>

            @if ($is_verifikator_approvable_berkas)
                @include('components.dashboard.modal-validasi')
            @endif
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function promptTtd() {
            event.preventDefault();
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ingin menandatangani ijin terbit dan menyelesaikan permohonan?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Masukkan passphrase',
                        input: 'password',
                        inputAttributes: {
                            autocapitalize: 'off'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Tanda Tangan',
                        cancelButtonText: 'Batal',
                        showLoaderOnConfirm: true,
                        preConfirm: (passphrase) => {
                            if (!passphrase) {
                                Swal.showValidationMessage('Passphrase tidak boleh kosong');
                            }
                            return passphrase;
                        },
                        allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#passphrase').val(result.value);
                            $('form').submit();
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Tanda tangan dibatalkan'
                    });
                }
            });
        }

        function generateUlangIzinTerbit() {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ingin generate ulang ijin terbit? Pastikan template surat pada admin telah berubah jika ingin melakukan perubahan layout surat.',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('verifikator.verifikasi.generate-ulang-izin-terbit', $permohonan->id) }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        // show loading
                        beforeSend: function() {
                            Swal.fire({
                                title: 'Loading',
                                html: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading()
                                },
                            });
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Generate ulang ijin terbit berhasil'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Generate ulang ijin terbit gagal'
                                });
                            }
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Generate ulang ijin terbit gagal'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Generate ulang ijin terbit dibatalkan'
                    });
                }
            });
        }
    </script>
@endpush
