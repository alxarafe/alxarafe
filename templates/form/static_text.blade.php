<?php
/** @var string $label Content to display */
/** @var string $field Unique ID (optional) */
/** @var string $class Additional CSS classes (optional) */
?>
<div class="mb-3 {{ $class ?? '' }}" id="{{ $field }}">
    {!! $label !!}
</div>
