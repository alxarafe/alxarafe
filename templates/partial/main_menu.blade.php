<div class="sidebar" id="sidebar-wrapper">
    <!-- App Branding -->
    <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
        <i class="{{ \Alxarafe\Base\Config::getConfig()->main->appIcon ?? 'fas fa-rocket' }} me-2"></i> {{ \Alxarafe\Base\Config::getConfig()->main->appName ?? 'Alxarafe' }}
    </div>
    <!-- Main Menu (Navigation) -->
    @if(!empty($main_menu) && is_array($main_menu))
        <nav class="nav flex-column">
        @foreach($main_menu as $item)
            <a href="{{ $item['url'] }}" class="nav-link text-body" title="{{ $item['label'] }}">
                @if(!empty($item['icon']))
                    <i class="{{ $item['icon'] }} me-2"></i>
                @endif
                <span class="d-none d-md-inline">{{ $item['label'] }}</span>
            </a>
        @endforeach
        </nav>
    @endif


</div>
<!-- Legacy Fallback removed -->