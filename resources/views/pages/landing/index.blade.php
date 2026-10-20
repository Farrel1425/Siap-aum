@extends('layouts.landing.main-base')

@section('content')
<main class="siap-aum-landing">
    <section class="sa-hero" id="home">
        <div class="sa-hero__wash"></div>
        <div class="sa-hero__content">
            <div class="sa-government-badge" aria-label="Pemerintah Kabupaten Tabanan">
                <img src="{{ asset('assets/images/siap-aum/siap-aum-mark.svg') }}" alt="Logo SIAP AUM">
                <img src="{{ asset('assets/images/siap-aum/figma-raw-3.png') }}" alt="Lambang Kabupaten Tabanan">
            </div>
            <h1>Sistem Informasi Administrasi<br>Perizinan Andal, Unggul, <span class="sa-title-accent" aria-hidden="true"><i></i><i></i></span><br>Nyaman, dan Gesit</h1>
            <p>SIAP AUM adalah portal pelayanan perizinan online berbasis website yang dikembangkan oleh Pemerintah Kabupaten Tabanan yang bertujuan untuk memenuhi kebutuhan masyarakat dalam pengajuan izin yang transparan, inovatif, efektif, dan efisien. Sistem perizinan online ini diperuntukkan bagi pemohon yang ingin mengajukan permohonan perizinan secara online. Masyarakat dapat mengajukan permohonan izin secara mandiri kapan pun dan di mana pun tanpa harus datang langsung ke kantor DPMPTSP Kabupaten Tabanan.</p>
            <div class="sa-hero__actions">
                @auth
                    <a class="sa-btn sa-btn--primary" href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a class="sa-btn sa-btn--primary" href="{{ route('login.index') }}">Login</a>
                @endauth
                <a class="sa-btn sa-btn--light" href="#cek-permohonan">Cek Permohonan</a>
            </div>
        </div>
        <a class="sa-scroll-hint" href="#tentang">Scroll for more <span aria-hidden="true">&darr;</span></a>
    </section>

    <section class="sa-section sa-about" id="tentang">
        <span class="sa-eyebrow"><i></i>Tentang</span>
        <h2>Mari daftarkan permohonan izin anda<br>melalui SIAP AUM</h2>
        <div class="sa-about__grid">
            <div class="sa-about__visual">
                <div class="sa-about__backdrop"></div>
                <img src="{{ asset('assets/images/siap-aum/figma-raw-4.png') }}" alt="Gerbang Kabupaten Tabanan">
            </div>
            <div class="sa-about__benefits">
                <div class="sa-soft-card sa-soft-card--intro">Dengan menggunakan SIAP AUM, Anda dapat mengajukan permohonan izin secara mandiri dengan sistem online. Berikut merupakan keunggulan dari SIAP AUM:</div>
                <div class="sa-soft-card">Memudahkan anda mengajukan permohonan izin tanpa calo</div>
                <div class="sa-soft-card">Verifikasi berkas oleh petugas DPMPTSP secara online</div>
                <div class="sa-soft-card">Pemantauan posisi berkas secara online</div>
                <div class="sa-soft-card">Revisi berkas permohonan izin secara online</div>
                <div class="sa-soft-card">Revisi berkas permohonan izin secara online</div>
            </div>
        </div>
    </section>

    <section class="sa-recap" id="rekap">
        <div class="sa-recap__light"></div>
        <div class="sa-section-heading sa-section-heading--inverse"><span class="sa-eyebrow"><i></i>Rekap</span><h2>Rekapitulasi Izin yang Masuk</h2></div>
        <form class="sa-year-filter" action="{{ route('home') }}" method="GET"><label for="tahun">Tahun</label><select id="tahun" name="tahun" onchange="this.form.submit()">@foreach ($tahun_options as $tahun_option)<option value="{{ $tahun_option }}" @selected($tahun_option == $tahun)>{{ $tahun_option }}</option>@endforeach</select></form>
        @php
            $stats = [
                ['icon' => 'stat-user.svg', 'value' => $user_count, 'label' => 'Jumlah Pemohon'],
                ['icon' => 'stat-graph.svg', 'value' => $permohonan_count, 'label' => 'Total Permohonan'],
                ['icon' => 'stat-timer.svg', 'value' => $permohonan_proses_count, 'label' => 'Dalam Proses'],
                ['icon' => 'stat-printer.svg', 'value' => $permohonan_selesai_count, 'label' => 'Izin Selesai'],
            ];
        @endphp
        <div class="sa-stats">
            @foreach ($stats as $stat)
                <article class="sa-stat-card"><span class="sa-stat-card__icon"><img src="{{ asset('assets/images/siap-aum/'.$stat['icon']) }}" alt=""></span><strong>{{ number_format($stat['value']) }}</strong><span>{{ $stat['label'] }}</span></article>
            @endforeach
        </div>
        <details class="sa-survey"><summary>Hasil Survey Kepuasan Masyarakat</summary><div class="sa-survey__body"><div class="sa-survey__score"><strong>{{ number_format((float) min($laporan_survey['persentaseNilaiIKM'], 84), 2, '.', '') }}</strong><span>Sangat Baik · {{ $laporan_survey['totalKuesioner'] }} responden</span></div><div class="sa-survey__bars">@foreach ($laporan_survey['nrrTertbgUnsurPercentage'] as $layanan => $value)<div><span>{{ $layanan }}</span><i style="width: {{ min($value, 84) }}%"></i></div>@endforeach</div></div></details>
    </section>

    <section class="sa-section sa-guide" id="panduan">
        <div class="sa-section-heading"><span class="sa-eyebrow"><i></i>Panduan</span><h2>Panduan Pengajuan</h2></div>
        @php
            $steps = [
                ['user-add', 'Daftarkan akun anda untuk mengakses halaman permohonan'],
                ['login', 'Masuklah ke akun Anda untuk memulai permohonan.'],
                ['add-square', 'Buka tombol Tambah untuk membuat pengajuan.'],
                ['document-text', 'Pilih jenis pengajuan yang ingin Anda buat.'],
                ['clipboard-text', 'Isilah formulir yang telah disediakan dengan saksama.'],
                ['tick-circle', 'Tunggulah hingga pengajuan Anda disetujui.'],
            ];
        @endphp
        <div class="sa-guide__layout">
            <div class="sa-guide__column">@foreach (array_slice($steps, 0, 3) as $index => $step)<article class="sa-step-card"><span class="sa-step-icon"><i class="isax isax-{{ $step[0] }}"></i></span><strong>{{ $index + 1 }}</strong><p>{{ $step[1] }}</p></article>@endforeach</div>
            <div class="sa-guide__brand"><img src="{{ asset('assets/images/siap-aum/siap-aum-mark.svg') }}" alt=""><span>Siap Aum</span></div>
            <div class="sa-guide__column">@foreach (array_slice($steps, 3, 3) as $index => $step)<article class="sa-step-card"><span class="sa-step-icon"><i class="isax isax-{{ $step[0] }}"></i></span><strong>{{ $index + 4 }}</strong><p>{{ $step[1] }}</p></article>@endforeach</div>
        </div>
    </section>

    <section class="sa-section sa-check" id="cek-permohonan">
        <div class="sa-section-heading"><span class="sa-eyebrow"><i></i>Cek Permohonan</span><h2>Cek Permohonan</h2></div>
        <form class="sa-check__form" action="{{ route('cek-permohonan.store') }}" method="POST">@csrf<label class="visually-hidden" for="nomor_registrasi">Nomor permohonan</label><input id="nomor_registrasi" name="nomor_registrasi" type="text" required placeholder="cek Nomor Permohonan"><button type="submit" aria-label="Cari nomor permohonan"><i class="isax isax-search-normal-1"></i></button></form>
    </section>

    <section class="sa-section sa-why" id="kenapa">
        <div class="sa-section-heading"><span class="sa-eyebrow"><i></i>Kenapa Siap Aum</span><h2>Kenapa SIAP AUM?</h2></div>
        <div class="sa-why__grid">
            <article class="sa-why-card sa-why-card--speed">
                <div class="sa-speed-lines" aria-hidden="true">
                    <div><i></i><span><img src="{{ asset('assets/images/siap-aum/why-bullseye.svg') }}" alt="">Accuracy</span></div>
                    <div><i></i><span><img src="{{ asset('assets/images/siap-aum/why-latency.svg') }}" alt="">Latency</span></div>
                    <div><i></i><span><img src="{{ asset('assets/images/siap-aum/why-shield-label.svg') }}" alt="">Safety</span></div>
                    <div><i></i><span><img src="{{ asset('assets/images/siap-aum/why-fast.svg') }}" alt="">Fast</span></div>
                </div>
                <div class="sa-why-card__copy"><h3>Pelayanan Cepat &amp; Efisien</h3><p>Proses perizinan dirancang sederhana dan terintegrasi sehingga pengajuan dapat dilakukan dengan cepat tanpa prosedur yang berbelit.</p></div>
            </article>
            <article class="sa-why-card sa-why-card--access">
                <div class="sa-checks" aria-hidden="true"><span></span>@for ($i = 0; $i < 3; $i++)<i><img src="{{ asset('assets/images/siap-aum/why-check.svg') }}" alt=""></i>@endfor</div>
                <div class="sa-why-card__copy"><h3>Akses Mudah Kapan Saja &amp; Di Mana Saja</h3><p>Masyarakat dapat mengajukan dan mengunduh izin secara online tanpa harus datang ke kantor, cukup melalui perangkat masing-masing.</p></div>
            </article>
            <article class="sa-why-card sa-why-card--secure">
                <div class="sa-shield" aria-hidden="true"><img src="{{ asset('assets/images/siap-aum/why-shield.svg') }}" alt=""></div>
                <div class="sa-why-card__copy"><h3>Aman &amp; Terjamin Legalitasnya</h3><p>Dilengkapi dengan sistem keamanan dan Tanda Tangan Elektronik resmi, sehingga dokumen izin memiliki kekuatan hukum dan terjamin keasliannya.</p></div>
            </article>
            <article class="sa-why-card sa-why-card--monitor">
                <div class="sa-monitor" aria-hidden="true"><img src="{{ asset('assets/images/siap-aum/why-monitor.svg') }}" alt=""></div>
                <div class="sa-why-card__copy"><h3>Transparan &amp; Mudah Dipantau</h3><p>Setiap tahapan permohonan izin dapat dipantau secara real-time, sehingga masyarakat mengetahui status pengajuan dengan jelas.</p></div>
            </article>
        </div>
    </section>

    <section class="sa-section sa-download" aria-roledescription="carousel" aria-label="Tahapan layanan SIAP AUM">
        @php
            $service_slides = [
                ['image' => 'service-apply.jpg', 'title' => 'Ajukan izin secara online', 'description' => 'Ajukan permohonan izin dari mana saja tanpa harus datang ke kantor. Pilih layanan, isi data, dan unggah dokumen secara praktis melalui SIAP AUM.'],
                ['image' => 'service-track.jpg', 'title' => 'Pantau proses permohonan', 'description' => 'Ketahui perkembangan permohonan secara transparan. Setiap proses verifikasi dan perubahan status dapat dipantau langsung melalui akun Anda.'],
                ['image' => 'service-revise.jpg', 'title' => 'Perbaiki dokumen dengan mudah', 'description' => 'Jika terdapat dokumen yang perlu diperbaiki, petugas akan memberikan catatan revisi. Perbarui dan kirim kembali berkas tanpa harus datang ke kantor.'],
                ['image' => 'service-download.jpg', 'title' => 'Unduh izin resmi Anda', 'description' => 'Setelah disetujui, dokumen izin resmi dapat diunduh langsung melalui akun SIAP AUM dan dilengkapi Tanda Tangan Elektronik untuk menjamin keasliannya.'],
            ];
        @endphp
        <div class="sa-download__viewport">
            <div class="sa-download__track">
                @foreach ($service_slides as $index => $slide)
                    <article class="sa-download__slide" aria-hidden="{{ $index === 0 ? 'false' : 'true' }}">
                        <div class="sa-download__image"><img src="{{ asset('assets/images/siap-aum/'.$slide['image']) }}" alt="{{ $slide['title'] }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}" decoding="async" @if ($index === 0) fetchpriority="high" @endif></div>
                        <div class="sa-download__copy"><h2>{{ $slide['title'] }}</h2><p>{{ $slide['description'] }}</p></div>
                    </article>
                @endforeach
            </div>
        </div>
        <div class="sa-download__controls">
            <div class="sa-download__dots" role="tablist" aria-label="Pilih tahapan layanan">
                @foreach ($service_slides as $index => $slide)<button type="button" class="{{ $index === 0 ? 'is-active' : '' }}" aria-label="Tampilkan slide {{ $index + 1 }}: {{ $slide['title'] }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}"></button>@endforeach
            </div>
            <div class="sa-download__arrows"><button type="button" data-carousel-prev aria-label="Slide sebelumnya">&larr;</button><button type="button" data-carousel-next aria-label="Slide berikutnya">&rarr;</button></div>
        </div>
    </section>
</main>
@endsection
