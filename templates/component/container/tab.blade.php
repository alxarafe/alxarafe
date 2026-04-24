@php
    /** @var \Alxarafe\ResourceController\Component\Container\Tab $container */
    /** @var array $record */
@endphp

<div class="row">
    @foreach($container->getFields() as $child)
        @renderComponent($child, ['record' => $record ?? []])
    @endforeach
</div>
