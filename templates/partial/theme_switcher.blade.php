@php
    $themes = \Alxarafe\Lib\Functions::getThemes();
    $currentTheme = $_COOKIE['alx_theme'] ?? \Alxarafe\Base\Config::getConfig()->main->theme ?? 'default';
@endphp

<a class="nav-link dropdown-toggle d-flex align-items-center justify-content-center px-1" 
   style="height: 40px; min-width: 40px;" 
   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ \Alxarafe\Lib\Trans::_('select_theme') }}">
    <i class="fas fa-palette fa-lg cyber-icon" style="flex-shrink: 0;"></i>
</a>

<ul class="dropdown-menu dropdown-menu-end shadow animate__animated animate__fadeInFast">
    <li class="dropdown-header text-uppercase small fw-bold text-primary">{{ \Alxarafe\Lib\Trans::_('available_themes') }}</li>
    <li><hr class="dropdown-divider"></li>





        @foreach($themes as $name => $label)
            <li>
                <a class="dropdown-item d-flex align-items-center {{ $currentTheme === $name ? 'active' : '' }}" 
                   href="index.php?module=Admin&controller=Auth&action=setTheme&theme={{ $name }}">
                    <i class="fas fa-circle me-2" style="font-size: 0.5em;"></i>
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>
