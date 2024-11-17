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

@php
    use Alxarafe\Lib\Functions;

    $size = $size ?? 'col';
    $class = trim(($class ?? '') . ' ' . $size);

    $_attributes = Functions::htmlAttributes($attributes ?? []);
@endphp

<div class="{{ $class }}" {!! $_attributes !!}>
    {{ $slot }}
</div>