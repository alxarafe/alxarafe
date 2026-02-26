@php
    /** @var \Alxarafe\Component\Container\Tab $container */
    /** @var array $record */
@endphp

<div class="row">
    @foreach($container->getChildren() as $child)
        {!! \Alxarafe\Component\Container\AbstractContainer::renderChild($child, $record) !!}
    @endforeach
</div>
