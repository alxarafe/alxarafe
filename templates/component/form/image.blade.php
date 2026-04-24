@props(['src', 'label' => '', 'field' => null, 'class' => 'rounded', 'width' => null, 'height' => null])

<div {{ $attributes->merge(['class' => 'mb-3 text-center']) }}>
    <img src="{{ $src }}" 
         alt="{{ $label }}" 
         @if($field) id="{{ $field }}" @endif
         class="img-fluid {{ $class }}"
         @if($width) width="{{ $width }}" @endif
         @if($height) height="{{ $height }}" @endif
    >
</div>
