<!-- Top Bar (Flexbox Layout) -->
    <header class="d-flex flex-column-reverse flex-md-row align-items-center justify-content-between px-3 py-2 bg-light border-bottom">
        
        <!-- Brand / Title Section -->
        <div class="d-flex align-items-center flex-grow-1 w-100 w-md-auto mt-2 mt-md-0">
            <!-- Sidebar Toggler (Only visible on mobile/small Screens) -->
            <button class="btn btn-primary d-md-none me-3" id="menu-toggle" onclick="document.getElementById('wrapper').classList.toggle('toggled');">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Page Title & Back Button -->
            <div class="d-flex align-items-center">
                @if(!empty($me->backUrl))
                    <a href="{!! $me->backUrl !!}" class="btn btn-sm btn-outline-secondary me-2"><i class="fas fa-arrow-left"></i></a>
                @endif
                <h1 class="h4 mb-0 text-dark font-weight-bold text-truncate" title="{{ $title ?? '' }}">{{ $title ?? '' }}</h1>
            </div>
        </div>

        <!-- User Tools Section (Top on Mobile, Right on Desktop) -->
        <div class="d-flex align-items-center justify-content-end w-100 w-md-auto">
            <ul class="nav">
                {{-- Clocks (Hidden on small screens) --}}
                @php
                    $companyTz = \Alxarafe\Base\Config::getConfig()->main->timezone ?? 'UTC';
                    $userTz = (\Alxarafe\Lib\Auth::$user->timezone ?? null) ?: $companyTz;
                @endphp
                <li class="nav-item position-relative me-3 d-none d-lg-flex align-items-center clock-container text-secondary" style="cursor: help;">
                    <i class="far fa-clock me-2"></i>
                    <span id="clock-display" class="font-weight-bold">--:--:--</span>
                    
                    <!-- Hover Tooltip -->
                    <div class="clock-details shadow rounded bg-white border p-3 position-absolute text-start" style="top: 100%; right: 0; min-width: 350px; display: none; z-index: 1060; line-height: 1.4;">
                        <div class="small text-muted border-bottom mb-2 pb-1">{{ \Alxarafe\Lib\Trans::_('timezones') }}</div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted small">{{ \Alxarafe\Lib\Trans::_('utc') }}:</span>
                            <span id="clock-utc" class="text-dark font-weight-bold small">--</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-primary small" title="{{ $companyTz }}">{{ \Alxarafe\Lib\Trans::_('app_label') }}:</span>
                            <span id="clock-company" class="text-dark font-weight-bold small">--</span>
                        </div>
                        @if(\Alxarafe\Lib\Auth::$user)
                        <div class="d-flex justify-content-between">
                            <span class="text-success small" title="{{ $userTz }}">{{ \Alxarafe\Lib\Trans::_('user_label') }}:</span>
                            <span id="clock-user" class="text-dark font-weight-bold small">--</span>
                        </div>
                        @endif
                    </div>
                </li>
                
                <style>
                    .clock-container:hover .text-secondary { color: #333 !important; }
                    .clock-container:hover .clock-details { display: block !important; animation: fadeIn 0.2s; }
                    @keyframes fadeIn { from { opacity:0; transform: translateY(-5px); } to { opacity:1; transform: translateY(0); } }
                </style>
                
                {{-- Notifications --}}
                @if(\Alxarafe\Lib\Auth::isLogged())
                    @php
                        $notifications = \CoreModules\Admin\Service\NotificationManager::getUnread();
                        $unreadCount = $notifications->count();
                    @endphp
                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle px-1 text-secondary" href="#" id="navbarNotifications" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell fa-lg"></i>
                            @if($unreadCount > 0)
                                <span class="badge badge-danger" style="position: absolute; top: 0; right: 0; font-size: 0.6rem;">{{ $unreadCount }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarNotifications" style="z-index: 1050;">
                            @if($notifications->count() > 0)
                                @foreach($notifications as $notif)
                                    <a class="dropdown-item" href="{{ $notif->link ?? '#' }}" style="{{ $notif->read ? '' : 'font-weight: bold;' }}">
                                        {{ $notif->message }}
                                        <br><small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                                    </a>
                                @endforeach
                            @else
                                 <span class="dropdown-item text-muted small">{{ \Alxarafe\Lib\Trans::_('no_new_notifications') }}</span>
                            @endif
                        </div>
                    </li>
                @endif

                {{-- User Menu --}}
                @if(\Alxarafe\Lib\Auth::$user)
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pr-0 d-flex align-items-center text-dark" href="#" id="navbarUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(!empty(\Alxarafe\Lib\Auth::$user->avatar) && file_exists(\Alxarafe\Base\Config::getPublicRoot() . '/' . \Alxarafe\Lib\Auth::$user->avatar))
                                <img src="{{ \Alxarafe\Lib\Auth::$user->avatar }}" class="rounded-circle border me-2" style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <i class="fas fa-user-circle fa-lg text-secondary me-2"></i>
                            @endif
                             <span class="d-none d-sm-inline">{{ \Alxarafe\Lib\Auth::$user->name ?? \Alxarafe\Lib\Auth::$user->username ?? 'User' }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarUser" style="z-index: 1050;">
                            @if(isset($user_menu) && is_array($user_menu))
                                @foreach($user_menu as $item)
                                    <a class="dropdown-item" href="{{ $item['url'] }}">
                                        @if(!empty($item['icon'])) <i class="{{ $item['icon'] }} me-2 text-muted"></i> @endif
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                            @endif
                            <a class="dropdown-item text-danger" href="index.php?module=Admin&controller=Auth&action=logout">
                                <i class="fas fa-sign-out-alt me-2"></i> {{ $me->_('logout') }}
                            </a>
                        </div>
                    </li>
                @else
                    @if(stripos($_SERVER['QUERY_STRING'] ?? '', 'controller=Auth') === false)
                    <li class="nav-item">
                        <a class="nav-link btn btn-sm btn-primary text-white ms-2" href="index.php?module=Admin&controller=Auth">
                            <i class="fas fa-sign-in-alt me-1"></i> {{ $me->_('login') }}
                        </a>
                    </li>
                    @endif
                @endif
            </ul>
        </div>
    </header>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updateClocks() {
                const now = new Date();
                const fmt = (tz) => now.toLocaleString('es-ES', { timeZone: tz, hour12: false, year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' }).replace(',', '');
                
                // Update details
                const utcEl = document.getElementById('clock-utc');
                if(utcEl) utcEl.innerText = fmt('UTC');

                const compEl = document.getElementById('clock-company');
                if(compEl) compEl.innerText = fmt('{{ $companyTz }}');

                @if(\Alxarafe\Lib\Auth::$user)
                const userEl = document.getElementById('clock-user');
                if(userEl) userEl.innerText = fmt('{{ $userTz }}');
                @endif
                
                // Update Main Display (User Preferred)
                const mainEl = document.getElementById('clock-display');
                if(mainEl) {
                    // Just show Time for cleaner look in header? Or Date+Time?
                    // User request "la hora del usuario". Usually minimal is better.
                    // Let's keep full format for consistency with previous, or just H:i:s
                    // The fmt function returns YYYY-MM-DD HH:MM:SS.
                    // Let's simplify main display to just HH:MM:SS slightly cleaner? 
                    // No, standard theme usually has space. Let's keep full for info density.
                    mainEl.innerText = fmt('{{ $userTz }}');
                }
            }
            setInterval(updateClocks, 1000);
            updateClocks();
        });
    </script>