<style lang="scss">
    .back-button-container {
        display: flex;
        align-items: center;
        gap: 1rem;

        .back-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #AA0000;
            color: #fff;

            i {
                color: #fff
            }
        }

        .label {
            font-size: 24px;
            font-weight: 700;
            color: #AA0000;
        }
    }

    @media (min-width: 768px) {
        .back-button-container {
            .back-button {
                width: 38px;
                height: 38px;

                i {
                    font-size: 24px;
                }
            }

            .label {
                font-size: 32px;
                font-weight: 700;
            }
        }
    }
</style>

@props(['label' => null])

<div {{ $attributes->merge(['class' => 'back-button-container']) }}>
    <a href="{{ url()->previous() }}" class="back-button">
        <i class="isax-bold isax-arrow-left"></i>
    </a>
    @if($label)
        <span class="label">{{ $label }}</span>
    @endif
</div>
