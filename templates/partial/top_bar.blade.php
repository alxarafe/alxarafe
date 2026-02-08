<!-- Start top horizontal -->
@if (!empty($me->top_menu))
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
        </div>
    </nav>
@endif