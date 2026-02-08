<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="title" content="ACCESSIBLE :: {!! $me->title ?? 'Alxarafe' !!}">
<title>ACCESSIBLE :: {!! $me->title ?? 'Alxarafe' !!}</title>

<!-- Standard Bootstrap for grid only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- High Contrast Theme Main CSS -->
<link href="/css/high-contrast.css" rel="stylesheet">

{!! $me->getRenderHeader() !!}

<style>
    /* Force Layout Spacing for better readability */
    body { padding: 20px 0; }
    
    .sidebar {
        height: 100vh;
        width: 300px; /* Wider sidebar */
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        border-right: 5px solid yellow; /* CLEAR Division */
    }
    
    #id-right {
        margin-left: 310px; /* More margin */
        padding: 30px;
    }
    
    @media (max-width: 900px) { /* Earlier breakpoint */
        .sidebar { position: static; width: 100%; height: auto; border-bottom: 5px solid yellow; border-right: none;}
        #id-right { margin-left: 0; }
    }
</style>

@stack('css')
