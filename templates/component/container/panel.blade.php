@php
    /** @var \Alxarafe\Component\Container\Panel $container */
    /** @var array $record */
    /** @var array $children */
    $col   = $container->getColClass();
    $class = $container->getOptions()['options']['class'] ?? $container->getOptions()['class'] ?? '';
@endphp

<div class="{{ $col }} mb-4">
    <div class="card shadow-sm {{ $class }}">
        @if($container->getLabel())
            <div class="card-header">
                {{ $container->getLabel() }}
            </div>
        @endif
        <div class="card-body">
            <div class="row">
                @foreach($container->getFields() as $child)
                    @renderComponent($child, ['record' => $record ?? []])
                @endforeach
            </div>
        </div>
    </div>
</div>
