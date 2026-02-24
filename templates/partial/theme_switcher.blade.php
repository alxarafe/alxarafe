@php
    $themes = \Alxarafe\Lib\Functions::getThemes();
    $currentTheme = $_COOKIE['alx_theme'] ?? \Alxarafe\Base\Config::getConfig()->main->theme ?? 'default';
@endphp

<div class="dropdown {{ $class ?? '' }}">
    <button class="btn btn-link text-info p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ \Alxarafe\Lib\Trans::_('select_theme') }}">
        <i class="fas fa-palette fa-2x"></i>
    </button>
    <ul class="dropdown-menu shadow">
        <li class="dropdown-header text-uppercase small">{{ \Alxarafe\Lib\Trans::_('available_themes') }}</li>
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
</div>
