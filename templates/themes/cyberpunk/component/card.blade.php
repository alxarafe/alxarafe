@php
    use Alxarafe\Lib\Functions;

    $title = $title ?? null;
    $image = $image ?? null;
    $footer = $footer ?? null;
    $class = $class ?? 'card';
    $class .= ' cyber-card bg-dark text-white border-0'; // Force custom classes

    $_attributes = Functions::htmlAttributes($attributes ?? []);
@endphp

<div class="{{ $class }} position-relative mb-4" {!! $_attributes !!}>
    <!-- Cyberpunk Decoration -->
    <div class="cyber-corner cyber-corner-tl"></div>
    <div class="cyber-corner cyber-corner-br"></div>
    
    @if($image)
        <img src="{{ $image }}" class="card-img-top filter-cyber" alt="{{ $title ?? 'Card image' }}">
    @endif
    
    <div class="card-body p-4">
        @if($title)
            <h4 class="card-title text-uppercase border-bottom border-secondary pb-2 mb-3">
                <span class="text-info">></span> {{ $title }}
            </h4>
        @endif
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="card-footer bg-transparent border-top border-secondary">
            <small class="text-muted font-monospace">{{ $footer }}</small>
        </div>
    @endif
</div>
