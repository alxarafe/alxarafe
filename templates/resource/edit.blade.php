@extends('partial.layout.main')

@section('header_actions')
@php $buttons = $viewDescriptor['buttons'] ?? []; @endphp
@foreach($buttons as $btn)
    @if(($btn['action'] ?? 'submit') === 'submit')
        <button type="submit" form="alxarafe-edit-form"
                name="{{ $btn['name'] ?? '' }}" value="{{ $btn['name'] ?? '' }}"
                onclick="document.querySelector('#alxarafe-edit-form input[name=action]').value='{{ $btn['name'] ?? 'save' }}'"
                class="btn btn-{{ $btn['type'] ?? 'primary' }}">
            @if(!empty($btn['icon']))<i class="{{ $btn['icon'] }} me-1"></i>@endif
            {{ $btn['label'] ?? '' }}
        </button>
    @elseif(($btn['action'] ?? '') === 'url')
        <a href="{{ $btn['target'] ?? '#' }}"
           class="btn btn-{{ $btn['type'] ?? 'secondary' }}">
            @if(!empty($btn['icon']))<i class="{{ $btn['icon'] }} me-1"></i>@endif
            {{ $btn['label'] ?? '' }}
        </a>
    @endif
@endforeach
@endsection

@section('content')
@php
    $_record = $viewDescriptor['record'] ?? [];
    $record = is_object($_record) ? json_decode(json_encode($_record), true) : $_record;
@endphp

<div class="container-fluid">
<form method="{{ $viewDescriptor['method'] ?? 'POST' }}"
      action="{{ $viewDescriptor['action'] ?? '' }}"
      id="alxarafe-edit-form">
    <input type="hidden" name="action" value="save">
    @if(!empty($viewDescriptor['recordId']))
        <input type="hidden" name="id" value="{{ $viewDescriptor['recordId'] }}">
    @endif

    @if($viewDescriptor['body'] instanceof \Alxarafe\ResourceController\Component\Container\AbstractContainer)
        {!! \Alxarafe\Infrastructure\Component\ComponentRenderer::render($viewDescriptor['body'], ['record' => $record]) !!}
    @endif

</form>
</div>
@endsection
