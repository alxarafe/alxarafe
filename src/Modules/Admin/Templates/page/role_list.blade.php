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

@section('header_actions')
    <a href="?module=Admin&controller=Role&id=new" class="btn btn-primary">
        <i class="fas fa-plus"></i> {{ \Alxarafe\Lib\Trans::_('create_new_role') }}
    </a>
@endsection

@section('content')

<div class="container-fluid">



    @if(isset($roles) && count($roles) > 0)
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 50px;">{{ \Alxarafe\Lib\Trans::_('id') }}</th>
                            <th>{{ \Alxarafe\Lib\Trans::_('name') }}</th>
                            <th>{{ \Alxarafe\Lib\Trans::_('description') }}</th>
                            <th class="text-center" style="width: 100px;">{{ \Alxarafe\Lib\Trans::_('active') }}</th>
                            <th class="text-end" style="width: 150px;">{{ \Alxarafe\Lib\Trans::_('actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="align-middle">{{ $role->id }}</td>
                                <td class="align-middle"><strong>{{ $role->name }}</strong></td>
                                <td class="align-middle">{{ $role->description }}</td>
                                <td class="align-middle text-center">
                                    @if($role->active)
                                        <span class="badge bg-success">{{ \Alxarafe\Lib\Trans::_('yes') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ \Alxarafe\Lib\Trans::_('no') }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-end">
                                    <a href="?module=Admin&controller=Role&id={{ $role->id }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> {{ \Alxarafe\Lib\Trans::_('edit') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info py-4 text-center">
            <h4>{{ \Alxarafe\Lib\Trans::_('no_roles_found') }}</h4>
            <p>{{ \Alxarafe\Lib\Trans::_('start_by_creating_role') }}</p>
            <a href="?module=Admin&controller=Role&id=new" class="btn btn-primary mt-2">
                {{ \Alxarafe\Lib\Trans::_('create_first_role') }}
            </a>
        </div>
    @endif
</div>
@endsection
