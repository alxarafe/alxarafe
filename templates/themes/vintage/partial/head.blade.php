<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="title" content="{!! $me->title ?? 'Alxarafe' !!}">
<meta name="author" content="Rafael San José">
<meta name="description" content="Microframework for development of PHP database applications">
<title>{!! $me->title ?? 'Alxarafe' !!}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- Vintage Theme CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link href="/themes/vintage/css/default.css?v={{ time() }}" rel="stylesheet">
<style>
    /* Small overrides that don't fit in the CSS file well */
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Playfair Display', serif;
        letter-spacing: -0.5px;
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
