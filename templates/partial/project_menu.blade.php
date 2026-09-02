@php
    $config = \Alxarafe\Infrastructure\Persistence\Config::getConfig();
    $appName = $config->main->appName ?? 'Alxarafe';
    $appIcon = $config->main->appIcon ?? 'fas fa-rocket';

    // Social links from config
    $githubUrl = $config->social->github ?? null;
    $linkedinUrl = $config->social->linkedin ?? null;
    $twitterUrl = $config->social->twitter ?? null;
    $instagramUrl = $config->social->instagram ?? null;
    $facebookUrl = $config->social->facebook ?? null;
@endphp

<!-- Navigation Menu -->
<nav class="alx-navbar d-flex align-items-center">
    <a class="alx-navbar-brand d-flex align-items-center text-decoration-none fw-bold" href="/">
        <i class="{{ $appIcon }} me-2"></i>
        <span>{{ $appName }}</span>
    </a>

    @if(!empty($main_menu) && is_array($main_menu))
        <ul class="alx-navbar-nav d-none d-md-flex list-unstyled mb-0 gap-1 ms-3">
            @foreach($main_menu as $item)
                <li class="nav-item">
                    <a class="alx-nav-link px-2 py-1 rounded" href="{{ $item['url'] ?? '#' }}" @if(!empty($item['target'])) target="{{ $item['target'] }}" @endif>
                        @if(!empty($item['icon']))<i class="{{ $item['icon'] }} me-1"></i>@endif
                        {{ $item['label'] ?? $item['name'] ?? '' }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    <div class="alx-navbar-spacer"></div>

    <div class="alx-navbar-tools d-flex align-items-center gap-2">
        @if($githubUrl)<a href="{{ $githubUrl }}" target="_blank" class="text-secondary" title="GitHub"><i class="fab fa-github"></i></a>@endif
        @if($linkedinUrl)<a href="{{ $linkedinUrl }}" target="_blank" class="text-secondary" title="LinkedIn"><i class="fab fa-linkedin"></i></a>@endif
        @if($twitterUrl)<a href="{{ $twitterUrl }}" target="_blank" class="text-secondary" title="Twitter / X"><i class="fab fa-x-twitter"></i></a>@endif
        @if($instagramUrl)<a href="{{ $instagramUrl }}" target="_blank" class="text-secondary" title="Instagram"><i class="fab fa-instagram"></i></a>@endif
        @if($facebookUrl)<a href="{{ $facebookUrl }}" target="_blank" class="text-secondary" title="Facebook"><i class="fab fa-facebook"></i></a>@endif
    </div>
</nav>

<style>
    .alx-navbar {
        gap: 0.5rem;
        padding: 0.4rem 0.75rem;
        border-bottom: 1px solid #e9ecef;
        background: #fff;
        flex-wrap: nowrap;
    }
    .alx-navbar-brand {
        color: #333;
        font-size: 0.95rem;
        white-space: nowrap;
    }
    .alx-navbar-brand:hover { color: #000; }
    .alx-nav-link {
        color: #555;
        font-size: 0.85rem;
        white-space: nowrap;
        transition: color 0.2s, background 0.2s;
    }
    .alx-nav-link:hover {
        color: #000;
        background: rgba(0,0,0,0.05);
    }
    .alx-navbar-spacer { flex: 1; }
    .alx-navbar-tools a {
        font-size: 0.85rem;
        transition: color 0.2s;
    }
    .alx-navbar-tools a:hover { color: #000 !important; }
</style>
