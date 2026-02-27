@php
    $languages = \Alxarafe\Lib\Trans::getAvailableLanguages();
    
    // Preference order: Cookie > User > Company Config > Fallback
    $cookieLang = $_COOKIE['alx_lang'] ?? null;
    $userLang = \Alxarafe\Lib\Auth::$user->language ?? null;
    $configLang = \Alxarafe\Base\Config::getConfig()->main->language ?? null;
    
    $currentLang = $cookieLang ?? $userLang ?? $configLang ?? \Alxarafe\Lib\Trans::FALLBACK_LANG;
    $isUserSelection = !empty($cookieLang) || !empty($userLang);
    
    // Flag-icons mapping
    $flags = [
        'es' => 'es', 'es_ES' => 'es', 'es_AR' => 'ar', 'es_VE' => 've', 'es_MX' => 'mx',
        'en' => 'us', 'en_US' => 'us', 'en_GB' => 'gb',
        'fr' => 'fr', 'de' => 'de', 'pt' => 'pt', 'pt_BR' => 'br',
        'it' => 'it', 'ru' => 'ru', 'zh' => 'cn', 'ja' => 'jp',
        'ar' => 'sa', 'nl' => 'nl', 'hi' => 'in',
        'ca' => 'es-ct', 'gl' => 'es-ga', 'eu' => 'es-pv' 
    ];
@endphp

<a class="nav-link dropdown-toggle d-flex align-items-center px-2 text-secondary" 
   style="height: 40px; min-width: 40px; justify-content: center;" 
   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ \Alxarafe\Lib\Trans::_('select_language') }}">
    @if($isUserSelection && isset($flags[$currentLang]))
        <span class="fi fi-{{ $flags[$currentLang] }} shadow-sm rounded-1" style="width: 1.4rem; height: 1rem;"></span>
    @else
        <i class="fas fa-globe fa-lg cyber-icon"></i>
    @endif
</a>

<ul class="dropdown-menu dropdown-menu-end shadow animate__animated animate__fadeInFast">
    <li class="dropdown-header text-uppercase small fw-bold text-primary">{{ \Alxarafe\Lib\Trans::_('available_languages') }}</li>
    <li><hr class="dropdown-divider"></li>
    @foreach($languages as $code => $label)
        <li>
            <a class="dropdown-item d-flex align-items-center py-2 {{ $currentLang === $code ? 'active' : '' }}" 
               href="index.php?module=Admin&controller=Auth&action=setLang&lang={{ $code }}">
                <span class="fi fi-{{ $flags[$code] ?? 'un' }} me-3 shadow-sm rounded-1" style="width: 1.5rem; height: 1.1rem;"></span>
                <span>{{ $label }}</span>
            </a>
        </li>
    @endforeach
</ul>





