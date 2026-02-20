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
    @component('form.form', ['attributes' => ['id' => 'config-form']])
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

                {{-- Buttons managed via header_actions --}}
            @endslot
        @endcomponent
    @endcomponent
@endsection

@section('header_actions')
    {{-- Config Actions linked to form --}}
    @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'save', 'attributes' => ['form="config-form"']])
        {!! $me->_('save_configuration') !!}
    @endcomponent

    @if ($me->pdo_connection ?? false)
        @if (!$me->pdo_db_exists ?? false)
            @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'createDatabase', 'attributes' => ['form="config-form"']])
                {!! $me->_('create_database') !!}
            @endcomponent
        @else
            @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'runMigrations', 'attributes' => ['form="config-form"']])
                {!! $me->_('go_migrations') !!}
            @endcomponent
        @endif
        @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'regenerate', 'class'=>'warning', 'attributes' => ['form="config-form"']])
            {!! $me->_('regenerate') !!}
        @endcomponent
        @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'exit', 'class' => 'danger', 'attributes' => ['form="config-form"']])
            {!! $me->_('exit') !!}
        @endcomponent
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
