<!-- Templates/common/form/select.blade.php -->
<div class="form-group">
    <label for="{!! $name !!}" class="form-label">{!! $label !!}</label>
    <select class="form-select" name="{!! $name !!}" class="form-control" id="{!! $name !!}">
        @foreach($values as $option => $text)
            <option value="{!! $option !!}" @if($value === $option) selected @endif>{!! $text !!}</option>
        @endforeach
    </select>
</div>
