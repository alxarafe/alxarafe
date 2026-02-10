@php
    $field = $field ?? '';
    $label = $label ?? '';
    // Handle value:
    // 1. From explicit $value variable
    // 2. From old input (validation error) - though ResourceController usually handles data prep.
    // 3. From model/data array?
    // Let's assume $value is passed correctly.
    // Ensure value is cast to int for comparison if needed, though '1' == 1 works.
    $val = isset($value) ? $value : 0;
    
    // Check if it's required
    $required = isset($required) && $required ? 'required' : '';
    $readonly = isset($readonly) && $readonly ? 'disabled' : '';
@endphp

<div class="mb-3">
    <label for="{{ $field }}" class="form-label">{{ $label }}</label>
    <select class="form-select pastel-select" id="{{ $field }}" name="{{ $field }}" {{ $required }} {{ $readonly }}>
        <option value="1" {{ $val == 1 ? 'selected' : '' }}>{{ \Alxarafe\Lib\Trans::_('bool_true') }}</option>
        <option value="0" {{ $val == 0 ? 'selected' : '' }}>{{ \Alxarafe\Lib\Trans::_('bool_false') }}</option>
    </select>
</div>
