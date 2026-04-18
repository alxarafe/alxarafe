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
                    <i class="fas fa-check-circle"></i> {{ $me->_('migration_all_ok') }}
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> {{ $me->_('migration_pending_count', ['count' => $pendingCount]) }}
                </div>
            @endif
                
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">{{ $me->_('status') }}</th>
                        <th>{{ $me->_('migration') }}</th>
                        <th>{{ $me->_('module') }}</th>
                        <th>{{ $me->_('file') }}</th>
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
                <label>{{ $me->_('processing') }}</label>
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
            <i class="fas fa-sync"></i> {{ $me->_('run_pending') }}
        </button>
    @endif
    <a href="{{ $me->url('Admin', 'Config', 'general') }}" class="btn btn-secondary">
        <i class="fas fa-close"></i> {{ $me->_('close') }}
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
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ $me->_("running") }}';
    container.style.display = 'block';
    log.innerHTML = '{{ $me->_("starting_process") }}';

    fetch('{{ $me->url('Admin', 'Migration', 'run_batch_ajax') }}')
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                bar.classList.remove('progress-bar-animated');
                bar.classList.add('bg-success');
                log.innerHTML = '<span class="text-success fw-bold"><i class="fas fa-check"></i> {{ $me->_("process_completed") }}</span>';
                
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
                log.innerHTML = '<span class="text-danger fw-bold">{{ $me->_("error") }}: ' + data.message + '</span>';
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-sync"></i> {{ $me->_("retry") }}';
            }
        })
        .catch(error => {
            bar.classList.add('bg-danger');
            log.innerHTML = '<span class="text-danger fw-bold">{{ $me->_("communication_error", ["error" => ""]) }}' + error + '</span>';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sync"></i> {{ $me->_("retry") }}';
        });
});
</script>
@endpush
