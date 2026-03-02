@extends('partial.layout.main')

@section('content')
    @component('component.card', ['title' => 'Error', 'name' => 'error'])
        <div class="alert alert-danger">
            <h4><i class="fas fa-exclamation-triangle"></i> Error</h4>
            <p>{{ $errorMessage ?? 'Unknown Error' }}</p>
            @if(!empty($errorTrace))
                <hr>
                <div style="max-height: 300px; overflow-y: auto; background-color: #f8f9fa; padding: 10px; border-radius: 5px;">
                    <strong>Stack Trace:</strong>
                    <pre style="white-space: pre-wrap; margin-top: 10px;">{{ $errorTrace }}</pre>
                </div>
            @endif
        </div>
        <p>Go to the <a href="index.php?module=Admin&controller=Auth">user login page</a> to access the application.</p>
        <p>You can access the settings at the following <a href="index.php?module=Admin&controller=Config">link</a>.</p>
        <div class="mt-4 border-top pt-3">
             <p class="text-muted small">If the error persists or the page looks broken, try resetting the theme:</p>
             <button onclick="document.cookie='alx_theme=default; path=/'; location.href='index.php';" class="btn btn-outline-warning">
                 <i class="fas fa-magic"></i> Resetear Tema (Modo Seguro)
             </button>
        </div>
    @endcomponent
@endsection

@push('scripts')
    {{-- <script src="https://alixar/Templates/Lib/additional-script.js"></script> --}}
@endpush
