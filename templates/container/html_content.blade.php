@php
    /** @var \Alxarafe\Component\Container\HtmlContent $container */
    /** @var array $record */
    $col   = $container->getColClass();
    $class = $container->getOptions()['options']['class'] ?? $container->getOptions()['class'] ?? '';
@endphp

<div class="{{ $col }} mb-4">
    @if($container->getLabel())
        <div class="card shadow-sm {{ $class }}">
            <div class="card-header">
                {{ $container->getLabel() }}
            </div>
            <div class="card-body">
                {!! $container->getHtml() !!}
            </div>
        </div>
    @else
        <div class="{{ $class }}">
            {!! $container->getHtml() !!}
        </div>
    @endif
</div>
