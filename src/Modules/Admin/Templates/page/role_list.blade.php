@extends('partial.layout.main')

@section('header_actions')
    <a href="?module=Admin&controller=Role&id=new" class="btn btn-primary">
        <i class="fas fa-plus"></i> {{ \Alxarafe\Infrastructure\Lib\Trans::_('create_new_role') }}
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
                            <th style="width: 50px;">{{ \Alxarafe\Infrastructure\Lib\Trans::_('id') }}</th>
                            <th>{{ \Alxarafe\Infrastructure\Lib\Trans::_('name') }}</th>
                            <th>{{ \Alxarafe\Infrastructure\Lib\Trans::_('description') }}</th>
                            <th class="text-center" style="width: 100px;">{{ \Alxarafe\Infrastructure\Lib\Trans::_('active') }}</th>
                            <th class="text-end" style="width: 150px;">{{ \Alxarafe\Infrastructure\Lib\Trans::_('actions') }}</th>
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
                                        <span class="badge bg-success">{{ \Alxarafe\Infrastructure\Lib\Trans::_('yes') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ \Alxarafe\Infrastructure\Lib\Trans::_('no') }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-end">
                                    <a href="?module=Admin&controller=Role&id={{ $role->id }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i> {{ \Alxarafe\Infrastructure\Lib\Trans::_('edit') }}
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
            <h4>{{ \Alxarafe\Infrastructure\Lib\Trans::_('no_roles_found') }}</h4>
            <p>{{ \Alxarafe\Infrastructure\Lib\Trans::_('start_by_creating_role') }}</p>
            <a href="?module=Admin&controller=Role&id=new" class="btn btn-primary mt-2">
                {{ \Alxarafe\Infrastructure\Lib\Trans::_('create_first_role') }}
            </a>
        </div>
    @endif
</div>
@endsection
