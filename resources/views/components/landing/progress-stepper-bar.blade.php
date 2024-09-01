<style lang="scss">
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        color: #000;
        text-align: center;
        overflow-x: auto;
        padding: 15px 0;

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
                &::before {
                    position: absolute;
                    content: "";
                    border-bottom: 2px solid #AA0000;
                    width: 100%;
                    top: 20px;
                    left: -50%;
                    z-index: 3;
                }

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
])

<div class="stepper-wrapper">
    @foreach ($steps as $key => $step)
        <div class="stepper-item {{ $step->get('is_done') ? 'completed fw-bold' : '' }}">
            <div class="step-counter {{ $step->get('is_done')?  'bg-primary text-white' : '' }}">{{ $loop->iteration }}
            </div>
            <div class="step-name">{{ $step->get('nama') }}</div>
            <p class="text-xsm text-center fw-normal">{{ $step->get('done_at') }}</p>
        </div>
    @endforeach
</div>
