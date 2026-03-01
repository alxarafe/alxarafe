@php
    $hasSidebar = !empty($main_menu);
@endphp
<div id="id_container" class="id_container {{ $hasSidebar ? 'has-sidebar' : 'no-sidebar' }}">
    @if($hasSidebar)
        @include('partial.main_menu')
    @endif
    <div id="id-right">

        @include('partial.user_menu')
        <div class="container-fluid mt-4">
            <!-- Unified Page Header -->
            <div class="row mb-4 align-items-center">
                <div class="col-12 col-md d-flex align-items-center mb-2 mb-md-0">
                    @if ($me->title)
                        <h1 class="display-6 fw-bold mb-0">{!! $me->title !!}</h1>
                    @endif
                </div>
                <div class="col-12 col-md-auto text-end">
                    <div class="page-actions" id="global-actions-container">
                        @yield('header_actions')
                    </div>
                </div>
            </div>

            @include('partial.alerts')
            @yield('content')
        </div>
    </div>
</div>
