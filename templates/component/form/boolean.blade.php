@props(['name', 'label', 'value' => false])

<div class="mb-3">
    <div class="form-check form-switch">
        <input type="hidden" name="{{ $name }}" value="0">
        <input class="form-check-input" type="checkbox" name="{{ $name }}" id="{{ $name }}" value="1" @checked($value) {{ $attributes }}>
        <label class="form-check-label fw-bold" for="{{ $name }}">{{ $label }}</label>
    </div>
</div>
