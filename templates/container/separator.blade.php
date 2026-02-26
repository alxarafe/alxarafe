@php
    /** @var \Alxarafe\Component\Container\Separator $container */
    $col   = $container->getColClass();
    $class = $container->getOptions()['options']['class'] ?? $container->getOptions()['class'] ?? '';
    $label = $container->getLabel();
@endphp

<div class="{{ $col ?: 'col-12' }} {{ $class }}">
    @if($label)
        <div class="d-flex align-items-center my-3">
            <hr class="flex-grow-1">
            <span class="mx-3 text-muted fw-semibold small text-uppercase">{{ $label }}</span>
            <hr class="flex-grow-1">
        </div>
    @else
        <hr class="my-3">
    @endif
</div>
