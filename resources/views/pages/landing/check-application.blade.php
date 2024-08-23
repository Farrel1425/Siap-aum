@extends('layouts.landing.main-base')


@section('content')
    <x-landing.back-button label="Cek Permohonan" class="py-2 px-4" />
    <div class="container">
        <div class="d-flex flex-column align-items-center gap-2 mt-4">
            <h4>Nomor Pendaftaran</h4>
            <x-landing.search-input class="w-100" />
        </div>
        <x-landing.progress-stepper-bar :steps="['Pengajuan', 'Verifikator', 'Verifikator Rekomendasi', 'Verifikator Kelengkapan', 'JF', 'Penandatangan']" :currentStep="4" />
        {{-- <x-landing.data-card label="No Registrasi" value="BLL/1716962858/11/4564" /> --}}
        {{-- <x-landing.table>
            <x-slot:header>
                <th>Aktivitas</th>
                <th>Tanggal Aktivitas</th>
            </x-slot:header>
            <tr>
                <td>Pengajuan dibuat</td>
                <td>27/05/2024 18:18</td>
            </tr>
            <tr>
                <td>Disetujui Verifikator</td>
                <td>27/05/2024 18:13</td>
            </tr>
            <tr>
                <td>Disetujui Verifikator Rekomendasi</td>
                <td>27/05/2024 15:59</td>
            </tr>
        </x-landing.table> --}}
    </div>
@endsection
