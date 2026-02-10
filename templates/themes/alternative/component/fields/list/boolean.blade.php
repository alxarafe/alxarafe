@php
    $val = isset($value) ? $value : 0;
    // Map generic value to boolean roughly
    $isTrue = ($val == 1 || $val === true || $val === 'true' || $val === 'on');
@endphp
<span class="badge {{ $isTrue ? 'bg-info' : 'bg-secondary' }}" style="background-color: var(--alt-primary) !important; color: #fff;">
    {{ $isTrue ? \Alxarafe\Lib\Trans::_('bool_true') : \Alxarafe\Lib\Trans::_('bool_false') }}
</span>
