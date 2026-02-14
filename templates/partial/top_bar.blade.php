<!-- Start top horizontal -->
<!-- Start top horizontal -->
@if (!empty($me->top_menu) || !empty($me->header_user_menu) || \Alxarafe\Lib\Auth::isLogged())
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">AppName</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                @foreach ($me->top_menu as $key => $subMenu)
                    @if (is_array($subMenu) && count($subMenu) > 0)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $key }}" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ $me->_($key) }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $key }}">
                                @foreach ($subMenu as $subKey => $url)
                                    <a class="dropdown-item" href="{{ $url }}">{{ $me->_($subKey) }}</a>
                                @endforeach
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $subMenu }}">{{ $me->_($key) }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <ul class="navbar-nav ml-auto">
            {{-- Notifications --}}
            @php
                $notifications = \CoreModules\Admin\Service\NotificationManager::getUnread();
                $unreadCount = $notifications->count();
            @endphp
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarNotifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell"></i>
                    @if($unreadCount > 0)
                        <span class="badge badge-danger">{{ $unreadCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarNotifications">
                    @if($notifications->count() > 0)
                        @foreach($notifications as $notif)
                            <a class="dropdown-item" href="{{ $notif->link ?? '#' }}" style="{{ $notif->read ? '' : 'font-weight: bold;' }}">
                                {{ $notif->message }}
                                <br><small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </a>
                        @endforeach
                    @else
                         <span class="dropdown-item text-muted">No new notifications</span>
                    @endif
                </div>
            </li>

            {{-- User Menu --}}
            @if(\Alxarafe\Lib\Auth::$user)
                 <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(!empty(\Alxarafe\Lib\Auth::$user->avatar) && file_exists(\Alxarafe\Base\Config::getPublicRoot() . '/' . \Alxarafe\Lib\Auth::$user->avatar))
                            <img src="{{ \Alxarafe\Lib\Auth::$user->avatar }}" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover; margin-right: 5px;">
                        @else
                            <i class="fas fa-user-circle fa-lg mr-1"></i>
                        @endif
                         {{ \Alxarafe\Lib\Auth::$user->name ?? \Alxarafe\Lib\Auth::$user->username ?? 'User' }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarUser">
                        @if(isset($me->header_user_menu) && is_array($me->header_user_menu))
                            @foreach($me->header_user_menu as $item)
                                @php
                                   $url = $item['url'] ?? '';
                                   if (!$url && isset($item['route']) && strpos($item['route'], '.') !== false) {
                                       $parts = explode('.', $item['route']);
                                       if (count($parts) >= 3) {
                                           $url = "index.php?module={$parts[0]}&controller={$parts[1]}&action={$parts[2]}";
                                       }
                                   }
                                @endphp
                                <a class="dropdown-item" href="{{ $url }}">
                                    @if(!empty($item['icon'])) <i class="{{ $item['icon'] }} mr-2"></i> @endif
                                    {{ $me->_($item['label'] ?? '') }}
                                    @if(!empty($item['badge']))
                                        <span class="badge badge-danger float-right">{{ $item['badge'] }}</span>
                                    @endif
                                </a>
                            @endforeach
                        @endif
                    </div>
                </li>
            @endif
        </ul>
        </div>
    </nav>
@endif