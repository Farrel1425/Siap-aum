@extends('layouts.dashboard.dashboard-base')


@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row">
                <div class="col-12">
                    <h3>Dashboard</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-4 col-xxl-5 d-flex justify-content-center">
                                            <div class="border p-2">
                                                <i class="isax-bold isax-bag fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xxl-7 d-flex flex-column gap-2">
                                            <h5 class="font-extrabold mb-0">{{ number_format($total_permohonan) }}</h5>
                                            <h6 class="text-muted fw-normal">Usulan Masuk</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-md-4 col-xxl-5 d-flex justify-content-center">
                                            <div class="border p-2">
                                                <i class="isax-bold isax-tick-circle fs-1"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-xxl-7 d-flex flex-column gap-2">
                                            <h5 class="font-extrabold mb-0">{{ number_format($permohonan_selesai) }}</h5>
                                            <h6 class="text-muted fw-normal">Usulan Selesai</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title
                                             mb-0">Usulan Terbaru</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm"
                                           id="permohonan-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Jenis Permohonan</th>
                                                <th>Nomor Registrasi</th>
                                                <th>Tanggal Pengajuan</th>
                                                <th>Nama Pemohon</th>
                                                <th>Pengantar Permohonan</th>
                                                <th>Lampiran Teknis</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
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
        $(document).ready(function() {
            $('#permohonan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('verifikator.permohonan.table') }}',
                    data: function(d) {
                        d.search = $('#dt-search-0').val();
                        d.status = $('#status').val();
                        d.jenis_izin_id = $('#jenis_izin_id').val();
                    }
                },
                order: [
                    [3, 'desc']
                ],
                columns: [{
                        data: null,
                        name: 'index',
                        searchable: false,
                        orderable: false,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'nama_jenis_izin',
                        name: 'nama_jenis_izin',
                        orderable: false
                    },
                    {
                        data: 'nomor_registrasi',
                        name: 'nomor_registrasi',
                        orderable: false
                    },
                    {
                        data: 'waktu_pengajuan',
                        name: 'waktu_pengajuan'
                    },
                    {
                        data: 'nama_pemohon',
                        name: 'nama_pemohon',
                        orderable: false
                    },
                    {
                        data: 'surat_permohonan_rekomendasi',
                        name: 'surat_permohonan_rekomendasi',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data ?
                                `<span class='text-success'><i class='isax-bold isax-tick-circle'></i></span>` :
                                '-';
                        },
                        orderable: false
                    },
                    {
                        data: 'surat_rekomendasi',
                        name: 'surat_rekomendasi',
                        className: 'text-center',
                        render: function(data, type, row) {
                            return data ?
                                `<span class='text-success'><i class='isax-bold isax-tick-circle'></i></span>` :
                                '-';
                        },
                        orderable: false
                    },
                    {
                        data: 'status_badge',
                        name: 'status_badge',
                        className: 'text-center',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false
                    }
                ],
            });
        });
    </script>
@endpush
