@props(['type' => 'secondary', 'rounded' => false])

<span {{ $attributes->merge(['class' => "badge bg-{$type}" . ($rounded ? ' rounded-pill' : '')]) }}>
    {{ $slot }}
</span>