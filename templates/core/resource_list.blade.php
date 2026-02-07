<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                @php
                    $tabId = $me->getActiveTab();
                    $columns = $config['list']['tabs'][$tabId]['columns'] ?? [];
                @endphp
                @foreach($columns as $col)
                    <th>
                        @if(is_array($col))
                            {{ $col['label'] ?? $col['field'] }}
                        @else
                            {{ $col->getLabel() }}
                        @endif
                    </th>
                @endforeach
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="resource-list-body">
            <tr>
                <td colspan="100" class="text-center">Loading data...</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const activeTab = "{{ $me->getActiveTab() }}";
    
    // Simple fetch implementation
    fetch(window.location.href + '&ajax=get_data&tab=' + activeTab)
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('resource-list-body');
            tbody.innerHTML = '';
            
            if (data.error) {
                tbody.innerHTML = '<tr><td colspan="100" class="text-center text-danger">Error: ' + data.error + '</td></tr>';
                return;
            }

            if (!data.data || data.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="100" class="text-center">No records found</td></tr>';
                return;
            }

            data.data.forEach(row => {
                const tr = document.createElement('tr');
                // Columns
                const columns = window.resourceConfig.config.list.tabs[activeTab].columns;
                columns.forEach(col => {
                    const td = document.createElement('td');
                    // Handle object columns vs array columns
                    const field = col.field || col.name; // adjust based on serialization
                    td.textContent = row[field] || '';
                    tr.appendChild(td);
                });
                
                // Actions
                const tdActions = document.createElement('td');
                // Edit link
                const editLink = document.createElement('a');
                editLink.href = '?module={{ $me::getModuleName() }}&controller={{ $me::getControllerName() }}&id=' + row.id;
                editLink.className = 'btn btn-sm btn-info';
                editLink.textContent = 'Edit';
                tdActions.appendChild(editLink);
                tr.appendChild(tdActions);
                
                tbody.appendChild(tr);
            });
        })
        .catch(err => console.error('Error loading data:', err));
});
</script>
