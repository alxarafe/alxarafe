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
