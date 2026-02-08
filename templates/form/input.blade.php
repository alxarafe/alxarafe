<!-- Templates/common/form/input.blade.php -->
@php
    use Alxarafe\Lib\Functions;
    $_attributes = Functions::htmlAttributes($attributes ?? []);
@endphp
<div class="form-group">
    <label for="{!! $name !!}" class="form-label">{!! $label !!}</label>
    <input type="{!! $type !!}" name="{!! $name !!}" class="form-control" id="{!! $name !!}"
           placeholder="{!! $label !!}" value="{!! $value ?? '' !!}" {!! $_attributes !!}>
</div>
