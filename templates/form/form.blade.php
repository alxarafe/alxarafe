<!-- Templates/common/form/form.blade.php -->
{{--
USE:
    <x-form.form method="POST" :action="route('your.route')" class="custom-form-class" id="your-form-id">
        Contenido aquí...
    </x-form.form>

Parameters:
    method is optional (default 'POST')
    action is optional (default '#')
    class is optional (default 'form')
--}}

@props(['method' => 'POST', 'action' => '#', 'class' => 'form'])

<form method="{{ strtoupper($method) }}" action="{{ $action }}" {{ $attributes->merge(['class' => $class]) }}>
    {{ $slot }}
</form>
