@extends('layouts.landing.main-base')


@section('content')
    <div class="mt-5"></div>
    <x-landing.back-button class="py-2 px-4 mt-5"
                           label="Cek Permohonan" />
    <div class="container mt-4">
        <h3 class="text-center mb-3">NOMOR PENDAFTARAN</h3>
        <form action="{{ route('cek-permohonan.store') }}"
              class="mt-3"
              method="POST">
            @csrf
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="form-group mb-3">
                        <input class="form-control"
                               id="nomor_registrasi"
                               name="nomor_registrasi"
                               placeholder="Masukkan Nomor Registrasi"
                               type="text"
                               value="{{ isset($nomor_registrasi) ? $nomor_registrasi : '' }}">
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <button class="btn btn-primary w-100"><i class="isax isax-search-favorite"></i> Cari</button>
                </div>
            </div>
        </form>
        @if (isset($is_found) && $is_found)
            <h3 class="text-primary text-center mt-4 mb-3">laskdalskdk</h3>
            <x-landing.progress-stepper-bar :steps="$steps" />
            {{-- <div class="mb-3">
                <div class="card">
                    <div class="card-body text-xsm">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Aktivitas</th>
                                        <th class="text-center">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permohonan->logs as $log)
                                        <tr>
                                            <td>{{ $log->aktivitas }}</td>
                                            <td>{{ $log->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="mb-5">
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="No Registrasi"
                                               name="nomor_registrasi"
                                               readonly
                                               value="{{ $permohonan->nomor_registrasi }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="Jenis Perijinan"
                                               name="jenis_izin"
                                               readonly
                                               value="{{ $permohonan->jenisIzin->nama }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="Nama"
                                               name="nama"
                                               readonly
                                               value="{{ $permohonan->nama }}" />
                <x-dashboard.input-inline-text class="bg-white p-2 mx-1 mb-3 text-xsm"
                                               class_input="border-0 text-end text-xsm"
                                               label="Status"
                                               name="status"
                                               readonly
                                               value="{{ $permohonan->status }}" />
            </div>
        @elseif(isset($is_found))
            <div class="alert alert-danger">
                <p class="mb-0">Permohonan dengan nomor registrasi <strong>{{ $nomor_registrasi }}</strong> tidak
                    ditemukan.</p>
            </div>
        @endif
    </div>
@endsection
