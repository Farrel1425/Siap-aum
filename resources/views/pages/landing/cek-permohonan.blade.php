@extends('layouts.landing.main-base')

@section('content')
<main class="sa-public-page">
    <header class="sa-public-hero sa-public-hero--compact">
        <a class="sa-public-back" href="{{ route('home') }}"><i class="isax isax-arrow-left-2"></i> Kembali</a>
        <span class="sa-eyebrow"><i></i>Lacak permohonan</span>
        <h1>Cek status izin Anda</h1>
        <p>Masukkan nomor registrasi untuk melihat posisi berkas dan riwayat proses permohonan.</p>
    </header>
    <section class="sa-track-card">
        <form action="{{ route('cek-permohonan.store') }}" class="sa-track-form" method="POST">
            @csrf
            <label for="nomor_registrasi">Nomor registrasi</label>
            <div><input id="nomor_registrasi" name="nomor_registrasi" placeholder="Contoh: REG/2026/00001" type="text" value="{{ $nomor_registrasi ?? '' }}"><button type="submit"><i class="isax isax-search-favorite"></i><span>Cari Permohonan</span></button></div>
        </form>
        @if (isset($is_found) && $is_found)
            <div class="sa-track-result">
                <x-landing.progress-stepper-bar :steps="$steps" />
                <x-log-aktivitas-table :permohonan=$permohonan />
                <div class="sa-track-details">
                    <x-dashboard.input-inline-text class="bg-white p-2 mb-3 text-xsm" class_input="border-0 text-end text-xsm" label="No Registrasi" name="nomor_registrasi" readonly value="{{ $permohonan->nomor_registrasi }}" />
                    <x-dashboard.input-inline-text class="bg-white p-2 mb-3 text-xsm" class_input="border-0 text-end text-xsm" label="Jenis Perizinan" name="jenis_izin" readonly value="{{ $permohonan->jenisIzin->nama }}" />
                    <x-dashboard.input-inline-text class="bg-white p-2 mb-3 text-xsm" class_input="border-0 text-end text-xsm" label="Nama" name="nama" readonly value="{{ $permohonan->nama }}" />
                    <x-dashboard.input-inline-text class="bg-white p-2 mb-3 text-xsm" class_input="border-0 text-end text-xsm" label="Status" name="status" readonly value="{{ $permohonan->status }}" />
                </div>
            </div>
        @elseif(isset($is_found))
            <div class="sa-track-empty"><i class="isax isax-info-circle"></i><p>Permohonan dengan nomor registrasi <strong>{{ $nomor_registrasi }}</strong> tidak ditemukan.</p></div>
        @endif
    </section>
</main>
@endsection
