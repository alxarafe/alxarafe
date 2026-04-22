@php
    /** @var \Alxarafe\ResourceController\Component\Container\Tab $container */
    /** @var array $record */
@endphp

<div class="row">
    @foreach($container->getFields() as $child)
        {!! \Alxarafe\Infrastructure\Component\ComponentRenderer::render($child, ['record' => $record ?? []]) !!}
    @endforeach
</div>
