@extends('partial.layout.main')

@section('content')
    <x-form.form id="config-form">
        <x-layout.div :fluid="true">

            @slot('slot')
                <x-layout.row>
                    @slot('slot')

                        @foreach ($me->configFields as $groupName => $groupFields)
                            <x-layout.column :class="count($me->configFields) > 1 ? 'col-md-6' : 'col-12'">
                                @slot('slot')
                                    <x-component.card :title="$me->_($groupName)">
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
                                    </x-component.card>
                                @endslot
                            </x-layout.column>
                        @endforeach
                    @endslot
                </x-layout.row>

                {{-- Buttons managed via header_actions --}}
            @endslot
        </x-layout.div>
    </x-form.form>
@endsection

@section('header_actions')
    {{-- Config Actions linked to form --}}
    <x-component.button type="submit" name="action" value="save" form="config-form">
        {!! $me->_('save_configuration') !!}
    </x-component.button>

    @if ($me->pdo_connection ?? false)
        @if (!$me->pdo_db_exists ?? false)
            <x-component.button type="submit" name="action" value="createDatabase" form="config-form">
                {!! $me->_('create_database') !!}
            </x-component.button>
        @else
            <x-component.button type="submit" name="action" value="runMigrations" form="config-form">
                {!! $me->_('go_migrations') !!}
            </x-component.button>
        @endif
        <x-component.button type="submit" name="action" value="regenerate" class="warning" form="config-form">
            {!! $me->_('regenerate') !!}
        </x-component.button>
        <x-component.button type="submit" name="action" value="exit" class="danger" form="config-form">
            {!! $me->_('exit') !!}
        </x-component.button>
    @endif

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
