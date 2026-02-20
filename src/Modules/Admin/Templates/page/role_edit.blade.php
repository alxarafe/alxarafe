/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

@extends('partial.layout.main')

@section('content')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1>
                @if($recordId === 'new')
                    {{ \Alxarafe\Lib\Trans::_('new_role') }}
                @else
                    {{ \Alxarafe\Lib\Trans::_('edit_role') }}: {{ $role->name ?? '' }}
                @endif
            </h1>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12 text-end">
            <button class="btn btn-warning btn-sm" id="syncPermissionsBtn">
                <i class="fas fa-sync"></i> {{ \Alxarafe\Lib\Trans::_('sync_permissions') }}
            </button>
        </div>
    </div>

    <form method="POST" action="?module=Admin&controller=Role">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="{{ $recordId }}">

        {{-- Role Details --}}
        <div class="card mb-4">
            <div class="card-header">{{ \Alxarafe\Lib\Trans::_('role_details') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ \Alxarafe\Lib\Trans::_('name') }}</label>
                        <input type="text" name="name" class="form-control" value="{{ $role->name ?? '' }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ \Alxarafe\Lib\Trans::_('active') }}</label>
                        <select name="active" class="form-select">
                            <option value="1" {{ ($role->active ?? true) ? 'selected' : '' }}>{{ \Alxarafe\Lib\Trans::_('yes') }}</option>
                            <option value="0" {{ !($role->active ?? true) ? 'selected' : '' }}>{{ \Alxarafe\Lib\Trans::_('no') }}</option>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">{{ \Alxarafe\Lib\Trans::_('description') }}</label>
                        <textarea name="description" class="form-control" rows="2">{{ $role->description ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Permissions Matrix --}}
        <div class="card">
            <div class="card-header bg-primary text-white">{{ \Alxarafe\Lib\Trans::_('permissions') }}</div>
            <div class="card-body">
                <input type="hidden" name="save_permissions" value="1">
                
                @foreach($groupedPermissions ?? [] as $moduleName => $controllers)
                    <h4 class="mt-3 border-bottom pb-2">{{ $moduleName }}</h4>
                    <div class="row">
                        @foreach($controllers as $controllerName => $actions)
                            @php
                                $accessPerm = null;
                                $otherPerms = [];
                                foreach($actions as $perm) {
                                    if ($perm->action === 'doAccess') {
                                        $accessPerm = $perm;
                                    } else {
                                        $otherPerms[] = $perm;
                                    }
                                }
                                $uniqueCtrlId = md5($moduleName . $controllerName);
                            @endphp

                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border-light shadow-sm">
                                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                        <strong>{{ $controllerName }}</strong>
                                        @if($accessPerm)
                                            <div class="form-check form-switch m-0">
                                                <input class="form-check-input access-switch" type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $accessPerm->id }}" 
                                                       id="perm_{{ $accessPerm->id }}"
                                                       data-ctrl-target="{{ $uniqueCtrlId }}"
                                                       {{ in_array($accessPerm->id, $assignedPermissions ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label small fst-italic" for="perm_{{ $accessPerm->id }}">
                                                    {{ \Alxarafe\Lib\Trans::_('access') }}
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body p-2">
                                        @foreach($otherPerms as $perm)
                                            <div class="form-check">
                                                <input class="form-check-input perm-child-{{ $uniqueCtrlId }}" type="checkbox" 
                                                       name="permissions[]" 
                                                       value="{{ $perm->id }}" 
                                                       id="perm_{{ $perm->id }}"
                                                       {{ in_array($perm->id, $assignedPermissions ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label small" for="perm_{{ $perm->id }}">
                                                    {{ $perm->action }}
                                                    @if($perm->name && $perm->name !== $perm->action)
                                                        <span class="text-muted">({{ $perm->name }})</span>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                        @if(!$accessPerm)
                                            <div class="text-muted small fst-italic">
                                                {{ \Alxarafe\Lib\Trans::_('no_access_permission_found') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-4 mb-5">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> {{ \Alxarafe\Lib\Trans::_('save_changes') }}
            </button>
            <a href="?module=Admin&controller=Role" class="btn btn-secondary btn-lg">{{ \Alxarafe\Lib\Trans::_('cancel') }}</a>
        </div>
    </form>
</div>

<script>
    // Translation constants for JS
    const TXT_SYNC_CONFIRM = "{{ \Alxarafe\Lib\Trans::_('sync_permissions_confirm') }}";
    const TXT_SYNCING = "{{ \Alxarafe\Lib\Trans::_('syncing') }}";
    const TXT_SYNC_SUCCESS = "{{ \Alxarafe\Lib\Trans::_('sync_completed') }}";
    const TXT_CREATED = "{{ \Alxarafe\Lib\Trans::_('created') }}";
    const TXT_RESTORED = "{{ \Alxarafe\Lib\Trans::_('restored') }}";
    const TXT_DELETED = "{{ \Alxarafe\Lib\Trans::_('deleted') }}";
    const TXT_ERROR = "{{ \Alxarafe\Lib\Trans::_('error') }}";
    const TXT_ERROR_OCCURRED = "{{ \Alxarafe\Lib\Trans::_('error_occurred') }}";

    // Permission Logic
    document.addEventListener('DOMContentLoaded', function() {
        const switches = document.querySelectorAll('.access-switch');
        
        function updateChildrenState(switchEl) {
            const targetId = switchEl.dataset.ctrlTarget;
            const isChecked = switchEl.checked;
            const children = document.querySelectorAll('.perm-child-' + targetId);
            
            children.forEach(child => {
                child.disabled = !isChecked;
                if(!isChecked) {
                    child.checked = false;
                    child.closest('.form-check').classList.add('opacity-50');
                } else {
                    child.closest('.form-check').classList.remove('opacity-50');
                }
            });
        }

        switches.forEach(sw => {
            // Initial state
            updateChildrenState(sw);

            // Change listener
            sw.addEventListener('change', function() {
                updateChildrenState(this);
            });
        });
    });

    document.getElementById('syncPermissionsBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        if(!confirm(TXT_SYNC_CONFIRM)) return;

        const btn = this;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + TXT_SYNCING;
        btn.disabled = true;

        fetch('?module=Admin&controller=Role&action=syncPermissions')
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    let msg = TXT_SYNC_SUCCESS + '\n\n';
                    msg += TXT_CREATED + ': ' + data.report.created + '\n';
                    msg += TXT_RESTORED + ': ' + data.report.restored + '\n';
                    msg += TXT_DELETED + ': ' + data.report.deleted;
                    alert(msg);
                    location.reload();
                } else {
                    alert(TXT_ERROR + ': ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(TXT_ERROR_OCCURRED);
            })
            .finally(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
    });
</script>

@endsection
