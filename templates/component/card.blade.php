@props(['title' => null, 'image' => null, 'footer' => null, 'header' => null, 'class' => 'card shadow-sm'])

<div {{ $attributes->merge(['class' => $class]) }}>
    @if($header || isset($header_slot))
        <div class="card-header">
            {{ $header ?? $header_slot }}
        </div>
    @endif
    @if($image)
        <img src="{{ $image }}" class="card-img-top" alt="{{ $title ?? 'Card image' }}">
    @endif
    <div class="card-body">
        @if($title)
            <h5 class="card-title fw-bold">{{ $title }}</h5>
        @endif
        {{ $slot }}
    </div>
    @if($footer || isset($footer_slot))
        <div class="card-footer">
            {{ $footer ?? $footer_slot }}
        </div>
    @endif
</div>