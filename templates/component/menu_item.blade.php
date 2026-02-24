@php
    $url = $url ?? '#';
    $icon = $icon ?? 'fas fa-circle';
    $label = $label ?? '';
    $title = $title ?? $label;
    $class = $class ?? '';
    $active = $active ?? false;
@endphp

<div class="menu-item-container {{ $active ? 'active' : '' }} {{ $containerClass ?? '' }}">
    <a href="{{ $url }}" class="menu-item-link {{ $class }}" title="{{ $title }}">
        <i class="menu-item-icon {{ $icon }} {{ $iconClass ?? '' }}"></i>
        @if($label && ($showLabel ?? false))
            <span class="menu-item-label">{{ $label }}</span>
        @endif
    </a>
</div>
