@props([
    'field' => '',
    'label' => '',
    'value' => 0,
    'required' => false,
    'readonly' => false
])

<div {{ $attributes->merge(['class' => 'mb-3']) }}>
    <label for="{{ $field }}" class="form-label">{{ $label }}</label>
    <select class="form-select pastel-select" id="{{ $field }}" name="{{ $field }}" @required($required) @disabled($readonly)>
        <option value="1" @selected($value == 1)>{{ \Alxarafe\Lib\Trans::_('bool_true') }}</option>
        <option value="0" @selected($value == 0)>{{ \Alxarafe\Lib\Trans::_('bool_false') }}</option>
    </select>
</div>
