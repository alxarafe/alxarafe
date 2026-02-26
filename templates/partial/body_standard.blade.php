@php
    $hasSidebar = !empty($main_menu);
@endphp
<div id="id_container" class="id_container {{ $hasSidebar ? 'has-sidebar' : 'no-sidebar' }}">
    @if($hasSidebar)
        @include('partial.main_menu')
    @endif
    <div id="id-right">

        @include('partial.user_menu')
        <!-- Unified Page Header -->
        <div class="container-fluid mt-4">
            <div class="row mb-4 align-items-center">
                <div class="col d-flex align-items-center">
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
