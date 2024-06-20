@extends('layouts.dashboard.dashborad-base')


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
                <div class="col-12 col-lg-8">
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
                                            <h5 class="font-extrabold mb-0">112.000</h5>
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
                                            <h5 class="font-extrabold mb-0">112.000</h5>
                                            <h6 class="text-muted fw-normal">Usulan Masuk</h6>
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
                                            <h5 class="font-extrabold mb-0">112.000</h5>
                                            <h6 class="text-muted fw-normal">Usulan Masuk</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="d-inline">Histori Aktivitas</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush
