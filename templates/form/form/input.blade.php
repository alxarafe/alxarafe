@props([
    'type' => 'text',
    'name',
    'label' => '',
    'value' => '',
    'help' => '',
    'actions' => []
])

@php
    $leftActions = array_filter($actions, fn($act) => ($act['position'] ?? 'left') === 'left');
    $rightActions = array_filter($actions, fn($act) => ($act['position'] ?? 'left') === 'right');
    $hasActions = count($actions) > 0;
@endphp

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
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

        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
               placeholder="{{ $label }}" value="{{ $value }}"
               {{ $attributes->merge(['class' => 'form-control']) }}>

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
