<div id="id_container" class="id_container">
    @include('partial.user_menu')
    @include('partial.main_menu')
    <div id="id-right">
        @yield('content')
    </div>
</div>
@include('partial.footer')
