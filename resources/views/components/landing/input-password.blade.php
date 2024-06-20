@props([
    'name' => '',
    'label' => '',
    'placeholder' => '',
])

<div class="form-group mb-3">
    <div class="input-group">
        <input
               aria-describedby="basic-addon1"
               class="form-control"
               id="{{ $name }}"
               name="{{ $name }}"
               placeholder="{{ $placeholder }}"
               type="password">
        <button class="btn btn-toggle-password isax isax-eye-slash border"
                id="button-addon2"
                type="button"></button>
    </div>
</div>
