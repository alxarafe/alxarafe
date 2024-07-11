@extends('partial.layout.main', ['empty' => true])

@section('content')
    @component('form.form', [])
        @component('layout.container', ['fluid' => true])
            @slot('slot')
                @component('layout.row',[])
                    @slot('slot')
                        @component('layout.column',[])
                            @slot('slot')
                                @component('component.card', ['title' => 'Título 1', 'name' => 'card1'])
                                    @slot('slot')
                                        @include('form.input', ['type' => 'text', 'name' => 'theme', 'label' => $me::_('theme'), 'value' => $me->data->main->theme ?? ''])
                                        @include('form.input', ['type' => 'text', 'name' => 'language', 'label' => $me::_('language'), 'value' => $me->data->main->language ?? ''])
                                    @endslot
                                @endcomponent
                                @component('component.card', ['title' => 'Título 1', 'name' => 'card1'])
                                    @slot('slot')
                                        @include('form.input', ['type' => 'text', 'name' => 'prefix', 'label' => 'DB Prefix', 'value' => $me->data->db->prefix])
                                        @include('form.input', ['type' => 'text', 'name' => 'charset', 'label' => 'charset', 'value' => $me->data->db->charset ?? 'utf8mb4'])
                                        @include('form.input', ['type' => 'text', 'name' => 'collation', 'label' => 'collation', 'value' => $me->data->db->collation ?? 'utf8mb4_unicode_ci'])
                                    @endslot
                                @endcomponent
                            @endslot
                        @endcomponent
                        @component('layout.column',[])
                            @component('component.card', ['title' => 'Título 1', 'name' => 'card1'])
                                @slot('slot')
                                    @include('form.input', ['type' => 'text', 'name' => 'type', 'label' => 'DB Type', 'value' => $me->data->db->type ?? 'mysqli'])
                                    @include('form.input', ['type' => 'text', 'name' => 'host', 'label' => 'Host', 'value' => $me->data->db->host ?? 'localhost'])
                                    @include('form.input', ['type' => 'text', 'name' => 'user', 'label' => 'User', 'value' => $me->data->db->user ?? ''])
                                    @include('form.input', ['type' => 'password', 'name' => 'pass', 'label' => 'Password', 'value' => $me->data->db->pass ?? ''])
                                    @include('form.input', ['type' => 'text', 'name' => 'name', 'label' => 'Name', 'value' => $me->data->db->name ?? 'alxarafe'])
                                    @include('form.input', ['type' => 'number', 'name' => 'port', 'label' => 'Port', 'value' => $me->data->db->port ?? 0])
                                @endslot
                            @endcomponent
                        @endcomponent
                    @endslot
                @endcomponent
                @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'checkConnection'])
                    Comprobar conexión
                @endcomponent
                @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'save'])
                    Guardar los cambios
                @endcomponent
            @endslot
        @endcomponent
    @endcomponent
@endsection

@push('scripts')
    <!-- Prueba de script -->
@endpush
