@extends('partial.layout.main')

@section('content')

<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1>
                @if($recordId === 'new')
                    {{ \Alxarafe\Lib\Trans::_('new_user') }}
                @else
                    {{ \Alxarafe\Lib\Trans::_('edit_user') }}: {{ $user->name ?? '' }}
                @endif
            </h1>
        </div>
    </div>

    <form method="POST" action="?module=Admin&controller=User">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="{{ $recordId }}">

        <div class="card mb-4">
            <div class="card-header">{{ \Alxarafe\Lib\Trans::_('user_details') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @include('form.' . $nameField->getComponent(), $nameField->jsonSerialize())
                    </div>
                    <div class="col-md-6">
                        @include('form.' . $emailField->getComponent(), $emailField->jsonSerialize())
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        @include('form.' . $passwordField->getComponent(), $passwordField->jsonSerialize())
                    </div>
                    <div class="col-md-6">
                        @include('form.' . $roleField->getComponent(), $roleField->jsonSerialize())
                    </div>
                </div>

                <div class="row align-items-center">
                     <div class="col-md-6 mb-3">
                        <div class="form-check form-switch pt-4">
                            <input class="form-check-input" type="checkbox" id="isAdminSwitch" name="is_admin" value="1" {{ ($user->is_admin ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isAdminSwitch">
                                {{ \Alxarafe\Lib\Trans::_('administrator_access') }}
                            </label>
                        </div>
                        <small class="text-muted d-block mt-1">
                            {{ \Alxarafe\Lib\Trans::_('admin_bypass_warning') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">{{ \Alxarafe\Lib\Trans::_('preferences') }}</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @include('form.' . $langField->getComponent(), $langField->jsonSerialize())
                    </div>
                    
                    <div class="col-md-4">
                        @include('form.' . $tzField->getComponent(), $tzField->jsonSerialize())
                    </div>
                    
                    <div class="col-md-4">
                        @include('form.' . $themeField->getComponent(), $themeField->jsonSerialize())
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 mb-5">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> {{ \Alxarafe\Lib\Trans::_('save_changes') }}
            </button>
            <a href="?module=Admin&controller=User" class="btn btn-secondary btn-lg">{{ \Alxarafe\Lib\Trans::_('cancel') }}</a>
        </div>
    </form>
</div>
@endsection
