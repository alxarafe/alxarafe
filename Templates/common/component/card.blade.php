<!-- Templates/common/component/card.blade.php -->
{{--
USE:
    @component('component.card', [
        'title' => 'Card Title',
        'image' => 'path/to/image.jpg',
        'footer' => 'Card footer text',
        'class' => 'custom-class',
        'attributes' => ['style' => 'width: 18rem;']
    ])

    @slot('body')
        <p>This is the card body content with <strong>HTML</strong> support.</p>
    @endslot

@link: https://getbootstrap.com/docs/5.0/components/card/

Parameters:
    title is optional
    image is optional
    footer is optional
    class is optional (default "card")
    attributes is optional (additional HTML attributes for the card)
--}}

@php
    use Alxarafe\Lib\Functions;

    $title = $title ?? null;
    $image = $image ?? null;
    $footer = $footer ?? null;
    $class = $class ?? 'card';

    $_attributes = Functions::htmlAttributes($attributes ?? []);
@endphp

<div class="{{ $class }}" {!! $_attributes !!}>
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