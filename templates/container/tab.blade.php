@php
    /** @var \Alxarafe\Infrastructure\Component\Container\Tab $container */
    /** @var array $record */
@endphp

<div class="row">
    @foreach($container->getChildren() as $child)
        {!! \Alxarafe\Infrastructure\Component\Container\AbstractContainer::renderChild($child, $record) !!}
    @endforeach
</div>
