<div id="id_container" class="id_container">
    @include('partial.main_menu')
    <div id="id-right">
        @include('partial.user_menu')
        <!-- Unified Page Header -->
        <div class="container-fluid mt-4">
            <div class="row mb-4 align-items-center">
                <div class="col d-flex align-items-center">
                    @if ($me->backUrl)
                        <a href="{{ $me->backUrl }}" class="btn btn-outline-secondary me-3 shadow-sm" title="{{ $me->_('back') }}">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                    @endif
                    @if ($me->title)
                        <h1 class="display-6 fw-bold mb-0">{!! $me->title !!}</h1>
                    @endif
                </div>
                <div class="col text-end">
                    <div class="page-actions" id="global-actions-container">
                        @yield('header_actions')
                    </div>
                </div>
            </div>
        </div>
        
        @include('partial.alerts')
        @yield('content')
    </div>
</div>
