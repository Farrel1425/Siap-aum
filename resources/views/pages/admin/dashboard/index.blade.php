@extends('layouts.dashboard.dashboard-base')

@section('content')
    <div class="page-heading sa-admin-dashboard">
        <section class="sa-admin-hero mb-4">
            <div class="sa-admin-hero__content">
                <span class="sa-admin-eyebrow">RINGKASAN ADMINISTRATOR</span>
                <h1>Selamat datang, {{ auth()->user()->name ?? 'Admin' }}</h1>
                <p>Pantau permohonan dan kelola layanan SIAP AUM dari satu halaman.</p>
                <div class="sa-admin-hero__meta">
                    <span><i class="isax isax-calendar-1"></i>{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                    <span><i class="isax isax-shield-tick"></i>Sistem berjalan normal</span>
                </div>
            </div>
            <div class="sa-admin-hero__actions">
                <a class="btn sa-admin-hero__primary" href="{{ route('admin.permohonan.index') }}">
                    <i class="isax-bold isax-receipt-search"></i>Lihat Permohonan
                </a>
                <button type="button" class="btn sa-admin-hero__secondary" id="deployBtn">
                    <i class="isax-bold isax-refresh-2"></i>Update Aplikasi
                </button>
            </div>
            <div class="sa-admin-hero__ornament" aria-hidden="true"></div>
        </section>

        <section class="sa-admin-stats mb-4" aria-label="Statistik permohonan">
            <article class="sa-admin-stat sa-admin-stat--total">
                <div class="sa-admin-stat__icon"><i class="isax-bold isax-document-text"></i></div>
                <div class="sa-admin-stat__copy">
                    <span>Total Permohonan</span>
                    <strong>{{ number_format($total_permohonan, 0, ',', '.') }}</strong>
                    <small>Usulan yang telah diajukan</small>
                </div>
            </article>
            <article class="sa-admin-stat sa-admin-stat--process">
                <div class="sa-admin-stat__icon"><i class="isax-bold isax-setting-2"></i></div>
                <div class="sa-admin-stat__copy">
                    <span>Sedang Diproses</span>
                    <strong>{{ number_format($permohonan_diproses, 0, ',', '.') }}</strong>
                    <small>Memerlukan tindak lanjut</small>
                </div>
            </article>
            <article class="sa-admin-stat sa-admin-stat--done">
                <div class="sa-admin-stat__icon"><i class="isax-bold isax-tick-circle"></i></div>
                <div class="sa-admin-stat__copy">
                    <span>Permohonan Selesai</span>
                    <strong>{{ number_format($permohonan_selesai, 0, ',', '.') }}</strong>
                    <small>Telah diselesaikan</small>
                </div>
            </article>
        </section>

        <div class="sa-admin-content-grid">
            <section class="card sa-admin-recent">
                <div class="card-header sa-admin-section-heading">
                    <div>
                        <span class="sa-admin-section-heading__eyebrow">AKTIVITAS TERBARU</span>
                        <h2>Permohonan terkini</h2>
                    </div>
                    <a href="{{ route('admin.permohonan.index') }}">Lihat semua <i class="isax isax-arrow-right-3"></i></a>
                </div>
                <div class="card-body p-0">
                    @forelse ($permohonan_terbaru as $permohonan)
                        <a class="sa-admin-request" href="{{ route('admin.permohonan.show', $permohonan->id) }}">
                            <span class="sa-admin-request__avatar">{{ strtoupper(substr($permohonan->nama ?? 'P', 0, 1)) }}</span>
                            <span class="sa-admin-request__main">
                                <strong>{{ $permohonan->nama ?? 'Pemohon' }}</strong>
                                <small>{{ $permohonan->nama_jenis_izin }}</small>
                            </span>
                            <span class="sa-admin-request__status">{!! $permohonan->status_badge !!}</span>
                            <span class="sa-admin-request__date">
                                {{ ($permohonan->pengajuan_at ?? $permohonan->created_at)?->locale('id')->isoFormat('D MMM YYYY') }}
                            </span>
                            <i class="isax isax-arrow-right-3 sa-admin-request__arrow"></i>
                        </a>
                    @empty
                        <div class="sa-admin-empty">
                            <span><i class="isax isax-document"></i></span>
                            <strong>Belum ada permohonan</strong>
                            <p>Permohonan terbaru akan tampil di bagian ini.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <aside class="sa-admin-side-stack">
                <section class="card sa-admin-progress-card">
                    <div class="card-body">
                        <div class="sa-admin-progress-card__top">
                            <div>
                                <span>TINGKAT PENYELESAIAN</span>
                                <strong>{{ $persentase_selesai }}%</strong>
                            </div>
                            <div class="sa-admin-progress-ring" style="--progress: {{ $persentase_selesai }}">
                                <span>{{ $persentase_selesai }}%</span>
                            </div>
                        </div>
                        <div class="progress sa-admin-progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $persentase_selesai }}%"
                                 aria-valuenow="{{ $persentase_selesai }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <p>{{ number_format($permohonan_selesai, 0, ',', '.') }} dari {{ number_format($total_permohonan, 0, ',', '.') }} permohonan telah selesai.</p>
                    </div>
                </section>

                <section class="card sa-admin-quick-card">
                    <div class="card-header sa-admin-section-heading">
                        <div>
                            <span class="sa-admin-section-heading__eyebrow">AKSES CEPAT</span>
                            <h2>Kelola data</h2>
                        </div>
                    </div>
                    <div class="card-body sa-admin-quick-grid">
                        <a href="{{ route('admin.master-data.user.index') }}"><i class="isax-bold isax-people"></i><span>Master User</span></a>
                        <a href="{{ route('admin.master-data.jenis-izin.index') }}"><i class="isax-bold isax-folder-open"></i><span>Jenis Izin</span></a>
                        <a href="{{ route('admin.master-data.layanan-skm.index') }}"><i class="isax-bold isax-message-question"></i><span>Layanan SKM</span></a>
                        <a href="{{ route('admin.laporan.rekap-permohonan.index') }}"><i class="isax-bold isax-chart-2"></i><span>Laporan</span></a>
                    </div>
                </section>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('deployBtn').addEventListener('click', function() {
            if (!confirm('Apakah Anda yakin ingin memperbarui aplikasi? Proses ini akan mengambil kode terbaru dari repository.')) {
                return;
            }

            const btn = this;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>Memperbarui...';

            fetch('{{ route('admin.deploy') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success) {
                    location.reload();
                    return;
                }

                btn.disabled = false;
                btn.innerHTML = '<i class="isax-bold isax-refresh-2"></i>Update Aplikasi';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memperbarui aplikasi');
                btn.disabled = false;
                btn.innerHTML = '<i class="isax-bold isax-refresh-2"></i>Update Aplikasi';
            });
        });
    </script>
@endpush
