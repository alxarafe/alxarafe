@props(['name', 'label', 'value' => '', 'rows' => 3])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}" {{ $attributes->merge(['class' => 'form-control']) }}>{{ $value }}</textarea>
</div>
