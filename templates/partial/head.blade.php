<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="title" content="{!! $me->title ?? 'Alxarafe' !!}">
<meta name="author" content="Rafael San José">
<meta name="description" content="Microframework for development of PHP database applications">
<title>{!! $me->title ?? 'Alxarafe' !!}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- Dynamic Theme CSS -->
@php
    $activeTheme = $_COOKIE['alx_theme']
        ?? \Alxarafe\Base\Config::getConfig()->main->theme
        ?? 'default';
@endphp
<link href="/themes/{{ $activeTheme }}/css/default.css" rel="stylesheet">

{!! $me->getRenderHeader() !!}

<style>
    /* Default Sidebar layout override */
    .sidebar {
        height: 100vh;
        width: 250px;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 20px;
        z-index: 1000;
        /* Background and colors controlled by default.css */
    }

    .no-sidebar .sidebar {
        display: none;
    }
    
    .id_container {
        display: flex;
        flex-direction: column;
    }
    
    #id-right {
        margin-left: 0;
        padding: 20px;
        flex-grow: 1;
        transition: margin-left 0.3s;
    }

    .has-sidebar #id-right {
        margin-left: 250px; /* Sidebar width */
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 0;
            overflow: hidden;
        }
        .has-sidebar #id-right {
            margin-left: 0;
        }
        #id-right {
            padding: 10px;
        }
        /* Reduce title size on mobile */
        .display-6 {
            font-size: 1.5rem;
        }
    }

    /* Scrollable tabs on narrow screens */
    .nav-tabs {
        flex-wrap: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Firefox */
    }
    .nav-tabs::-webkit-scrollbar {
        display: none; /* Chrome/Safari */
    }
    .nav-tabs .nav-item {
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* Switcher global styles */
    .animate__fadeInFast { animation-duration: 0.2s; }
    .nav-link.dropdown-toggle::after { display: none !important; }
    .cyber-icon { transition: color 0.3s ease; }
    .nav-item.dropdown .nav-link { 
        display: flex; 
        align-items: center; 
        justify-content: center;
        height: 40px;
    }
</style>


@stack('css')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />

