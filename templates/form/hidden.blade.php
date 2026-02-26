@props(['name' => $name ?? '', 'value' => ''])
<input type="hidden" name="{{ $name }}" value="{{ $value }}" {{ $attributes }}>
