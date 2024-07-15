<div class="form-check">
    <input type="hidden" name="{!! $name !!}" value="0">
    <input class="form-check-input" type="checkbox" name="{!! $name !!}" value="1" id="{!! $name !!}" @if($value) checked @endif>
    <label class="form-check-label" for="flexCheckChecked">
        {!! $label !!}
    </label>
</div>