@extends('partial.layout.main')

@section('content')
    @component('layout.div', ['fluid' => true])
        @slot('slot')
            @component('layout.row',[])
                <button id="startProcess" class="btn btn-primary center">Iniciar Proceso</button>
                <ul id="results" class="list-group mt-3"></ul>
            @endcomponent
        @endslot
    @endcomponent
@endsection

@push('scripts')
    <script type="text/javascript">
        document.getElementById('startProcess').addEventListener('click', function () {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';

            fetch('{!! $me->url() !!}&action=getProcesses')
                .then(response => response.json())
                .then(actions => {
                    // Paso 2: Ejecutar acciones secuencialmente
                    const executeNext = (index) => {
                        if (index >= actions.length) return; // Todas las acciones completadas

                        const action = actions[index];
                        const listItem = document.createElement('li');
                        listItem.className = 'list-group-item';
                        listItem.textContent = `Ejecutando: ${action.name}`;
                        resultsContainer.appendChild(listItem);

                        // Ejecutar acción por AJAX
                        fetch('{!! $me->url() !!}&action=ExecuteProcess', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams({ action_id: action.id })
                        })
                            .then(response => response.json())
                            .then(data => {
                                listItem.textContent = data.message; // Actualiza el resultado
                                executeNext(index + 1); // Ejecuta la siguiente acción
                            })
                            .catch(() => {
                                listItem.textContent = `Error ejecutando ${action.name}`;
                            });
                    };

                    executeNext(0); // Inicia el proceso
                })
                .catch(() => {
                    const errorItem = document.createElement('li');
                    errorItem.className = 'list-group-item list-group-item-danger';
                    errorItem.textContent = 'Error al obtener las acciones';
                    resultsContainer.appendChild(errorItem);
                });
        });
    </script>
@endpush
