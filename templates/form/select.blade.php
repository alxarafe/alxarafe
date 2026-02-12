<!-- Templates/common/form/select.blade.php -->
<div class="mb-3">
    @if(!empty($label))
        <label for="{!! $id = str_replace(['[',']','.'], '_', $name) !!}" class="form-label">{!! $label !!}</label>
    @else
        @php $id = str_replace(['[',']','.'], '_', $name); @endphp
    @endif
    
    @php
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

        @if($hasActions) <div style="flex: 1 1 auto; width: 1%; min-width: 0;"> @endif
        <select class="form-select {{ $class ?? '' }} @if($hasActions) rounded-0 @endif" name="{!! $name !!}" id="{!! $id !!}" 
                @if($readonly ?? false) disabled @endif 
                @if($required ?? false) required @endif
                style="width: 100%">
            @foreach($values as $option => $text)
                <option value="{!! $option !!}" @if((string)($value ?? '') === (string)$option) selected @endif>{!! $text !!}</option>
            @endforeach
        </select>
        @if($hasActions) </div> @endif

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
