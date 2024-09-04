@extends('layouts.dashboard.dashboard-base')

@section('content')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row align-items-center g-2">
                <div class="col-12 col-lg-auto gap-0 order-md-1">
                    <h3 class="d-inline mb-0">
                        <a class="text-color-heading fs-4"
                           href="{{ route('public.permohonan.create') }}">
                            <i class="isax-bold isax-arrow-circle-left"></i>
                        </a> {{ $permohonan->jenisIzin->nama }}
                    </h3>
                </div>
            </div>
        </div>
        <section class="section">
            <form action="{{ route('public.permohonan.submit-berkas', $permohonan->id) }}"
                  method="POST">
                @csrf
                <h5 class="mt-4">Upload Berkas Permohonan</h5>
                @foreach ($permohonan->berkasPermohonan as $berkasPermohonan)
                    <x-dashboard.input-inline-file-upload class="bg-white p-2 mx-1 mb-3 text-xsm"
                                                   class_input="text-xsm"
                                                   label="{{ $berkasPermohonan->nama }}"
                                                   name="{{ $berkasPermohonan->id }}"
                                                   uploadUrl="{{ route('public.permohonan.store-berkas', $permohonan->id) }}"
                                                   downloadUrl="{{ $berkasPermohonan->filepath ? Storage::url($berkasPermohonan->filepath) : '' }}"
                                                   :required="$berkasPermohonan->is_required" />
                @endforeach
                <button class="btn btn-primary bg-primary mt-3 w-100 d-block"
                        type="submit" {{ !$is_all_uploaded? 'disabled' : '' }}>Simpan dan Ajukan Permohonan</button>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush
