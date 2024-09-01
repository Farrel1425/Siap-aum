@extends('layouts.dashboard.dashboard-base')


@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row align-items-center g-2">
                <div class="col-12 col-lg-auto gap-0 order-md-1">
                    <h3 class="d-inline mb-0">Dashboard</h3>
                </div>
                <div class="col-12 col-lg-auto order-md-1">
                    <button class="btn btn-primary d-block w-100 w-lg-auto"><i class="isax isax-element-plus"></i> Pengajuan
                        Baru</button>
                </div>
                <div class="col-12 col-lg-auto gap-0 order-md-1">
                    <button class="btn btn-outline-primary d-block w-100 w-lg-auto fw-bold"><i
                           class="isax isax-document-download"></i> Download
                        Contoh Berkas</button>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm"
                               id="permohonan-table">
                            <thead>
                                <tr>
                                    <th class="d-none">Permohonan</th>
                                    <th class="d-none">Step</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $('#permohonan-table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('public.permohonan.table') }}',
                data: function(d) {
                    d.search = $('#dt-search-0').val();
                }
            },
            columns: [{
                data: 'id',
                name: 'id',
                orderable: false,
                className: 'd-flex align-items-center justify-content-center',
                render: function(data, type, row, meta) {
                    return `
                        <div class="d-flex">
                            <div class="flex-grow-1 ms-3">
                                <a href="${row.url}" class="text-decoration-none text-dark">
                                    <h4 class="mb-2">${row.nama_jenis_izin}</h4>
                                </a>
                                <p class="text-xsm text-primary fw-bold mb-0">${row.nomor_registrasi}</p>
                                <p class="text-xsm text-muted mb-0">Tanggal Masuk: ${row.tanggal_masuk}</p>
                                <p class="text-xsm text-muted mb-0">${row.status_badge}</p>
                            </div>
                        </div>
                    `;
                }
            }, {
                data: 'nama',
                name: 'nama',
                className: 'text-start',
                orderable: false,
                render: function(data, type, row, meta) {
                    let steps = row.steps;
                    let html = '';
                    steps.forEach((step, index) => {
                        html += `
                                <div class="stepper-item ${step.is_done ? 'completed fw-bold' : ''}">
                                    <div class="step-counter ${step.is_done ? 'bg-primary text-white' : ''}">${index + 1}</div>
                                    <div class="step-name">${step.nama}</div>
                                    <p class="text-xsm text-center fw-normal">${step.done_at}</p>
                                </div>
                            `;
                    });
                    // stepper-wrapper
                    html = `<a href="${row.url}"><div class="stepper-wrapper">${html}</div></a>`;
                    return html;
                }
            }],
            // per page
            lengthMenu: [
                [5, 10, 25, 50, 100, 250, 500, -1],
                [5, 10, 25, 50, 100, 250, 500, 'All']
            ],
            // default per page
            pageLength: 5,
        });
    </script>
@endpush
