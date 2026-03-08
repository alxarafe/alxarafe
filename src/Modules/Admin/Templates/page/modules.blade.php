@extends('partial.layout.main')

@section('header_actions')
    <div class="btn-group">
        <button id="btn-enable-all" class="btn btn-outline-success">
            <i class="fas fa-check-double me-1"></i> {{ \Alxarafe\Lib\Trans::_('enable_all') }}
        </button>
        <button id="btn-disable-all" class="btn btn-outline-danger">
            <i class="fas fa-times-circle me-1"></i> {{ \Alxarafe\Lib\Trans::_('disable_all') }}
        </button>
    </div>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4" id="modules-container">
        @foreach($modules as $module)
            <div class="col module-card" data-module="{{ $module['name'] }}">
                <div class="card h-100 border-0 shadow-sm transition-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="module-icon-container bg-light rounded p-3 me-3">
                                <i class="{{ $module['icon'] }} fa-2x {{ $module['enabled'] ? 'text-primary' : 'text-muted' }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0 d-flex align-items-center">
                                    {{ $module['name'] }}
                                    @if($module['is_core'])
                                        <span class="badge bg-secondary ms-2 small" style="font-size: 0.6rem;">CORE</span>
                                    @endif
                                </h5>
                                <small class="text-muted">{{ $module['namespace'] }}</small>
                            </div>
                            <div class="form-check form-switch ms-3">
                                <input class="form-check-input module-toggle" type="checkbox" 
                                       {{ $module['enabled'] ? 'checked' : '' }} 
                                       {{ $module['is_core'] ? 'disabled' : '' }}
                                       id="switch-{{ $module['name'] }}">
                            </div>
                        </div>
                        
                        <p class="card-text text-muted small" style="height: 3rem; overflow: hidden;">
                            {{ $module['description'] ?: \Alxarafe\Lib\Trans::_('no_description_available') }}
                        </p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <div class="dependencies-info small text-secondary">
                                @if(!empty($module['requires']))
                                    <i class="fas fa-link me-1" title="Requires"></i> {{ count($module['requires']) }}
                                @endif
                            </div>
                            
                            <div class="action-buttons">
                                @if($module['enabled'] && $module['setup_url'])
                                    <a href="{{ $module['setup_url'] }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-cog"></i> {{ \Alxarafe\Lib\Trans::_('setup') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .transition-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .transition-hover:hover { transform: translateY(-4px); box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important; }
    .module-icon-container { width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.module-toggle');
    const container = document.getElementById('modules-container');

    const handleToggle = async (moduleName, checkbox, force = 0) => {
        try {
            const response = await fetch('index.php?module=Admin&controller=Module&action=toggle', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `module=${encodeURIComponent(moduleName)}&force=${force}`
            });
            const data = await response.json();

            if (data.status === 'confirm_cascade') {
                if (confirm(data.message)) {
                    await handleToggle(moduleName, checkbox, 1);
                } else {
                    checkbox.checked = !checkbox.checked;
                }
            } else if (data.status === 'confirm_enable_deps') {
                 if (confirm(data.message)) {
                    await handleToggle(moduleName, checkbox, 1);
                } else {
                    checkbox.checked = !checkbox.checked;
                }
            } else if (data.status === 'success') {
                location.reload(); // Reload to see changes and menu updates
            } else {
                alert(data.message || 'Error occurred');
                checkbox.checked = !checkbox.checked;
            }
        } catch (error) {
            console.error(error);
            alert('Communication error');
            checkbox.checked = !checkbox.checked;
        }
    };

    toggles.forEach(toggle => {
        toggle.addEventListener('change', (e) => {
            const moduleName = e.target.closest('.module-card').dataset.module;
            handleToggle(moduleName, e.target);
        });
    });

    // Bulk Actions
    const bulkAction = async (action) => {
        if (!confirm('Are you sure?')) return;
        try {
            const response = await fetch(`index.php?module=Admin&controller=Module&action=${action}`, { method: 'POST' });
            const data = await response.json();
            if (data.status === 'success') location.reload();
            else alert(data.message);
        } catch (e) { alert('Error occurred'); }
    };

    document.getElementById('btn-enable-all')?.addEventListener('click', () => bulkAction('enableAll'));
    document.getElementById('btn-disable-all')?.addEventListener('click', () => bulkAction('disableAll'));
});
</script>
@endsection
