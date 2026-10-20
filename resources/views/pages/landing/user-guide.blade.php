@extends('layouts.landing.main-base')

@section('content')
<main class="sa-public-page">
    <header class="sa-public-hero">
        <a class="sa-public-back" href="{{ route('home') }}"><i class="isax isax-arrow-left-2"></i> Kembali</a>
        <span class="sa-eyebrow"><i></i>Panduan pengguna</span>
        <h1>Pengajuan izin dalam<br>enam langkah mudah</h1>
        <p>Ikuti alur berikut untuk membuat akun, mengirim permohonan, dan memantau proses izin melalui SIAP AUM.</p>
    </header>
    <section class="sa-guide-page-grid">
        @php
            $guides = [
                ['Daftar akun', 'Daftarkan akun menggunakan email aktif untuk mengakses layanan permohonan.', 'user-guide-1.svg'],
                ['Masuk ke SIAP AUM', 'Masuk menggunakan akun yang telah terdaftar untuk memulai pengajuan.', 'user-guide-2.svg'],
                ['Buat pengajuan', 'Pilih tombol pengajuan baru dari dashboard pemohon.', 'user-guide-3.svg'],
                ['Pilih jenis izin', 'Tentukan jenis perizinan yang sesuai dengan kebutuhan Anda.', 'user-guide-4.svg'],
                ['Lengkapi data', 'Isi formulir dan unggah seluruh dokumen persyaratan dengan teliti.', 'user-guide-5.svg'],
                ['Pantau hingga selesai', 'Pantau status, lakukan revisi bila diminta, lalu unduh izin yang telah terbit.', 'user-guide-6.svg'],
            ];
        @endphp
        @foreach ($guides as $index => $guide)
            <article class="sa-guide-page-card">
                <span class="sa-guide-page-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                <img src="{{ asset('assets/images/' . $guide[2]) }}" alt="" aria-hidden="true">
                <div><h2>{{ $guide[0] }}</h2><p>{{ $guide[1] }}</p></div>
            </article>
        @endforeach
    </section>
    <div class="sa-public-actions"><a class="sa-btn sa-btn--primary" href="{{ route('register.index') }}">Mulai Daftar</a><a class="sa-btn sa-btn--light" href="{{ route('login.index') }}">Masuk ke Akun</a></div>
</main>
@endsection
