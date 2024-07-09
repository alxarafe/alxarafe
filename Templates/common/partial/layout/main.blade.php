<!DOCTYPE html>
<html lang="{!! $me->lang ?? 'en' !!}">
<head>
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
