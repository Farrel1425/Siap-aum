<style lang="scss">
    .progress-bar {
        position: relative;
        background-color: #f3f4f6;
        height: 1.5rem;
        width: 100%;
    }

    .progress-bar-fill {
        background-color: #AA0000;
        height: 100%;
        transition: width 0.3s ease;
    }

    .progress-bar-label {
        position: absolute;
        left: 10px;
        color: #fff;
        font-weight: bold;
        white-space: nowrap;
    }
</style>

@props(["value" => 0, "label" => ""])

<div {{ $attributes->merge(["class" => "progress-bar"]) }}>
    <div class="progress-bar-fill" style="width: {{ ($value / 100) * 100 }}%;"></div>
    <div class="progress-bar-label">{{ $label }}</div>
</div>
