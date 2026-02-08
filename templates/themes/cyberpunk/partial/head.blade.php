<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="title" content="{!! $me->title ?? 'Alxarafe' !!}">
<meta name="author" content="Rafael San José">
<meta name="description" content="Microframework for development of PHP database applications">
<title>CYBERPUNK :: {!! $me->title ?? 'Alxarafe' !!}</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<!-- Cyberpunk Theme Override -->
<link href="/css/cyberpunk.css" rel="stylesheet">

{!! $me->getRenderHeader() !!}



@stack('css')
