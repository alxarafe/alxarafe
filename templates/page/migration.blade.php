@extends('partial.layout.main')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            @php
                $pendingCount = 0;
                foreach($allMigrationsWithStatus as $data) {
                    if($data['status'] === 'pending') $pendingCount++;
                }
            @endphp

            @if($pendingCount === 0)
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> La base de datos está actualizada.
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Hay {{ $pendingCount }} migraciones pendientes.
                </div>
            @endif
                
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">Estado</th>
                        <th>Migración</th>
                        <th>Módulo</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allMigrationsWithStatus as $key => $data)
                        @php
                            [$class, $module] = explode('@', $key);
                            $isPending = $data['status'] === 'pending';
                            $rowClass = $isPending ? 'table-warning pending-row' : 'text-muted';
                            $icon = $isPending ? 'fa-clock text-warning' : 'fa-check text-success';
                        @endphp
                        <tr class="{{ $rowClass }}" data-migration="{{ $key }}">
                            <td class="text-center"><i class="fas {{ $icon }} status-icon"></i></td>
                            <td>{{ $class }}</td>
                            <td><span class="badge {{ $isPending ? 'bg-primary' : 'bg-secondary' }}">{{ $module }}</span></td>
                            <td class="small">{{ basename($data['path']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if($pendingCount > 0)
            <div id="progress-container" style="display:none;" class="mb-3">
                <label>Procesando...</label>
                <div class="progress">
                    <div id="migration-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                </div>
                <div id="migration-log" class="mt-2 text-muted font-monospace small"></div>
            </div>
            @endif
        </div>
    </div>
@endsection

@section('header_actions')
    @if(isset($pendingCount) && $pendingCount > 0)
        <button type="button" class="btn btn-primary me-2" id="btn-run-migrations">
            <i class="fas fa-sync"></i> Ejecutar Pendientes
        </button>
    @endif
    <a href="{{ $me->url('Admin', 'Config', 'general') }}" class="btn btn-secondary">
        <i class="fas fa-close"></i> Cerrar
    </a>
@endsection


@push('scripts')
<script>
document.getElementById('btn-run-migrations')?.addEventListener('click', function() {
    const btn = this;
    const container = document.getElementById('progress-container');
    const bar = document.getElementById('migration-progress-bar');
    const log = document.getElementById('migration-log');
    
    // UI Update
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Ejecutando...';
    container.style.display = 'block';
    log.innerHTML = 'Iniciando proceso...';

    fetch('{{ $me->url('Admin', 'Migration', 'run_batch_ajax') }}')
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                bar.classList.remove('progress-bar-animated');
                bar.classList.add('bg-success');
                log.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check"></i> Proceso finalizado correctamente.</span>';
                
                // Update rows visually
                document.querySelectorAll('.pending-row').forEach(row => {
                    row.classList.remove('table-warning', 'pending-row');
                    row.classList.add('table-success'); // Briefly green then fade if needed
                    const icon = row.querySelector('.status-icon');
                    if(icon) {
                        icon.classList.remove('fa-clock', 'text-warning');
                        icon.classList.add('fa-check', 'text-success');
                    }
                });
                
                setTimeout(() => window.location.reload(), 2000);
            } else {
                bar.classList.add('bg-danger');
                log.innerHTML = '<span class="text-danger fw-bold">Error: ' + data.message + '</span>';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync"></i> Reintentar';
            }
        })
        .catch(error => {
            bar.classList.add('bg-danger');
            log.innerHTML = '<span class="text-danger fw-bold">Error de comunicación: ' + error + '</span>';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync"></i> Reintentar';
        });
});
</script>
@endpush
