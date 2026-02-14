<!DOCTYPE html>
<html lang="{!! $me->config->main->language ?? 'en' !!}">
<head>
    <title>CYBER::{!! $me->title !!}</title>
    @include('partial.head')
</head>
<body class="cyber-shell">

<div class="cyber-grid-overlay"></div>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Column (fixed width in CSS or col-3) -->
        <div class="col-md-3 col-lg-2 d-md-block p-0">
             @include('partial.side_bar')
        </div>

        <!-- Main Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h1 class="cyber-page-title mb-4">
                @if(!empty($me->backUrl))
                    <a href="{!! $me->backUrl !!}" class="text-decoration-none text-danger me-2">&lt;</a>
                @endif
                > {{ strtoupper($me->title ?? 'Alxarafe') }}_
            </h1>
            
            @php
                $_body = 'body_' . ($empty ?? false ? 'empty' : 'standard');
            @endphp
            
            <!-- We override the body structure slightly here by standardising content wrapper -->
            <div class="cyber-content-wrapper">
                 @include('partial.alerts')
                 @yield('content')
            </div>
            
            @include('partial.footer')
        </main>
    </div>
</div>

</body>
</html>
