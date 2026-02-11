<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="title" content="CYBERPUNK :: {!! $me->title ?? 'Alxarafe' !!}">
<meta name="author" content="Rafael San José">
<meta name="description" content="Microframework for development of PHP database applications">
<title>CYBERPUNK :: {!! $me->title ?? 'Alxarafe' !!}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- Cyberpunk Theme Override -->
<link href="/themes/cyberpunk/css/default.css?v={{ time() }}" rel="stylesheet">
<style>
    /* CRITICAL FIX: Force inputs to be editable bypassing any external CSS caching */
    input, textarea {
        -webkit-user-modify: read-write-plaintext-only !important;
        user-modify: read-write-plaintext-only !important;
        user-select: text !important;
        pointer-events: auto !important;
    }
    
    /* Ensure Selects work */
    select {
        -webkit-user-modify: read-only !important;
        user-modify: read-only !important;
    }

    /* Standardize button shapes in this theme */
    .btn {
        border-radius: 0.375rem !important; /* Standard Bootstrap radius */
    }
</style>

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
    
    .id_container {
        display: flex;
        flex-direction: column;
    }
    
    #id-right {
        margin-left: 250px; /* Sidebar width */
        padding: 20px;
        flex-grow: 1;
        transition: margin-left 0.3s;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 0;
            overflow: hidden;
        }
        #id-right {
            margin-left: 0;
        }
    }
</style>

@stack('css')
