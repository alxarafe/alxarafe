<!-- Templates/common/form/input.blade.php -->
@php
    use Alxarafe\Lib\Functions;
    $_attributes = Functions::htmlAttributes($attributes ?? []);
    
    // Extract actions from options if passed (though check if they are passed as variables)
    // In blade include, they come as $actions if set in viewData.
    $hasActions = !empty($actions);
    $leftActions = []; 
    $rightActions = [];
    if($hasActions) {
        foreach($actions as $act) {
            if(($act['position'] ?? 'left') === 'right') $rightActions[] = $act;
            else $leftActions[] = $act;
        }
    }
@endphp

<div class="mb-3">
    @if(!empty($label))
        <label for="{!! $name !!}" class="form-label">{!! $label !!}</label>
    @endif
    
    @if($hasActions) <div class="input-group"> @endif

        @foreach($leftActions as $action)
            <button class="btn {{ $action['class'] ?? 'btn-outline-secondary' }}" 
                    type="button" 
                    onclick="{!! $action['onclick'] !!}" 
                    title="{{ $action['title'] ?? '' }}" 
                    @if(!empty($action['title'])) data-bs-toggle="tooltip" @endif>
                <i class="{{ $action['icon'] }}"></i>
            </button>
        @endforeach

        <input type="{!! $type ?? 'text' !!}" name="{!! $name !!}" class="form-control" id="{!! $name !!}"
               placeholder="{!! $label ?? '' !!}" value="{!! $value ?? '' !!}" {!! $_attributes !!}>

        @foreach($rightActions as $action)
            <button class="btn {{ $action['class'] ?? 'btn-outline-secondary' }}" 
                    type="button" 
                    onclick="{!! $action['onclick'] !!}" 
                    title="{{ $action['title'] ?? '' }}" 
                    @if(!empty($action['title'])) data-bs-toggle="tooltip" @endif>
                <i class="{{ $action['icon'] }}"></i>
            </button>
        @endforeach

    @if($hasActions) </div> @endif

    @if(!empty($help))
        <div class="form-text">{{ $help }}</div>
    @endif
</div>
