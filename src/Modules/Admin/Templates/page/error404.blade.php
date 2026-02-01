@extends('partial.layout.main')

@section('content')
    @component('component.card', ['title' => 'Public page', 'name' => 'public'])
        <p>The requested page has not been found!</p>
        <p>Go to the <a href="index.php?module=Admin&controller=Auth">user login page</a> to access the application.</p>
        <p>You can access the settings at the following <a href="index.php?module=Admin&controller=Config">link</a>.</p>
    @endcomponent
@endsection

@push('scripts')
    {{-- <script src="https://alixar/Templates/Lib/additional-script.js"></script> --}}
@endpush
