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

@php
    use Alxarafe\Lib\Functions;

    $class = $class ?? 'row';

    $_attributes = Functions::htmlAttributes($attributes ?? []);
@endphp

<div class="{{ $class }}" {!! $_attributes !!}>
    {{ $slot }}
</div>