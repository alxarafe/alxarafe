<form id="resource-form" method="POST">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="{{ $me->recordId }}">
    
    <div id="form-alerts"></div>

    @foreach($config['edit']['sections'] ?? [] as $section)
        <div class="card mb-3">
            <div class="card-header">{{ $section['title'] }}</div>
            <div class="card-body">
                @foreach($section['fields'] as $field)
                    <div class="mb-3">
                        <label class="form-label">
                            @if(is_array($field))
                                {{ $field['label'] ?? $field['field'] }}
                            @else
                                {{ $field->getLabel() }}
                            @endif
                        </label>
                        <!-- Basic Input fallback, ideally use components but string concat is easier here for MVP -->
                        @php
                            $fieldName = is_array($field) ? $field['field'] : $field->getField();
                            $fieldType = is_array($field) ? ($field['type'] ?? 'text') : $field->getType();
                        @endphp
                        
                        @php
                            $inputType = 'text';
                            if ($fieldType === 'number' || $fieldType === 'integer' || $fieldType === 'decimal') {
                                $inputType = 'number';
                            } elseif ($fieldType === 'date') {
                                $inputType = 'date';
                            } elseif ($fieldType === 'datetime' || $fieldType === 'datetime-local') {
                                $inputType = 'datetime-local';
                            }
                        @endphp
                        
                        <input type="{{ $inputType }}" class="form-control" 
                               name="data[{{ $fieldName }}]" 
                               id="field_{{ $fieldName }}">
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <button type="submit" class="btn btn-primary">Save</button>
    <a href="?module={{ $me::getModuleName() }}&controller={{ $me::getControllerName() }}" class="btn btn-secondary">Cancel</a>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const recordId = "{{ $me->recordId }}";
    
    if (recordId !== 'new') {
        // Load Data
        fetch(window.location.href + '&ajax=get_record')
            .then(response => response.json())
            .then(data => {
                if(data.error) {
                    alert(data.error);
                    return;
                }
                const record = data.data;
                // Populate form
                for (const [key, value] of Object.entries(record)) {
                    const input = document.getElementById('field_' + key);
                    if (input) {
                        input.value = value;
                    }
                }
            });
    }

    // Save
    document.getElementById('resource-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        const url = new URL(window.location.href);
        url.searchParams.set('ajax', 'save_record');

        // Convert FormData to JSON object structure expected by controller (data[field] -> object)
        // Convert FormData to JSON object structure expected by controller
        const object = { data: {} };
        formData.forEach((value, key) => {
            if (key.startsWith('data[')) {
                // Extract field name from data[field_name]
                const fieldName = key.substring(5, key.length - 1);
                object.data[fieldName] = value;
            } else {
                object[key] = value;
            }
        });

        fetch(url.toString(), {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(object)
        })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success') {
                alert('Saved successfully');
                if (recordId === 'new') {
                   // redirect to edit
                   window.location.href = '?module={{ $me::getModuleName() }}&controller={{ $me::getControllerName() }}&id=' + data.id;
                }
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(err => console.error('Error saving:', err));
    });
});
</script>
