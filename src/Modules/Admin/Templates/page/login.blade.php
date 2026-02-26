@extends('partial.layout.main')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <x-component.card class="shadow-lg border-0" style="width: 100%; max-width: 450px; border-radius: 20px;">
        <div class="p-4 text-center">
            <div class="mb-4">
                <i class="fas fa-user-shield fa-4x text-primary mb-3"></i>
                <h2 class="fw-bold">{{ $me->_('administration_access') }}</h2>
                <p class="text-muted">{{ $me->_('please_enter_credentials') }}</p>
            </div>

            <x-form.form method="POST" action="">
                <input type="hidden" name="action" value="login">
                
                <div class="text-start">
                    <x-form.input 
                        name="username" 
                        :label="$me->_('login_name')" 
                        placeholder="admin" 
                        required
                        class="form-control-lg mb-3"
                    />
                    
                    <x-form.input 
                        type="password" 
                        name="password" 
                        :label="$me->_('login_password')" 
                        placeholder="••••••••" 
                        required
                        class="form-control-lg mb-4"
                    />
                </div>

                <div class="d-grid mt-2">
                    <x-component.button variant="primary" type="submit" class="btn-lg rounded-pill py-3 fw-bold shadow-sm">
                        <i class="fas fa-sign-in-alt me-2"></i>{{ $me->_('login_button') }}
                    </x-component.button>
                </div>
            </x-form.form>
        </div>
    </x-component.card>
</div>

<style>
    body { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; }
    .card { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.9) !important; }
</style>
@endsection

@push('scripts')
    <!-- Prueba de script -->
@endpush
