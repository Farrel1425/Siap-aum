@extends('layouts.dashboard.dashboard-base')


@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row">
                <div class="col-12 col-md-6">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-end align-items-center">
                    <button type="button" class="btn btn-primary" id="deployBtn">
                        <i class="isax-bold isax-refresh-2 me-2"></i>Update Aplikasi
                    </button>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-4 col-md-4">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-4 col-xxl-5 d-flex justify-content-center">
                                            <div class="border p-2">
                                                <i class="isax-bold isax-bag fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xxl-7 d-flex flex-column gap-2">
                                            <h5 class="font-extrabold mb-0">{{ number_format($total_permohonan, 0, ',', '.') }}</h5>
                                            <h6 class="text-muted fw-normal">Usulan Masuk</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-4 col-xxl-5 d-flex justify-content-center">
                                            <div class="border p-2">
                                                <i class="isax-bold isax-setting-2 fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xxl-7 d-flex flex-column gap-2">
                                            <h5 class="font-extrabold mb-0">{{ number_format($permohonan_diproses, 0, ',', '.') }}</h5>
                                            <h6 class="text-muted fw-normal">Usulan Diproses</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-4 col-xxl-5 d-flex justify-content-center">
                                            <div class="border p-2">
                                                <i class="isax-bold isax-tick-circle fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xxl-7 d-flex flex-column gap-2">
                                            <h5 class="font-extrabold mb-0">{{ number_format($permohonan_selesai, 0, ',', '.') }}</h5>
                                            <h6 class="text-muted fw-normal">Usulan Selesai</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memperbarui...';

            fetch('{{ route("admin.deploy") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                    location.reload();
                } else {
                    alert('❌ ' + data.message);
                    btn.disabled = false;
                    btn.innerHTML = '<i class="isax-bold isax-refresh-2 me-2"></i>Update Aplikasi';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan saat memperbarui aplikasi');
                btn.disabled = false;
                btn.innerHTML = '<i class="isax-bold isax-refresh-2 me-2"></i>Update Aplikasi';
            });
        });
    </script>
@endpush
