@props([
    'field' => '',
    'label' => '',
    'columns' => [],
    'value' => [],
    'name' => '',
])

@php
    $rows = is_array($value) ? $value : [];
    // Clean up $field for ID/JS usage: replace dots with dashes
    $cleanField = str_replace(['.', '[', ']'], '-', $field);
    $tableId = 'relation-table-' . $cleanField;
    // Base name for inputs. If $name is provided (e.g. data[roles]), use it.
    // Otherwise fallback to data[$field].
    $finalName = !empty($name) ? $name : 'data[' . $field . ']';
    // JavaScript-safe function name (replace dots with underscores)
    $jsFuncName = 'addRelationRow_' . str_replace(['.', '[', ']'], '_', $field);
@endphp

<div class="relation-list-container mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <label class="form-label fw-bold text-secondary mb-0">{{ $label }}</label>
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="{{ $jsFuncName }}()">
            <i class="fas fa-plus"></i> Añadir
        </button>
    </div>
    
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="{{ $tableId }}">
                <thead class="bg-light">
                    <tr>
                        @foreach($columns as $col)
                            @php
                                $colLabel = is_array($col) ? ($col['label'] ?? $col['field']) : ucfirst($col);
                            @endphp
                            <th class="small text-muted border-0 ps-3">{{ $colLabel }}</th>
                        @endforeach
                        <th class="small text-muted border-0 text-end pe-3" style="width: 50px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $index => $row)
                        @php
                            $row = (array)$row;
                        @endphp
                        <tr>
                            @foreach($columns as $col)
                                @php
                                    $colPath = is_array($col) ? $col['field'] : $col;
                                    $val = $row[$colPath] ?? '';
                                    $inputType = (is_array($col) && ($col['type'] ?? '') === 'number') ? 'number' : 'text';
                                    $inputName = $finalName . '[' . $index . '][' . $colPath . ']';
                                @endphp
                                <td class="ps-3 py-2 small">
                                    <input type="{{ $inputType }}" 
                                           class="form-control form-control-sm" 
                                           name="{{ $inputName }}" 
                                           value="{{ $val }}">
                                </td>
                            @endforeach
                            <td class="text-end pe-3 py-2">
                                @if(isset($row['id']))
                                    <input type="hidden" name="{{ $finalName }}[{{ $index }}][id]" value="{{ $row['id'] }}">
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRelationRow(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($rows) === 0)
                        <tr class="empty-row text-center">
                            <td colspan="{{ count($columns) + 1 }}" class="py-4 text-muted small">
                                Sin registros. Haz clic en "Añadir" para empezar.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    if (typeof window['{{ $jsFuncName }}'] === 'undefined') {
        window['{{ $jsFuncName }}'] = function() {
            const table = document.getElementById('{{ $tableId }}');
            const tbody = table.querySelector('tbody');
            
            // Remove "Sin registros" row if present
            const emptyRow = tbody.querySelector('.empty-row');
            if (emptyRow) emptyRow.remove();
            
            const index = Date.now();
            const row = document.createElement('tr');
            
            let html = '';
            @foreach($columns as $col)
                @php
                    $colPath = is_array($col) ? $col['field'] : $col;
                    $inputType = (is_array($col) && ($col['type'] ?? '') === 'number') ? 'number' : 'text';
                @endphp
                html += '<td class="ps-3 py-2 small">';
                html += '<input type="{{ $inputType }}" class="form-control form-control-sm" name="{{ $finalName }}[' + index + '][{{ $colPath }}]" value="">';
                html += '</td>';
            @endforeach
            
            html += '<td class="text-end pe-3 py-2">';
            html += '<button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRelationRow(this)">';
            html += '<i class="fas fa-trash"></i>';
            html += '</button>';
            html += '</td>';
            
            row.innerHTML = html;
            tbody.appendChild(row);
            
            if (typeof window.alxarafe_unsaved_changes !== 'undefined') {
                window.alxarafe_unsaved_changes = true;
            }
        };
    }

    if (typeof window.removeRelationRow === 'undefined') {
        window.removeRelationRow = function(btn) {
            const tr = btn.closest('tr');
            const table = tr.closest('table');
            
            // Soft delete/Logic for backend sync
            const isDel = tr.classList.contains('table-danger');
            if (isDel) {
                tr.classList.remove('table-danger', 'text-decoration-line-through');
                tr.style.opacity = '1';
                tr.querySelectorAll('input').forEach(i => i.disabled = false);
                btn.className = 'btn btn-sm btn-outline-danger';
                btn.innerHTML = '<i class="fas fa-trash"></i>';
            } else {
                tr.classList.add('table-danger', 'text-decoration-line-through');
                tr.style.opacity = '0.6';
                tr.querySelectorAll('input').forEach(i => i.disabled = true);
                btn.className = 'btn btn-sm btn-outline-secondary';
                btn.innerHTML = '<i class="fas fa-undo"></i>';
            }
            
            if (typeof window.alxarafe_unsaved_changes !== 'undefined') {
                window.alxarafe_unsaved_changes = true;
            }
        };
    }
</script>
