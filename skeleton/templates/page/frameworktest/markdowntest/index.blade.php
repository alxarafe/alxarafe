@extends('layout.public')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4"><i class="fab fa-markdown"></i> Markdown Service Test</h1>
            <p class="lead">Página de prueba para el procesamiento de archivos Markdown con FrontMatter y bloques especiales.</p>
            <hr>
        </div>
    </div>

    @if(isset($error))
        <div class="alert alert-danger">
            <strong>Error:</strong> {{ $error }}
        </div>
    @else
        <div class="row">
            <!-- Sidebar with Meta -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white d-flex align-items-center">
                        <i class="fas fa-tags me-2"></i>
                        Metadata (FrontMatter)
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tbody>
                                @foreach($meta as $key => $value)
                                    <tr>
                                        <th class="text-muted">{{ ucfirst($key) }}</th>
                                        <td>
                                            @if(is_array($value))
                                                @foreach($value as $val)
                                                    <span class="badge bg-secondary">{{ $val }}</span>
                                                @endforeach
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <i class="fas fa-file-code me-2"></i>
                        Información del Archivo
                    </div>
                    <div class="card-body small">
                        <strong>Ruta:</strong><br>
                        <code>{{ $filePath }}</code>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-8">
                <ul class="nav nav-tabs mb-3" id="markdownTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="rendered-tab" data-bs-toggle="tab" data-bs-target="#rendered" type="button" role="tab" aria-controls="rendered" aria-selected="true">
                            <i class="fas fa-eye"></i> Renderizado
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="raw-tab" data-bs-toggle="tab" data-bs-target="#raw" type="button" role="tab" aria-controls="raw" aria-selected="false">
                            <i class="fas fa-code"></i> Markdown Raw
                        </button>
                    </li>
                </ul>
                <div class="tab-content border rounded p-4 bg-white shadow-sm" id="markdownTabsContent">
                    <div class="tab-pane fade show active post-content" id="rendered" role="tabpanel" aria-labelledby="rendered-tab">
                        {!! $contentHtml !!}
                    </div>
                    <div class="tab-pane fade" id="raw" role="tabpanel" aria-labelledby="raw-tab">
                        <pre class="m-0"><code>{{ $contentRaw }}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
/* Estilos adicionales si fueran necesarios, aunque ya están en alxarafe-content.css */
.post-content {
    color: #334155;
    font-size: 1.1rem;
}
.tab-pane pre {
    background: #f8fafc;
    color: #1e293b;
    border: 1px solid #e2e8f0;
}
</style>
@endsection
