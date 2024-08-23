<style>
    section {
        &.hero {

            .image-main-mobile {
                height: 300px;
                object-fit: cover;
            }
        }

        .content {
            max-width: 600px;
        }
    }

    @media (min-width: 992px) {
        section {
            &.hero {
                min-height: 100vh;
                overflow-x: hidden;
                background-image: url("http://localhost:8000/assets/images/main-bg.svg");
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
            }

            .content {
                max-width: 340px;
            }

            .back-button {
                position: absolute;
                top: 50%;
                transform: translateY(-50%);
            }
        }

    }

    @media (min-width: 1200px) {
        section {
            .content {
                max-width: 460px;
            }
        }

    }
</style>

@props([
    'showBackButton' => false,
    'backButtonLabel' => null,
])

<section class="position-relative hero row g-0">
    <img src="{{ asset('assets/images/main-bg-mobile.svg') }}" alt="" class="image-main-mobile d-lg-none w-100">
    @if ($showBackButton)
        <x-landing.back-button class="back-button m-4" />
    @endif
    <div class="col-lg-6 p-4 my-auto my-lg-0">
        <div class="h-100 content mx-auto">
            {{ $slot }}
        </div>
    </div>
</section>
