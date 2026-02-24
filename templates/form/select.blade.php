@props([
    'name',
    'label' => '',
    'value' => '',
    'values' => [],
    'help' => '',
    'actions' => [],
    'class' => '',
    'readonly' => false,
    'required' => false
])

@php
    $id = str_replace(['[',']','.'], '_', $name);
    $leftActions = array_filter($actions, fn($act) => ($act['position'] ?? 'left') === 'left');
    $rightActions = array_filter($actions, fn($act) => ($act['position'] ?? 'left') === 'right');
    $hasActions = count($actions) > 0;
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    @endif
    
    <div @class(['input-group' => $hasActions])>
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
        <select name="{{ $name }}" id="{{ $id }}" 
                @disabled($readonly) 
                @required($required)
                {{ $attributes->merge(['class' => 'form-select ' . $class . ($hasActions ? ' rounded-0' : '')]) }}
                style="width: 100%">
            @foreach($values as $option => $text)
                <option value="{{ $option }}" @selected((string)$value === (string)$option)>{{ $text }}</option>
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
    </div>

    @if($help)
        <div class="form-text">{{ $help }}</div>
    @endif
</div>
