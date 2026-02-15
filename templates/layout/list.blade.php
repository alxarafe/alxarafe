@extends('partial.layout.main')

@section('header_actions')
    <!-- Action Toolbar (Native Blade Placement) -->
    <!-- Kept IDs for JS binding -->
    <div class="btn-group me-2" id="alxarafe-toolbar-left"></div>
    <div class="d-flex gap-2" id="alxarafe-toolbar-right"></div>
@endsection

@section('content')
<div class="alxarafe-resource-list animate__animated animate__fadeIn">
    
    <!-- Tabs Navigation (if multiple) -->
    <div id="alxarafe-tabs-container">
        <!-- Tabs injected via JS -->
    </div>

    <!-- Toolbar moved to header_actions section -->

    <!-- Collapsible Filters Panel (Default Open) -->
    <div class="card border mb-3 shadow-sm" id="alxarafe-filters-container">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
                style="cursor: pointer;"
                data-bs-toggle="collapse" 
                data-bs-target="#alxarafe-filters-collapse" 
                aria-expanded="true">
            <h6 class="mb-0 text-primary"><i class="fas fa-search me-2"></i>Filtros de búsqueda</h6>
            <i class="fas fa-chevron-up text-muted"></i>
        </div>
        <div class="collapse show" id="alxarafe-filters-collapse">
            <div class="card-body bg-light">
                <div class="row g-2" id="alxarafe-filters-row">
                    <!-- Filters injected here via JS -->
                </div>
            </div>
        </div>
    </div>

    <div class="card border shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <!-- Added table-striped for "pijama" effect -->
                <table class="table table-striped table-hover align-middle mb-0" id="alxarafe-table">
                    <thead class="bg-light text-secondary text-uppercase small fw-bold">
                        <tr id="alxarafe-table-head">
                            <!-- Headers injected via JS -->
                        </tr>
                    </thead>
                    <tbody id="alxarafe-table-body" class="border-top-0">
                        <!-- Rows injected here via JS -->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4" id="alxarafe-pagination">
            <!-- Pagination injected here via JS -->
        </div>
    </div>
</div>
@endsection
