<!-- Templates/common/component/button.blade.php -->
{{--
USE:
    @include('component.button', ['type' => 'submit', 'class' => 'success', 'spacing' => 'mx-1', 'name' => 'action', 'value' => 'save', 'slot' => 'Save the record', 'attributes' => ['disabled']])

@link: https://getbootstrap.com/docs/5.0/components/buttons/

Parameters:
    type is optional (default "button")
    class is optional (default "primary")
    spacing is optional (default none)
    name and value are optional
    slot is optional (default value or "Button")
    attributes is optional
--}}

@php
    $type = $type ?? 'button';
    $class = $class ?? 'primary';
    $slot = $slot ?? $value ?? 'Button';
    if (isset($spacing)) {
        $class .= ' ' . $spacing;
    }

    $_type = "type={$type}";
    $_class = "class=\"btn btn-{$class}\"";

    $_name = isset($name) ? "name=\"{$name}\"" : '';
    $_value = isset($value) ? "value=\"{$value}\"" : '';

    $_attributes = is_array($attributes ?? null) ? implode(' ', $attributes) : '';
@endphp

<button {!! $_type !!} {!! $_class !!} {!! $_name !!} {!! $_value !!} {!! $_attributes !!}>
    {!! $slot !!}
</button>