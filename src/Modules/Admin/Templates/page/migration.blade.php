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

@section('header_actions')
    <button id="startProcess" class="btn btn-primary" type="button" {{ $pendingCount === 0 ? 'disabled' : '' }}>
        <i class="fas fa-play me-2"></i> {{ $me->_('migration_start_process') }}
    </button>
@endsection

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-white"><i class="fas fa-database me-2"></i>{{ $me->_('migration_status_title') }}</h5>
        </div>
        <div class="card-body">
            @php
                $pendingCount = 0;
                foreach($allMigrationsWithStatus as $data) {
                    if($data['status'] === 'pending') $pendingCount++;
                }
            @endphp
            
            @if($pendingCount === 0)
                <div class="alert alert-success d-flex align-items-center mb-3">
                    <i class="fas fa-check-circle fa-2x me-3"></i>
                    <div>
                        <strong>{{ $me->_('migration_all_ok') }}</strong><br>
                        {{ $me->_('migration_no_pending') }}
                    </div>
                </div>
            @else
                <div class="alert alert-warning d-flex align-items-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <strong>{{ $me->_('migration_attention_needed') }}</strong><br>
                        {{ $me->_('migration_pending_count', ['count' => $pendingCount]) }}
                    </div>
                </div>
            @endif

            <div class="list-group mb-4 shadow-sm">
                @foreach($allMigrationsWithStatus as $key => $data)
                    @php
                        $parts = explode('@', $key);
                        $class = $parts[0] ?? $key;
                        $module = $parts[1] ?? 'Unknown';
                        $isPending = $data['status'] === 'pending';
                    @endphp
                    <div class="list-group-item d-flex justify-content-between align-items-center migration-item" 
                         data-key="{{ $key }}" 
                         data-module="{{ $module }}" 
                         data-class="{{ $class }}"
                         data-status="{{ $data['status'] }}">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($isPending)
                                    <i class="fas fa-clock text-warning fa-lg"></i>
                                @else
                                    <i class="fas fa-check-circle text-success fa-lg"></i>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $module }} <small class="text-muted fw-normal">:: {{ $class }}</small></h6>
                                <small class="text-muted font-monospace" style="font-size: 0.85em;">{{ basename($data['path']) }}</small>
                            </div>
                        </div>
                        <div>
                            <span class="badge {{ $isPending ? 'bg-warning text-dark' : 'bg-success' }} status-badge rounded-pill">
                                @if($isPending)
                                    {{ $me->_('migration_pending') }}
                                @else
                                    {{ $me->_('migration_completed') }}
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>


            
            <div id="results-log" class="mt-3"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        document.getElementById('startProcess').addEventListener('click', function () {
            const btn = this;
            const log = document.getElementById('results-log');
            const pendingItems = document.querySelectorAll('.migration-item[data-status="pending"]');

            if (pendingItems.length === 0) {
                return;
            }

            // UI Reset
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> {{ $me->_('migration_processing') }}...';
            log.innerHTML = '';

            let currentIndex = 0;

            const executeNext = () => {
                if (currentIndex >= pendingItems.length) {
                    btn.innerHTML = '<i class="fas fa-check me-2"></i> {{ $me->_('migration_finished') }}';
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-success');
                    
                     // Add simple success message
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success mt-3';
                    successAlert.innerHTML = '<i class="fas fa-check-circle"></i> {{ $me->_('migration_all_finished') }}';
                    log.appendChild(successAlert);
                    
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                    return;
                }

                const item = pendingItems[currentIndex];
                const module = item.getAttribute('data-module');
                const cls = item.getAttribute('data-class');
                const badge = item.querySelector('.status-badge');
                const iconContainer = item.querySelector('.fas.fa-clock, .fas.fa-check-circle').parentNode;

                // Update UI to "Running"
                badge.className = 'badge bg-info text-dark status-badge rounded-pill';
                badge.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> {{ $me->_('migration_processing') }}';
                
                // Update params for Request
                const params = new URLSearchParams();
                params.append('module', module);
                params.append('class', cls);

                fetch('{!! $me->url() !!}&action=ExecuteProcess', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: params
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                         // Update Badge
                         badge.className = 'badge bg-success status-badge rounded-pill';
                         badge.innerHTML = '{{ $me->_('migration_completed') }}';
                         
                         // Update Icon
                         // Find the icon element effectively
                         const icon = item.querySelector('.fa-clock') || item.querySelector('.fa-spinner');
                         if(icon) {
                             icon.className = 'fas fa-check-circle text-success fa-lg';
                         }
                         
                         item.setAttribute('data-status', 'completed');
                    } else {
                         badge.className = 'badge bg-danger status-badge rounded-pill';
                         badge.textContent = '{{ $me->_('migration_error_badge') }}';
                         
                         const errDiv = document.createElement('div');
                         errDiv.className = 'alert alert-danger mt-1 small';
                         // We construct the error string manually or fetch a translated string if specific
                         // Here we use a generic translated format for JS
                         let errText = '{{ $me->_('migration_error_detail') }}';
                         errText = errText.replace('%module%', module).replace('%class%', cls).replace('%message%', data.message);

                         errDiv.textContent = errText;
                         log.appendChild(errDiv);
                    }
                    currentIndex++;
                    executeNext();
                })
                .catch(err => {
                    badge.className = 'badge bg-danger status-badge rounded-pill';
                    badge.textContent = '{{ $me->_('migration_fail_badge') }}';
                    
                    const errDiv = document.createElement('div');
                    errDiv.className = 'alert alert-danger mt-1 small';
                    
                    let errText = '{{ $me->_('migration_network_error') }}';
                    errText = errText.replace('%module%', module).replace('%class%', cls);

                    errDiv.textContent = errText;
                    log.appendChild(errDiv);
                    
                    currentIndex++;
                    executeNext();
                });
            };

            executeNext();
        });
    </script>@endpush
