@extends('layouts.landing.main-base')

<style>
    .container-user-guide {
        max-width: 240px;
        margin: 3rem auto;

        .user-guide-item {
            &:nth-child(odd)::after {
                content: "";
                height: 80px;
                display: block;
                background-image: url("http://localhost:8000/assets/images/arrow-bottom-right.svg");
                background-position: right;
                /* background-size: contain; */
                background-repeat: no-repeat;
            }

            &:nth-child(even)::before {
                content: "";
                height: 80px;
                display: block;
                background-image: url("http://localhost:8000/assets/images/arrow-bottom-left.svg");
                background-position: left;
                /* background-size: contain; */
                background-repeat: no-repeat;
            }

            &:nth-child(2)::before {
                background-image: none;
            }
        }

        .guide-info {
            border: 1px solid black;
            height: 268px;
            background-color: #ffffff;
            border-radius: 0.5rem;
            padding: 0.5rem;
            font-size: 0,75rem;
            font-weight: 700;

            p {
                margin-top: 0.5rem;
            }
        }
    }


    @media (min-width: 768px) {
        .container-user-guide {
            max-width: 720px;

            .user-guide-item {
                &:nth-child(odd)::after {
                    background-image: url("http://localhost:8000/assets/images/arrow-bottom-right.svg");
                    background-position: right;
                }

                &:nth-child(even)::before {
                    background-image: url("http://localhost:8000/assets/images/arrow-top-right.svg");
                    background-position: right;
                }

                &:last-child::before {
                    background-image: none;
                }
            }
        }
    }
</style>

@section('content')
    <x-landing.back-button label="Panduan Pengajuan" class="py-2 px-4" />
    <div class="container-user-guide">
        <div class="row g-2">
            <div class="user-guide-item col-6 col-md-2">
                <div class="guide-info">
                    <img alt=""
                    class="w-100"
                    src="{{ asset('assets/images/user-guide-1.svg') }}">
                    <p>Daftarkan akun anda untuk mengkases halaman permohonan</p>
                </div>
            </div>
            <div class="user-guide-item col-6 col-md-2">
                <div class="guide-info">
                    <img alt=""
                    class="w-100"
                    src="{{ asset('assets/images/user-guide-2.svg') }}">
                    <p>Masuklah ke akun anda untuk memulai permohonan</p>
                </div>
            </div>
            <div class="user-guide-item col-6 col-md-2">
                <div class="guide-info">
                    <img alt=""
                    class="w-100"
                    src="{{ asset('assets/images/user-guide-3.svg') }}">
                    <p>Buka tombol tambah untuk membuat pengajuan</p>
                </div>
            </div>
            <div class="user-guide-item col-6 col-md-2">
                <div class="guide-info">
                    <img alt=""
                    class="w-100"
                    src="{{ asset('assets/images/user-guide-4.svg') }}">
                    <p>Pilihlah jenis pengajuan yang ingin anda buat</p>
                </div>
            </div>
            <div class="user-guide-item col-6 col-md-2">
                <div class="guide-info">
                    <img alt=""
                    class="w-100"
                    src="{{ asset('assets/images/user-guide-5.svg') }}">
                    <p>Isilah Form yang telah disediakan dengan seksama</p>
                </div>
            </div>
            <div class="user-guide-item col-6 col-md-2">
                <div class="guide-info">
                    <img alt=""
                    class="w-100"
                    src="{{ asset('assets/images/user-guide-6.svg') }}">
                    <p>Tunggulah sampai pengajuan anda disetujui</p>
                </div>
            </div>
        </div>
    </div>
@endsection
