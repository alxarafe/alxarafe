@extends('partial.layout.main', ['empty' => true])

@section('content')
    @component('form.form', [])
        @component('component.card', ['name' => 'panel1'])
            @slot('slot')
                @include('form.input', ['type' => 'text', 'name' => 'username', 'label' => 'Nombre de usuario'])
                @include('form.input', ['type' => 'password', 'name' => 'password', 'label' => 'Contraseña'])
            @endslot
        @endcomponent
        @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'login'])
            Login
        @endcomponent
    @endcomponent
@endsection

@push('scripts')
    <!-- Prueba de script -->
@endpush
