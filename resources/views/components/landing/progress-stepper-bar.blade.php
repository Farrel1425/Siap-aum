<style lang="scss">
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        font-weight: bold;
        color: #000;
        text-align: center;

        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;

            &::before {
                position: absolute;
                content: "";
                border-bottom: 2px dashed #ccc;
                width: 100%;
                top: 20px;
                left: -50%;
                z-index: 2;
            }

            &::after {
                position: absolute;
                content: "";
                border-bottom: 2px dashed #ccc;
                width: 100%;
                top: 20px;
                left: 50%;
                z-index: 2;
            }

            .step-counter {
                position: relative;
                z-index: 5;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #fff;
                border: 2px solid #ccc;
                margin-bottom: 6px;
            }

            &.active {
                color: #AA0000;

                .step-counter {
                    border-color: #AA0000;
                }
            }

            &.completed {
                color: #AA0000;

                .step-counter {
                    border-color: #AA0000;
                }

                &::after {
                    position: absolute;
                    content: "";
                    border-bottom: 2px solid #AA0000;
                    width: 100%;
                    top: 20px;
                    left: 50%;
                    z-index: 3;
                }
            }

            &:first-child::before {
                content: none;
            }

            &:last-child::after {
                content: none;
            }
        }
    }
</style>

@props([
    'steps' => [],
    'currentStep' => 0,
])

<div class="stepper-wrapper">
    @foreach ($steps as $index => $step)
        <div class="stepper-item {{ $currentStep > $index ? 'completed' : ($currentStep == $index ? 'active' : '') }}">
            <div class="step-counter">{{ $index + 1 }}</div>
            <div class="step-name">{{ $step }}</div>
        </div>
    @endforeach
</div>
