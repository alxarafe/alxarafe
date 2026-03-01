@php
    $languagesData = \Alxarafe\Lib\Trans::getAvailableLanguagesWithFlags();

    // Preference order: Cookie > User > Company Config > Fallback
    $cookieLang = $_COOKIE['alx_lang'] ?? null;
    $userLang = \Alxarafe\Lib\Auth::$user->language ?? null;

    $configLang = null;
    try {
        $configLang = \Alxarafe\Base\Config::getConfig()->main->language ?? null;
    } catch (\Throwable $e) {}

    $currentLang = $cookieLang ?? $userLang ?? $configLang ?? \Alxarafe\Lib\Trans::FALLBACK_LANG;
    $isUserSelection = !empty($cookieLang) || !empty($userLang);
    $currentFlag = $languagesData[$currentLang]['flag'] ?? 'un';
@endphp

<a class="nav-link dropdown-toggle d-flex align-items-center justify-content-center px-1 text-secondary"
   style="height: 40px; min-width: 40px;"
   href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="{{ \Alxarafe\Lib\Trans::_('select_language') }}">
    @if($isUserSelection && $currentFlag !== 'un')
        <span class="fi fi-{{ $currentFlag }} shadow-sm rounded-1" style="width: 1.4rem; height: 1.1rem; flex-shrink: 0;"></span>
    @else
        <i class="fas fa-globe fa-lg cyber-icon" style="flex-shrink: 0;"></i>
    @endif
</a>

<ul class="dropdown-menu dropdown-menu-end shadow animate__animated animate__fadeInFast">
    <li class="dropdown-header text-uppercase small fw-bold text-primary">{{ \Alxarafe\Lib\Trans::_('available_languages') }}</li>
    <li><hr class="dropdown-divider"></li>
    @foreach($languagesData as $code => $lang)
        <li>
            <a class="dropdown-item d-flex align-items-center py-2 {{ $currentLang === $code ? 'active' : '' }}"
               href="index.php?module=Admin&controller=Auth&action=setLang&lang={{ $code }}">
                <span class="fi fi-{{ $lang['flag'] ?? 'un' }} me-3 shadow-sm rounded-1" style="width: 1.5rem; height: 1.1rem;"></span>
                <span>{{ $lang['name'] }}</span>
            </a>
        </li>
    @endforeach
</ul>
