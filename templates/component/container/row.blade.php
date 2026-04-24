@php
    /** @var \Alxarafe\Component\Container\Row $container */
    /** @var array $record */
    $col   = $container->getColClass();
    $class = $container->getOptions()['options']['class'] ?? $container->getOptions()['class'] ?? '';
@endphp

<div class="{{ $col }}">
    <div class="row {{ $class }}">
        @foreach($container->getFields() as $child)
            @renderComponent($child, ['record' => $record ?? []])
        @endforeach
    </div>
</div>
