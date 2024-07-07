@extends('page.layout.empty')

@section('content')
    <h2 class="my-4">Registro</h2>
    <form action="{!! $me->url() !!}" method="POST">
        @component('component.card', ['title' => 'Título 1', 'name' => 'panel1'])
            @slot()
                @include('form.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nombre1'])
                @include('form.input', ['type' => 'email', 'name' => 'email', 'label' => 'Correo Electrónico1'])
            @endslot
        @endcomponent
        <div class="row">
            <div class="col-6">
                @component('component.card', ['title' => 'Título 2', 'name' => 'card1'])
                    @slot()
                        @include('form.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nombre2'])
                        @include('form.input', ['type' => 'email', 'name' => 'email', 'label' => 'Correo Electrónico2'])
                    @endslot
                @endcomponent
            </div>
            <div class="col-6">
                @component('component.card', ['title' => 'Título 3', 'name' => 'card1'])
                    @slot()
                        @include('form.input', ['type' => 'text', 'name' => 'name', 'label' => 'Nombre3'])
                        @include('form.input', ['type' => 'email', 'name' => 'email', 'label' => 'Correo Electrónico3'])
                    @endslot
                @endcomponent
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <!-- Prueba de script -->
@endpush
