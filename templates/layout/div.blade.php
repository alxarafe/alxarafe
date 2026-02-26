<!-- Templates/common/layout/container.blade.php -->
{{--
USE:
    <x-layout.div class="custom-container-class" style="padding: 1rem;">
        Contenido aquí...
    </x-layout.div>

@link: https://getbootstrap.com/docs/5.2/layout/containers/
@link: https://getbootstrap.com/docs/5.2/layout/grid/
@link: https://getbootstrap.com/docs/5.2/layout/columns/

Parameters:
    class is optional (default "container")
    id is optional
    any other attribute will be added to the div
--}}

@props(['class' => 'container', 'id' => null, 'fluid' => false])

@php
    if (isset($attributes) && is_array($attributes)) {
        $attributes = new \Illuminate\View\ComponentAttributeBag($attributes);
    }
    $finalClass = $class . ($fluid ? '-fluid' : '');
@endphp

<div {{ $id ? "id=$id" : '' }} {{ $attributes->merge(['class' => $finalClass]) }}>
    {{ $slot }}
</div>