<style lang="scss">
    .progress-bar-ticks {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
</style>

@props(["values" => [0, 20, 40, 60, 80, 100]])

<div {{ $attributes->merge(["class" => "progress-bar-ticks"]) }}>
    @foreach ($values as $tick)
        <span>{{ $tick }}</span>
    @endforeach
</div>
