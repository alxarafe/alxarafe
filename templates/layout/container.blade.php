<!-- Templates/common/layout/container.blade.php -->
{{--
USE:
    <x-layout.container :fluid="true" class="custom-container-class" style="padding: 1rem;">
        Contenido aquí...
    </x-layout.container>

@link: https://getbootstrap.com/docs/5.0/layout/containers/

Parameters:
    fluid is optional (default false)
    class is optional (default "container")
    id is optional
--}}

@props(['fluid' => false, 'class' => 'container', 'id' => null])

@php
    $finalClass = $class . ($fluid ? '-fluid' : '');
@endphp

<div {{ $id ? "id=$id" : '' }} {{ $attributes->merge(['class' => $finalClass]) }}>
    {{ $slot }}
</div>