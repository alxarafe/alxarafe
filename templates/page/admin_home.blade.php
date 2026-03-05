@extends('partial.layout.main')

@section('content')
@php
    $title = $title ?? \Alxarafe\Lib\Trans::_('admin_dashboard');
@endphp

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1"><i class="fas fa-cogs me-2"></i>{{ $title }}</h2>
            <p class="text-muted">{{ \Alxarafe\Lib\Trans::_('admin_dashboard_description') }}</p>
        </div>
    </div>

    <div class="row g-4">
        {{-- Configuration --}}
        <div class="col-md-6 col-lg-4">
            <a href="index.php?module=Admin&controller=Config" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-cogs fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">{{ \Alxarafe\Lib\Trans::_('Config') }}</h5>
                        <p class="card-text text-muted small">{{ \Alxarafe\Lib\Trans::_('config_description') }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Modules --}}
        <div class="col-md-6 col-lg-4">
            <a href="index.php?module=Admin&controller=Module" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-puzzle-piece fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title">{{ \Alxarafe\Lib\Trans::_('Modules') }}</h5>
                        <p class="card-text text-muted small">{{ \Alxarafe\Lib\Trans::_('modules_description') }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Users --}}
        <div class="col-md-6 col-lg-4">
            <a href="index.php?module=Admin&controller=User" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-users fa-3x text-info"></i>
                        </div>
                        <h5 class="card-title">{{ \Alxarafe\Lib\Trans::_('users') }}</h5>
                        <p class="card-text text-muted small">{{ \Alxarafe\Lib\Trans::_('users_description') }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Roles --}}
        <div class="col-md-6 col-lg-4">
            <a href="index.php?module=Admin&controller=Role" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-user-shield fa-3x text-warning"></i>
                        </div>
                        <h5 class="card-title">{{ \Alxarafe\Lib\Trans::_('roles') }}</h5>
                        <p class="card-text text-muted small">{{ \Alxarafe\Lib\Trans::_('roles_description') }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Migrations --}}
        <div class="col-md-6 col-lg-4">
            <a href="index.php?module=Admin&controller=Migration" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-bolt fa-3x text-danger"></i>
                        </div>
                        <h5 class="card-title">{{ \Alxarafe\Lib\Trans::_('Migrations') }}</h5>
                        <p class="card-text text-muted small">{{ \Alxarafe\Lib\Trans::_('migrations_description') }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Dictionaries --}}
        <div class="col-md-6 col-lg-4">
            <a href="index.php?module=Admin&controller=Dictionary" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm hover-shadow">
                    <div class="card-body text-center py-4">
                        <div class="mb-3">
                            <i class="fas fa-book fa-3x text-secondary"></i>
                        </div>
                        <h5 class="card-title">{{ \Alxarafe\Lib\Trans::_('Dictionaries') }}</h5>
                        <p class="card-text text-muted small">{{ \Alxarafe\Lib\Trans::_('dictionaries_description') }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.hover-shadow {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-shadow:hover {
    transform: translateY(-4px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,.15) !important;
}
</style>
@endsection
