@props(['name', 'label', 'value' => ''])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input type="datetime-local" name="{{ $name }}" id="{{ $name }}" 
           value="{{ $value ? date('Y-m-d\TH:i', strtotime($value)) : '' }}" 
           {{ $attributes->merge(['class' => 'form-control']) }}>
</div>
