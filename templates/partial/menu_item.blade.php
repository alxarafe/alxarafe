@php
    $hasChildren = !empty($item['children']);
    $isActive = strpos($_SERVER['REQUEST_URI'] ?? '', $item['url']) !== false && $item['url'] !== '/';
    $targetId = 'submenu-' . md5($item['label'] . ($item['route'] ?? ''));
@endphp

<div class="nav-item">
    @if($hasChildren)
        <a class="nav-link text-body d-flex justify-content-between align-items-center" 
           data-bs-toggle="collapse" 
           href="#{{ $targetId }}" 
           role="button" 
           aria-expanded="false">
            <span>
                @if(!empty($item['icon'])) <i class="{{ $item['icon'] }} me-2"></i> @endif
                <span class="d-none d-md-inline">{{ $item['label'] }}</span>
            </span>
            <i class="fas fa-chevron-down small opacity-50"></i>
        </a>
        <div class="collapse submenu @if($isActive) show @endif" id="{{ $targetId }}">
            @foreach($item['children'] as $child)
                @include('partial.menu_item', ['item' => $child])
            @endforeach
        </div>
    @else
        <a href="{{ $item['url'] }}" 
           class="nav-link text-body @if($isActive) active bg-light fw-bold @endif" 
           title="{{ $item['label'] }}">
            @if(!empty($item['icon']))
                <i class="{{ $item['icon'] }} me-2 @if($isActive) text-primary @endif"></i>
            @endif
            <span class="d-none d-md-inline">{{ $item['label'] }}</span>
            @if(!empty($item['badge']))
                <span class="badge {{ $item['badgeClass'] ?? 'bg-primary' }} ms-auto">{{ $item['badge'] }}</span>
            @endif
        </a>
    @endif
</div>
