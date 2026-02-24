<!-- Templates/common/component/card.blade.php -->
{{--
USE:
    <x-component.card title="Card Title" image="path/to/image.jpg" footer="Card footer text" style="width: 18rem;">
        <p>This is the card body content with <strong>HTML</strong> support.</p>
    </x-component.card>

@link: https://getbootstrap.com/docs/5.2/components/card/

Parameters:
    title is optional
    image is optional
    footer is optional
    class is optional (default "card")
--}}

@props(['title' => null, 'image' => null, 'footer' => null, 'class' => 'card'])

<div {{ $attributes->merge(['class' => $class]) }}>
    @if($image)
        <img src="{{ $image }}" class="card-img-top" alt="{{ $title ?? 'Card image' }}">
    @endif
    <div class="card-body">
        @if($title)
            <h5 class="card-title">{{ $title }}</h5>
        @endif
        {{ $slot }}
    </div>
    @if($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>