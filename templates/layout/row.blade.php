<!-- Templates/common/layout/row.blade.php -->
{{--
USE:
    @include('Templates.common.layout.row', [
        'class' => 'custom-row-class',
        'attributes' => ['style' => 'margin-bottom: 1rem;']
    ])
    @slot('content')
        <!-- Aquí van las columnas -->
    @endslot

Parameters:
    class is optional (default "row")
    attributes is optional (additional HTML attributes for the row)
--}}

@props([
    'class' => 'row'
])
@php
    if (isset($attributes) && is_array($attributes)) {
        $attributes = new \Illuminate\View\ComponentAttributeBag($attributes);
    }
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</div>