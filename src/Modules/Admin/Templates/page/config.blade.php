@extends('partial.layout.main')

@section('content')
    @component('form.form', [])
        @component('layout.div', ['fluid' => true])
            @slot('slot')
                @component('layout.row',[])
                    @slot('slot')

                        @foreach ($me->configFields as $groupName => $groupFields)
                            @component('layout.column', ['class' => count($me->configFields) > 1 ? 'col-md-6' : 'col-12'])
                                @slot('slot')
                                    @component('component.card', ['title' => $me->_($groupName)])
                                        @slot('slot')
                                            @foreach ($groupFields as $field)
                                                @php
                                                    $data = $field->jsonSerialize();
                                                    $data['name'] = 'data[' . $data['field'] . ']'; // Map field to data[...] structure
                                                    
                                                    // Mapping value logic...
                                                    $keys = explode('.', $data['field']);
                                                    $val = $me->data;
                                                    foreach($keys as $k) {
                                                        $val = $val->$k ?? null;
                                                    }
                                                    $data['value'] = $val;
                                                    
                                                    // Flatten options if present (e.g. values for Select)
                                                    if (isset($data['options']) && is_array($data['options'])) {
                                                        $data = array_merge($data, $data['options']);
                                                    }
                                                @endphp
                                                @include('form.' . $field->getComponent(), $data)
                                            @endforeach
                                        @endslot
                                    @endcomponent
                                @endslot
                            @endcomponent
                        @endforeach
                    @endslot
                @endcomponent

                @component('layout.row', [])
                    @slot('slot')
                        @component('layout.column', [])
                            @slot('slot')
                                @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'save'])
                                    {!! $me->_('save_configuration') !!}
                                @endcomponent
                                @if ($me->pdo_connection ?? false)
                                    @if (!$me->pdo_db_exists ?? false)
                                        @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'createDatabase'])
                                            {!! $me->_('create_database') !!}
                                        @endcomponent
                                    @else
                                        @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'runMigrations'])
                                            {!! $me->_('go_migrations') !!}
                                        @endcomponent
                                    @endif
                                    @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'regenerate', 'class'=>'warning'])
                                        {!! $me->_('regenerate') !!}
                                    @endcomponent
                                    @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'exit', 'class' => 'danger'])
                                        {!! $me->_('exit') !!}
                                    @endcomponent
                                @endif
                            @endslot
                        @endcomponent
                    @endslot
                @endcomponent
            @endslot
        @endcomponent
    @endcomponent
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const $tzSelect = $('select[name="data[main.timezone]"]');
            // If exists and has no value (first option empty)
            if ($tzSelect.length && !$tzSelect.val()) {
                try {
                    const browserTz = Intl.DateTimeFormat().resolvedOptions().timeZone;
                    if (browserTz) {
                        $tzSelect.val(browserTz).trigger('change');
                    }
                } catch(e) {
                    console.error("Timezone detection failed", e);
                }
            }
        });
    </script>
@endpush
