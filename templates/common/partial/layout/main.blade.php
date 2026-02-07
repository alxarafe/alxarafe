<!DOCTYPE html>
<html lang="{!! $me->config->main->language ?? 'en' !!}">
<head>
    <title>{!! $me->title !!}</title>
    @include('partial.head')
</head>
<body class="container">
<h1>{{ $me->title ?? 'Alxarafe' }}</h1>
@php
    $_body = 'body_' . ($empty ?? false ? 'empty' : 'standard');
@endphp
@include('partial.' . $_body)
@include('partial.footer')
</body>
</html>
