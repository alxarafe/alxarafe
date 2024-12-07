@extends('partial.layout.main')

@section('content')
    @component('form.form', [])
        @component('layout.div', ['fluid' => true])
            @slot('slot')
                @component('layout.row',[])
                    @slot('slot')
                        @component('layout.column',[])
                            @slot('slot')
                                @component('component.card', ['title' => $me->_('miscellaneous')])
                                    @slot('slot')
                                        @include('form.select', ['name' => 'theme', 'label' => $me::_('theme'), 'values' => $me->themes, 'value' => $me->data->main->theme ?? ''])
                                        @include('form.select', ['name' => 'language', 'label' => $me::_('language'), 'values' => $me->languages, 'value' => $me->data->main->language ?? ''])
                                        @include('form.checkbox', ['name' => 'debug', 'label' => $me::_('use_debugbar'), 'value' => $me->data->security->debug ?? false])
                                    @endslot
                                @endcomponent
                                @component('component.card', ['title' => $me->_('connection')])
                                    @slot('slot')
                                        @php
                                            $readonly = $me->pdo_connection ? ['readonly' => null] : [];
                                        @endphp
                                        @include('form.select', ['name' => 'type', 'label' => $me->_('db_type'), 'values' => $me->dbtypes, 'value' => $me->data->db->type, 'attributes' => $readonly])
                                        @include('form.input', ['type' => 'text', 'name' => 'host', 'label' => $me->_('db_host'), 'value' => $me->data->db->host ?? 'localhost', 'attributes' => $readonly])
                                        @include('form.input', ['type' => 'text', 'name' => 'user', 'label' => $me->_('db_user'), 'value' => $me->data->db->user ?? '', 'attributes' => $readonly])
                                        @include('form.input', ['type' => 'password', 'name' => 'pass', 'label' => $me->_('db_password'), 'value' => $me->data->db->pass ?? '', 'attributes' => $readonly])
                                    @endslot
                                @endcomponent
                            @endslot
                        @endcomponent
                        @component('layout.column',[])
                            @component('component.card', ['title' => $me->_('database_preferences')])
                                @slot('slot')
                                    @include('form.input', ['type' => 'text', 'name' => 'prefix', 'label' => 'DB Prefix', 'value' => $me->data->db->prefix ?? 'alx_'])
                                    @include('form.input', ['type' => 'text', 'name' => 'charset', 'label' => 'charset', 'value' => $me->data->db->charset ?? 'utf8mb4'])
                                    @include('form.input', ['type' => 'text', 'name' => 'collation', 'label' => 'collation', 'value' => $me->data->db->collation ?? 'utf8mb4_unicode_ci'])
                                @endslot
                            @endcomponent
                            @component('component.card', ['title' => $me->_('database')])
                                @slot('slot')
                                    @include('form.input', ['type' => 'text', 'name' => 'name', 'label' => $me->_('db_name'), 'value' => $me->data->db->name ?? 'alxarafe'])
                                    @include('form.input', ['type' => 'number', 'name' => 'port', 'label' => $me->_('db_port'), 'value' => $me->data->db->port ?? 0])
                                @endslot
                            @endcomponent
                        @endcomponent
                    @endslot
                @endcomponent
                @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'save'])
                    {!! $me->_('save_configuration') !!}
                @endcomponent
                @if ($me->pdo_connection)
                    @if (!$me->pdo_db_exists)
                        @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'createDatabase'])
                            {!! $me->_('create_database') !!}
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
    @endcomponent
@endsection

@push('scripts')
    <!-- Prueba de script -->
@endpush
