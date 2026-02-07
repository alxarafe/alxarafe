<!-- Templates/common/layout/container.blade.php -->
{{--
USE:
    @component('layout.container', [
        'fluid' => true,
        'class' => 'custom-container-class',
        'attributes' => ['style' => 'padding: 1rem;']
    ])
        @slot('slot')
            <!--
                Add the slot content here.
                You can add other components (containers, cards, inputs, etc.)
            -->
        @endslot
    @endcomponent

@link: https://getbootstrap.com/docs/5.0/layout/containers/

Parameters:
    fluid is optional (default false)
    class is optional (default "container" or "container-fluid" if fluid is true)
    attributes is optional (additional HTML attributes for the container)
--}}

@php
    use Alxarafe\Lib\Functions;

    $_class = $class ?? 'container';
    if ($fluid ?? false) {
        $_class .= '-fluid';
    }
    $_attributes = Functions::htmlAttributes($attributes ?? []);

    $_id = '';
    if (isset($id)) {
        $_id = "id=\"$id\"";
    }

@endphp

<div {{ $_id }} class="{{ $_class }}" {!! $_attributes !!}>
    {{ $slot }}
</div>