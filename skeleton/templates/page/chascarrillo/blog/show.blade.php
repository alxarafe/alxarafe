@extends('partial.layout.main')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ \Modules\Chascarrillo\Controller\BlogController::url('index') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <article>
                <header class="mb-4">
                    <h1 class="fw-bolder mb-1">{{ $post->title }}</h1>
                    <div class="text-muted fst-italic mb-2">Publicado el {{ \Carbon\Carbon::parse($post->published_at)->format('d F, Y') }}</div>
                </header>
                
                <section class="mb-5">
                    {!! nl2br(e($post->content)) !!}
                </section>
            </article>
            
            <div class="mt-5 mb-5 text-center">
                <a href="{{ \Modules\Chascarrillo\Controller\BlogController::url('index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Volver al listado
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
