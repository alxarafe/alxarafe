<div class="sidebar" id="sidebar-wrapper">
    <!-- App Branding -->
    <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
        <i class="{{ \Alxarafe\Infrastructure\Persistence\Config::getConfig()->main->appIcon ?? 'fas fa-rocket' }} me-2"></i> {{ \Alxarafe\Infrastructure\Persistence\Config::getConfig()->main->appName ?? 'Alxarafe' }}
    </div>
    <!-- Main Menu (Navigation) -->
    @if(!empty($main_menu) && is_array($main_menu))
        <nav class="nav flex-column list-group list-group-flush">
            @foreach($main_menu as $item)
                @include('partial.menu_item', ['item' => $item])
            @endforeach
        </nav>
    @endif
</div>

<style>
    .sidebar .nav-link { padding: 0.8rem 1.5rem; border-radius: 0; }
    .sidebar .nav-link:hover { background: rgba(0,0,0,0.05); }
    .sidebar .submenu { background: rgba(0,0,0,0.02); padding-left: 1rem; }
    .sidebar .submenu .nav-link { font-size: 0.9rem; padding: 0.5rem 1.5rem; }
</style>
<!-- Legacy Fallback removed -->