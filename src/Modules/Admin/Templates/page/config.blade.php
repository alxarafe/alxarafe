@extends('layout.empty')

@section('content')
    <h2 class="my-4">Configuration</h2>
    <form action="{!! $me->url() !!}" method="POST">
        <div class="row">
            <div class="col-6">
                @component('component.card', ['name' => 'card1'])
                    @slot('slot')
                        @include('component.input', ['type' => 'text', 'name' => 'theme', 'label' => 'Theme', 'value' => $me->data->main->theme ?? ''])
                        @include('component.input', ['type' => 'text', 'name' => 'language', 'label' => 'Language', 'value' => $me->data->main->language ?? ''])
                    @endslot
                @endcomponent
                @component('component.card', ['name' => 'card1'])
                    @slot('slot')
                        @include('component.input', ['type' => 'text', 'name' => 'prefix', 'label' => 'DB Prefix', 'value' => $me->data->db->prefix])
                        @include('component.input', ['type' => 'text', 'name' => 'charset', 'label' => 'charset', 'value' => $me->data->db->charset ?? 'utf-8'])
                        @include('component.input', ['type' => 'text', 'name' => 'collation', 'label' => 'collation', 'value' => $me->data->db->collation ?? 'utf8mb4_unicode_ci'])
                    @endslot
                @endcomponent
            </div>
            <div class="col-6">
                @component('component.card', ['name' => 'card1'])
                    @slot('slot')
                        @include('component.input', ['type' => 'text', 'name' => 'type', 'label' => 'DB Type', 'value' => $me->data->db->type ?? 'mysqli'])
                        @include('component.input', ['type' => 'text', 'name' => 'host', 'label' => 'Host', 'value' => $me->data->db->host ?? 'localhost'])
                        @include('component.input', ['type' => 'text', 'name' => 'user', 'label' => 'User', 'value' => $me->data->db->user ?? ''])
                        @include('component.input', ['type' => 'password', 'name' => 'pass', 'label' => 'Password', 'value' => $me->data->db->pass ?? ''])
                        @include('component.input', ['type' => 'text', 'name' => 'name', 'label' => 'Name', 'value' => $me->data->db->name ?? 'alxarafe'])
                        @include('component.input', ['type' => 'number', 'name' => 'port', 'label' => 'Port', 'value' => $me->data->db->port ?? 0])
                    @endslot
                @endcomponent
            </div>
        </div>
        @component('component.button', ['type'=>'submit', 'value'=>'checkConnection'])
            Comprobar conexión
        @endcomponent
        @component('component.button', ['type'=>'submit', 'value'=>'save'])
            Guardar los cambios
        @endcomponent
    </form>
@endsection

@push('scripts')
    <!-- Prueba de script -->
@endpush
