@extends('layouts.landing.main-base')

@section('content')
    <x-landing.hero>
        <div class="content-header">
            <div class="d-flex justify-content-center align-items-center gap-3 flex-row mt-3 mt-md-0">
                <img alt=""
                     class="img-logo"
                     src="{{ asset('assets/images/logo-kabupaten.png') }}">
                <img alt=""
                     class="img-logo"
                     src="{{ asset('assets/images/logo-siajaib.png') }}">
            </div>
            <p class="text-center my-3 main-description">
                <span class="fw-bold">SI AJAIB</span> adalah portal pelayanan perizinan online berbasis
                website yang dikembangkan oleh
                Pemerintah Kabupaten Buleleng yang bertujuan untuk memenuhi kebutuhan masyarakat dalam
                pengajuan
                izin yang transparans, inovatif, efektif, dan efisien. Sistem perizinan online ini
                diperuntukkan
                bagi pemohon yang ingin mengajukan permohonan perizinan secara online. Masyarakat dapat
                mengajukan permohonan izin secara mandiri kapan pun dan dimana pun tanpa harus datang
                langsung
                ke kantor DPMPTSP Kabupaten Buleleng.
            </p>
            @auth
                <a class="fw-bold btn btn-outline-danger"
                   href="{{ route('dashboard') }}">
                    <span class="isax-bold isax-login me-2"></span>Dashboard
                </a>
            @else
                <a class="fw-bold btn btn-outline-danger"
                   href="{{ route('login.index') }}">
                    <span class="isax-bold isax-login me-2"></span>Login
                </a>
            @endauth
        </div>
    </x-landing.hero>
    <div class="container">
        <section class="my-4">
            <div class="invite-to-join row gy-4">
                <img alt=""
                     class="col-md-6"
                     src="{{ asset('assets/images/logo-landing-1.png') }}">
                <div class="col-md-6 my-md-auto">
                    <h3 class="text-primary">Mari daftarkan permohonan izin anda melalui SI AJAIB</h3>
                    <p>Dengan menggunakan Si Ajaib anda dapat mengajukan permohonan izin secara mandiri dengan sistem
                        online. Berikut merupakan keunggulan dari Si Ajaib :</p>
                    <ul>
                        <li>Memudahkan anda mengajukan permohonan izin tanpa calo</li>
                        <li>Verifikasi berkas oleh petugas DPMPTSP secara online</li>
                        <li>Pemantauan posisi berkas secara online</li>
                        <li>Revisi berkas permohonan izin secara online</li>
                        <li>Unduh Izin Resmi anda secara online</li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="my-4">
            <div class="summary-filter-bar mb-3">
                <form action="{{ route('home') }}"
                      class="summary-year-filter"
                      method="GET">
                    <span class="summary-year-filter__icon">
                        <i class="isax isax-calendar-1"></i>
                    </span>
                    <div class="summary-year-filter__content">
                        <label class="summary-year-filter__label"
                               for="tahun">Tahun Pelaporan</label>
                        <select class="form-select summary-year-filter__select"
                                id="tahun"
                                name="tahun"
                                onchange="this.form.submit()">
                            @foreach ($tahun_options as $tahun_option)
                                <option value="{{ $tahun_option }}"
                                        @selected($tahun_option == $tahun)>
                                    {{ $tahun_option }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="row g-4">
                <div class="col-6 col-lg-3">
                    <x-landing.total-summary icon="profile-circle"
                                             label="Jumlah Pemohon"
                                             total="{{ number_format($user_count) }}" />
                </div>
                <div class="col-6 col-lg-3">
                    <x-landing.total-summary icon="graph"
                                             label="Total Pemohonan"
                                             total="{{ number_format($permohonan_count) }}" />
                </div>
                <div class="col-6 col-lg-3">
                    <x-landing.total-summary icon="timer"
                                             label="Dalam Proses"
                                             total="{{ number_format($permohonan_proses_count) }}" />
                </div>
                <div class="col-6 col-lg-3">
                    <x-landing.total-summary icon="printer"
                                             label="Izin Selesai"
                                             total="{{ number_format($permohonan_selesai_count) }}" />
                </div>
            </div>
            <div class="row g-4 mt-4">
                <div class="col-lg-3">
                    <x-landing.card
                                    class="h-100 d-flex flex-column align-items-center justify-content-center text-center score-card">
                        <span
                              class="score">{{ number_format((float) ($laporan_survey['persentaseNilaiIKM'] < 84 ? $laporan_survey['persentaseNilaiIKM'] : 84), 2, '.', '') }}</span>
                        <span class="description">Sangat Baik</span>
                        <span class="respondent-count">dari {{ $laporan_survey['totalKuesioner'] }} responden (data 6 bulan
                            terakhir)</span>
                    </x-landing.card>
                </div>
                <div class="col-lg-9">
                    <x-landing.card class="d-flex flex-column text-center">
                        <h5>Hasil Survey Kepuasan Masyarakat terhadap Pelayanan Publik</h5>
                        <p>Mall Pelayanan Publik (MPP) Kabupaten Buleleng</p>
                        <div class="d-flex flex-column gap-2">
                            @foreach ($laporan_survey['nrrTertbgUnsurPercentage'] as $layanan => $value)
                                <div class="progress">
                                    <div aria-valuemax="100"
                                         aria-valuemin="0"
                                         aria-valuenow="25"
                                         class="progress-bar"
                                         role="progressbar"
                                         style="width: {{ ($laporan_survey['persentaseNilaiIKM'] < 84 ? $value : 84) }}%">
                                        {{ $layanan }} : {{ number_format((float) ($laporan_survey['persentaseNilaiIKM'] < 84 ? $value : 84), 2, '.', '') }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-landing.card>
                </div>
            </div>
        </section>
        <section class="my-4">
            <div class="invite-to-join row gy-4">
                <div class="col-md-6 order-last order-md-first my-md-auto">
                    <h3 class="text-md-end text-primary">Download izin anda secara online</h3>
                    <p class="text-md-end">Dengan menggunakan Si Ajaib anda tidak perlu datang ke kantor hanya untuk
                        mengambil izin yang sudah terbit, cukup dengan mendownload izin yang sudah terbit melalui akun Si
                        Ajaib anda. Untuk menjaga validitas izin anda, kami telah bekerjasama dengan BSrE(Balai Sertifikasi
                        Elektronik) perihal penerbitan izin dengan Tanda Tangan Elektronik
                    </p>
                </div>
                <img alt=""
                     class="col-md-6"
                     src="{{ asset('assets/images/logo-landing-1.png') }}">
            </div>
        </section>
    </div>
@endsection
