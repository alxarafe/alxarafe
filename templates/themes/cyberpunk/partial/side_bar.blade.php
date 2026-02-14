@if(!empty($me->sidebar_menu))
    <div class="sidebar cyber-sidebar">
        <div class="cyber-scanline"></div>
        <div class="cyber-logo text-center py-4">
            <h2 class="glitch" data-text="ALXARAFE">ALXARAFE</h2>
            <small class="text-secondary">> SYS.ONLINE</small>
        </div>

        @foreach ($me->sidebar_menu as $key => $subMenu)
            <div class="cyber-section">
                <h6 class="cyber-header px-3 mt-4 text-secondary">
                    <i class="fas fa-microchip me-2"></i>{{ strtoupper($key) }}
                </h6>
                <div class="d-flex flex-column">
                @foreach ($subMenu as $subKey => $subSubMenu)
                    @if (is_array($subSubMenu))
                        <div class="px-3 mt-2">
                            <h6 class="text-muted small ps-2 border-start border-secondary">> {{ strtoupper($subKey) }}</h6>
                            @foreach ($subSubMenu as $menuKey => $url)
                                <a href="{{ $url }}" class="cyber-link d-block ps-4 py-1">
                                    <span class="cyber-marker">[ ]</span> {{ ucfirst(last(explode('|', $menuKey))) }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <a href="{{ $subSubMenu }}" class="cyber-link d-block px-3 py-2">
                            <span class="cyber-marker">[ ]</span> {{ strtoupper($subKey) }}
                        </a>
                    @endif
                @endforeach
                </div>
            </div>
        @endforeach
        
        <div class="cyber-footer mt-5 px-3">
            <small class="text-muted d-block">IP: 127.0.0.1</small>
            <small class="text-muted d-block">UPTIME: 99.9%</small>
            <a href="index.php?module=Admin&controller=Auth&action=doLogout" class="cyber-link d-block text-danger mt-3">
                > LOGOUT_SYSTEM
            </a>
        </div>
    </div>
@endif
