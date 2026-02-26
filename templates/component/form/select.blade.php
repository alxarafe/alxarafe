@props(['name', 'label', 'options' => [], 'value' => ''])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => 'form-select']) }}>
        @foreach($options as $val => $text)
            <option value="{{ $val }}" @selected($value == $val)>{{ $text }}</option>
        @endforeach
    </select>
</div>
