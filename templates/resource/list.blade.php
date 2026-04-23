@extends('partial.layout.main')

@section('header_actions')
    <div class="btn-group me-2" id="alxarafe-toolbar-left"></div>
    <div class="d-flex gap-2" id="alxarafe-toolbar-right"></div>
@endsection

@section('content')
    <div id="alxarafe-resource-container" class="mt-3"></div>
    <script src="/js/resource.bundle.js?v={{ time() }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                var config = JSON.parse(atob("{!! base64_encode(json_encode($jsConfig ?? $config ?? [])) !!}"));
                new AlxarafeResource.AlxarafeResource(document.getElementById('alxarafe-resource-container'), config);
            } catch(e) { console.error(e); }
        });
    </script>
@endsection
