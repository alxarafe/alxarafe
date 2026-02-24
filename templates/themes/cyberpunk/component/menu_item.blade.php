@props([
    'url' => '#',
    'icon' => 'fas fa-circle',
    'label' => '',
    'title' => null,
    'active' => false,
    'colorClass' => 'text-info',
    'badge' => null,
    'iconSize' => 'fa-2x',
    'containerClass' => ''
])

@php
    $title = $title ?? $label;
@endphp

<div {{ $attributes->merge(['class' => 'cyber-retro-container mb-4 ' . ($active ? 'active' : '') . ' ' . $containerClass]) }}>
    <a href="{{ $url }}" class="cyber-retro-button {{ $active ? 'active' : '' }}" title="{{ $title }}">
        <div class="cyber-button-inner">
            <i class="cyber-retro-icon {{ $icon }} {{ $iconSize }} {{ $colorClass }}"></i>
            @if($badge)
                <span class="cyber-retro-badge">{{ $badge }}</span>
            @endif
        </div>
        <!-- Decorative bits to simulate arcade/console buttons -->
        <span class="cyber-pixel pixel-tl"></span>
        <span class="cyber-pixel pixel-tr"></span>
        <span class="cyber-pixel pixel-bl"></span>
        <span class="cyber-pixel pixel-br"></span>
    </a>
</div>
