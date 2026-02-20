@extends('partial.layout.main')

@section('content')
    @component('form.form', [])
        @component('component.card', ['name' => 'panel1'])
            @slot('slot')
                @include('form.input', ['type' => 'text', 'name' => 'username', 'label' => $me->_('login_name')])
                @include('form.input', ['type' => 'password', 'name' => 'password', 'label' => $me->_('login_password')])
            @endslot
        @endcomponent
        @component('component.button', ['type'=>'submit', 'name'=>'action', 'value'=>'login', 'slot'=>$me->_('login_button')])
            Login
        @endcomponent
    @endcomponent
@endsection

@push('scripts')
    <!-- Prueba de script -->
@endpush
