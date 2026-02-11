<div class="form-group">
    <label for="{!! $name !!}">{!! $label !!}</label>
    <select name="{!! $name !!}" id="{!! $name !!}" class="form-select">
        <option value="1" @if($value) selected @endif>{!! $me->_('boolean_true') !!}</option>
        <option value="0" @if(!$value) selected @endif>{!! $me->_('boolean_false') !!}</option>
    </select>
</div>
