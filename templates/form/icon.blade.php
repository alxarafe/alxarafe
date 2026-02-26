@props([
    'name' => $name ?? '',
    'label' => '',
    'value' => '',
    'help' => '',
    'actions' => []
])

<div class="mb-3">
    @if($label)
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    @endif
    
    <div class="input-group">
        <span class="input-group-text bg-light">
            <i id="preview-{{ $name }}" class="{{ $value ?: 'fas fa-question' }}"></i>
        </span>
        <input type="text" name="{{ $name }}" id="{{ $name }}"
               class="form-control" placeholder="fas fa-star" value="{{ $value }}"
               oninput="document.getElementById('preview-{{ $name }}').className = this.value || 'fas fa-question'"
               {{ $attributes }}>
        
        @foreach($actions as $action)
            <button class="btn {{ $action['class'] ?? 'btn-outline-secondary' }}" 
                    type="button" 
                    onclick="{!! $action['onclick'] !!}" 
                    title="{{ $action['title'] ?? '' }}">
                <i class="{{ $action['icon'] }}"></i>
            </button>
        @endforeach
    </div>

    @if($help)
        <div class="form-text">{{ $help }}</div>
    @endif
</div>
