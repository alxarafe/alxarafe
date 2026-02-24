@props(['label', 'field' => null, 'class' => ''])

<div {{ $attributes->merge(['class' => "mb-3 $class"]) }} @if($field) id="{{ $field }}" @endif>
    {!! $label !!}
</div>
