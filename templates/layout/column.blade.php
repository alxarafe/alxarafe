<!-- Templates/common/layout/column.blade.php -->
{{--
USE:
    @include('Templates.common.layout.column', [
        'size' => 'col-md-6',
        'class' => 'custom-column-class',
        'attributes' => ['style' => 'background-color: #f8f9fa;']
    ])
    @slot('content')
        <!-- Aquí va el contenido de la columna -->
    @endslot

Parameters:
    size is optional (default "col")
    class is optional (additional classes for the column)
    attributes is optional (additional HTML attributes for the column)
--}}

@props([
    'size' => 'col',
    'class' => ''
])

@php
    if (isset($attributes) && is_array($attributes)) {
        $attributes = new \Illuminate\View\ComponentAttributeBag($attributes);
    }
@endphp

<div {{ $attributes->merge(['class' => trim($class . ' ' . $size)]) }}>
    {{ $slot }}
</div>