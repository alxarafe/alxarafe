@extends('partial.layout.main')

@section('content')
<x-layout.container class="mt-5">
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
                <x-component.card class="shadow-sm mb-4">
                    <x-slot:title>
                        <i class="fas fa-tags me-2"></i> Metadata (FrontMatter)
                    </x-slot:title>
                    
                    <table class="table table-sm mb-0">
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
                </x-component.card>

                <x-component.card class="shadow-sm mb-4">
                    <x-slot:title>
                        <i class="fas fa-file-code me-2"></i> Información del Archivo
                    </x-slot:title>
                    <div class="small">
                        <strong>Ruta:</strong><br>
                        <code>{{ $filePath }}</code>
                    </div>
                </x-component.card>
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
                <div class="tab-content border rounded p-4 shadow-sm" id="markdownTabsContent">
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
</x-layout.container>

<style>
.post-content {
    font-size: 1.1rem;
}
</style>
@endsection

