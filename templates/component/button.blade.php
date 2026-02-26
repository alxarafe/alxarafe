@props(['variant' => 'primary', 'tag' => 'button', 'href' => '#', 'spacing' => null])

@php
    $finalClass = "btn btn-{$variant}";
    if ($spacing) {
        $finalClass .= " {$spacing}";
    }
@endphp

@if($tag === 'link' || $attributes->has('href'))
    <a {{ $attributes->merge(['class' => $finalClass, 'href' => $href]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $finalClass]) }}>
        {{ $slot }}
    </button>
@endif