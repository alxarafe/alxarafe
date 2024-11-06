<!-- Templates/common/layout/container.blade.php -->
{{--
USE:
    @component('layout.div', [
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

@link: https://getbootstrap.com/docs/5.2/layout/containers/
@link: https://getbootstrap.com/docs/5.2/layout/grid/
@link: https://getbootstrap.com/docs/5.2/layout/columns/

Parameters:
    class is optional (default "container")
    attributes is optional (additional HTML attributes for the container)
--}}

@php
    use Alxarafe\Lib\Functions;

    $_class = $class ?? 'container';
    $_attributes = Functions::htmlAttributes($attributes ?? []);

    $_id = '';
    if (isset($id)) {
        $_id = "id=\"$id\"";
    }

@endphp

<div {{ $_id }} class="{{ $_class }}" {!! $_attributes !!}>
    {{ $slot }}
</div>