@extends('partial.layout.main')

@section('content')
<x-layout.container class="py-5">
    <div class="row mb-5 text-center">
        <div class="col-12">
            <h1 class="display-3 fw-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-info">
                {{ $title }}
            </h1>
            <p class="lead">Explora la potencia visual y funcional de los componentes modernizados de Alxarafe.</p>
            <div class="d-flex justify-content-center gap-2 mt-4 flex-wrap">
                <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-bolt me-1"></i> Blade 10+</span>
                <span class="badge bg-dark px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-layer-group me-1"></i> Panels</span>
                <span class="badge bg-info px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-magic me-1"></i> Zero-JS Pattern</span>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm"><i class="fas fa-palette me-1"></i> Full Customization</span>
            </div>
        </div>
    </div>

    @php
        $sections = $me->getFields('edit');
        $record = $me->fetchRecordData();
        $recordData = $record['data'] ?? [];
    @endphp

    <x-form.form method="POST" action="#" class="row g-4 justify-content-center">
        @foreach($sections as $sectionId => $section)
            @php
                $sectionLabel = $section['label'] ?? '';
                $sectionFields = $section['fields'] ?? [];
                
                // Visual heuristics for the showcase layout
                $colClass = 'col-12';
                if (str_contains(strtolower($sectionLabel), 'principal')) $colClass = 'col-lg-7';
                elseif (str_contains(strtolower($sectionLabel), 'estética')) $colClass = 'col-lg-5';
                elseif (str_contains(strtolower($sectionLabel), 'cuantitativos')) $colClass = 'col-md-6';
                elseif (str_contains(strtolower($sectionLabel), 'cronología')) $colClass = 'col-md-6';
                elseif (str_contains(strtolower($sectionLabel), 'avanzado')) $colClass = 'col-12';
            @endphp
            
            <div class="{{ $colClass }}">
                <x-component.card class="h-100 shadow-sm border-0 overflow-hidden">
                    <x-slot:title>
                        <span class="d-flex align-items-center">
                            {{ $sectionLabel }}
                        </span>
                    </x-slot:title>
                    
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach($sectionFields as $field)
                                @php
                                    $fieldName = $field->getField();
                                    $currentValue = $recordData[$fieldName] ?? null;
                                    // Individual field layout
                                    $fieldCol = 'col-12';
                                    if ($field instanceof \Alxarafe\Component\Fields\Boolean) $fieldCol = 'col-md-6';
                                    if ($field instanceof \Alxarafe\Component\Fields\Integer) $fieldCol = 'col-md-6';
                                    if ($field instanceof \Alxarafe\Component\Fields\Date) $fieldCol = 'col-md-4';
                                    if ($field instanceof \Alxarafe\Component\Fields\DateTime) $fieldCol = 'col-md-5';
                                    if ($field instanceof \Alxarafe\Component\Fields\Time) $fieldCol = 'col-md-3';
                                @endphp
                                <div class="{{ $fieldCol }} mb-2">
                                    {!! $field->render(['value' => $currentValue]) !!}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </x-component.card>
            </div>
        @endforeach

        <div class="col-12 mt-5 text-center">
            <hr class="mb-5 opacity-10">
            <button type="button" class="btn btn-primary btn-lg px-5 py-3 shadow-lg rounded-pill" onclick="alert('¡Demostración capturada! Esta es una vista previa de cómo Alxarafe renderiza cualquier modelo de datos con elegancia.')">
                <i class="fas fa-rocket me-2"></i> Confirmar Visualización
            </button>
            <p class="text-muted small mt-3">Prueba a cambiar el tema para ver cómo este mismo formulario se adapta instantáneamente.</p>
        </div>
    </x-form.form>
</x-layout.container>

<style>
    :root {
        --glass-bg: rgba(255, 255, 255, 0.7);
    }
    
    .bg-clip-text {
        -webkit-background-clip: text;
        background-clip: text;
    }
    .text-transparent {
        color: transparent;
    }
    .bg-gradient-to-r {
        background-image: linear-gradient(to right, #0d6efd, #0dcaf0);
    }
    
    .card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
    }
    
    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1.5rem 4rem rgba(0,0,0,.12)!important;
    }
    
    .card-header {
        background: rgba(0,0,0,0.02) !important;
        border-bottom: 1px solid rgba(0,0,0,.08) !important;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.8rem;
        padding: 1rem 1.25rem !important;
        color: #495057 !important;
    }

    [data-theme="cyberpunk"] .bg-gradient-to-r {
        background-image: linear-gradient(to right, #fcee0a, #00f0ff);
    }
    
    [data-theme="cyberpunk"] .card {
        background: rgba(0, 0, 0, 0.8);
        border: 2px solid #fcee0a !important;
    }
    
    [data-theme="cyberpunk"] .card-header {
        background: #fcee0a !important;
        color: black !important;
    }

    /* Animation */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .col-lg-7, .col-lg-5, .col-md-6, .col-12 {
        animation: fadeInUp 0.6s ease-out forwards;
    }
</style>
@endsection
