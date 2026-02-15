@extends('partial.layout.main')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4">{{ $active_module_title ?? 'Chascarrillos' }}</h1>
            <p class="lead">Bienvenido al blog de humor y anécdotas.</p>
        </div>
    </div>

    <div class="row">
        @if(isset($posts) && count($posts) > 0)
            @foreach($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ \Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }}</h6>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($post->content, 100) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="{{ static::url('show', ['slug' => $post->slug]) }}" class="btn btn-outline-primary btn-sm">Leer más</a>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> No hay chascarrillos publicados todavía.
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
