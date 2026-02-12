<?php
/** @var string $src Image URL */
/** @var string $label Alt text */
/** @var string $field Unique ID */
/** @var string $class Additional CSS classes (optional) */
/** @var string $width Optional width */
/** @var string $height Optional height */
/** @var string $style Optional inline style */
?>
<div class="mb-3 text-center">
    <img src="{{ $src }}" 
         alt="{{ $label ?? '' }}" 
         id="{{ $field }}"
         class="img-fluid {{ $class ?? 'rounded' }}"
         @if(!empty($width)) width="{{ $width }}" @endif
         @if(!empty($height)) height="{{ $height }}" @endif
         @if(!empty($style)) style="{{ $style }}" @endif
    >
</div>
