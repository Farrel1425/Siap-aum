
<style>
    footer {
        *  {
            color: #ffffff;
        }

        .info-container {
            background-color: #363B64;
            padding: 0 20px 12px 20px;

            h1 {
                font-size: 24px;
            }
        }

        .logo-container {
            width: fit-content;
            padding: 12px;
            background-color: #ffffff;
            border-radius: 0 0 14px 14px;
        }

        .img-logo {
            height: 30px;
        }

        .copyright-container {
            background-color: #AA0000;
            padding: 20px
        }

        @media (min-width: 769px) {
            position: relative;
            margin-bottom: 0;
            margin-top: 140px;

            .info-container {
                position: absolute;
                top: -130px;
                left: 10px;
                right: 10px;
                max-width: 1000px;
                margin: auto;
                border-radius: 30px;
            }

            .copyright-container {
                height: 160px;
            }
        }
    }
</style>

<footer>
    <div class="info-container d-flex flex-column align-items-center gap-2  ">
        <div class="logo-container d-flex align-items-center gap-1">
            <img alt=""
                 class="img-logo"
                 src="{{ asset('assets/images/logo-kabupaten.png') }}">
            <img alt=""
                 class="img-logo"
                 src="{{ asset('assets/images/logo-siajaib.png') }}">
        </div>
        <h5 class="text-center">Dinas Penanaman Modal dan Pelayanan<br/>Terpadu Satu Pintu Pemerintah Kabupaten Buleleng</h5>
        <div class="d-flex align-items-center gap-1">
            <i class="isax isax-location"></i>
            <span>Lantai III Pasar Banyuasri, Kelurahan Banyuasri, Kecamatan Buleleng</span>
        </div>
        <div class="d-flex align-items-center gap-1">
            <i class="isax isax-call"></i>
            <span>(0362) 22063</span>
        </div>
        <div class="d-flex align-items-center gap-1">
            <i class="isax isax-sms"></i>
            <span>dpmptsp@bulelengkab.go.id</span>
        </div>
    </div>
    <div class="copyright-container d-flex justify-content-center align-items-end">
        <small class="text-center">© 2024 DPMPTSP Kabupaten Buleleng <span class="font-bold">Design & Develop by Maiharta</span></small>
    </div>
</footer>
