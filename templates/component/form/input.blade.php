@props(['name', 'label' => null, 'type' => 'text', 'value' => '', 'placeholder' => null, 'hideLabel' => false])

<div {{ $attributes->only('class')->merge(['class' => $hideLabel ? '' : 'mb-3']) }}>
    @if($label && !$hideLabel)
        <label for="{{ $attributes->get('id', $name) }}" class="form-label">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $attributes->get('id', $name) }}" 
           value="{{ $value }}" placeholder="{{ $placeholder ?? $label }}" 
           {{ $attributes->whereDoesntStartWith('class')->class(['form-control']) }}>
</div>
