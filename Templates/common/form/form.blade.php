<!-- Templates/common/form/form.blade.php -->
{{--
USE:
    @component('Templates.common.form.form', [
        'method' => 'POST',
        'action' => route('your.route'),
        'class' => 'custom-form-class',
        'attributes' => ['id' => 'your-form-id']
    ])
        @slot('slot')
            <!--
                Add the form content here.
                You can add inputs, textareas, etc.
            -->
        @endslot
    @endcomponent

Parameters:
    method is required (HTTP method like 'POST', 'GET', etc.)
    action is required (URL where the form submits to)
    class is optional (additional classes for the form)
    attributes is optional (additional HTML attributes for the form)
--}}

@php
    use Alxarafe\Lib\Functions;

    $method = $method ?? 'POST';
    $action = $action ?? '#';
    $class = $class ?? 'form';

    $_attributes = Functions::htmlAttributes($attributes ?? []);
@endphp

<form method="{{ strtoupper($method) }}" action="{{ $action }}" class="{{ $class }}" {!! $_attributes !!}>
    {{ $slot }}
</form>
