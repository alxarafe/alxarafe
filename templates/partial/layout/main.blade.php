<!DOCTYPE html>
<html lang="{!! $me->config->main->language ?? 'en' !!}">
<head>
    <title>{!! $me->title !!}</title>
    @include('partial.head')
</head>
<body>
    <!-- Header handled by Top Bar -->
    <!-- Header handled by Body Templates -->
    @if ($empty ?? false)
        @include('partial.body_empty')
    @else
        @include('partial.body_standard')
    @endif
    @include('partial.footer')
</body>
</html>
