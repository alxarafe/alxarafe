<!-- Templates/common/form/select.blade.php -->
    <div class="form-group">
        <label for="{!! $id = str_replace(['[',']','.'], '_', $name) !!}" class="form-label">{!! $label !!}</label>
        <select class="form-select form-control" name="{!! $name !!}" id="{!! $id !!}">
            @foreach($values as $option => $text)
                <option value="{!! $option !!}" @if($value === $option) selected @endif>{!! $text !!}</option>
            @endforeach
        </select>
    </div>
