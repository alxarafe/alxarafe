<div id="id_container" class="id_container">
    @include('partial.main_menu')
    <div id="id-right">
        @include('partial.user_menu')
        <!-- Unified Page Header (Toolbar Only - Title in TopBar) -->
        <div class="container-fluid mt-4">
            <div class="row mb-4 align-items-center">
                <div class="col-12 text-end">
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
