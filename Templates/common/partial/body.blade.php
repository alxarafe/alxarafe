<div id="id_container" class="id_container">
    @include('page.partial.top_bar')
    @include('page.partial.side_bar')
    <div id="id-right">
        @yield('content')
    </div>
</div>
@include('page.partial.footer')
