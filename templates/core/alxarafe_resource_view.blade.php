@extends('partial.layout.main')

@section('content')
    <div id="alxarafe-resource-container" class="mt-3"></div>

    <script src="/js/resource.bundle.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            try {
                var config = JSON.parse(atob("{{ $me->viewConfig }}"));
                console.log('Resource Config:', config);
                new AlxarafeResource.AlxarafeResource(document.getElementById('alxarafe-resource-container'), config);
            } catch(e) {
                console.error('Error initializing AlxarafeResource:', e);
                document.getElementById('alxarafe-resource-container').innerHTML = '<div class="alert alert-danger">Error initializing application: ' + e.message + '</div>';
            }
        });
    </script>
@endsection
