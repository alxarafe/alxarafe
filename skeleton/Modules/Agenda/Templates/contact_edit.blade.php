@extends('partial.layout.main')

@section('header_actions')
@if(!empty($viewDescriptor['recordId']) && $viewDescriptor['recordId'] !== 'new')
    <button type="submit" form="alxarafe-edit-form" name="save" value="save" class="btn btn-primary">
        <i class="fas fa-save me-1"></i> {{ $me->trans('save_changes') ?: 'Guardar' }}
    </button>
@else
    <button type="submit" form="alxarafe-edit-form" name="save" value="save" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> {{ $me->trans('create') ?: 'Crear' }}
    </button>
@endif
    <a href="?module=Agenda&controller=Contact" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> {{ $me->trans('back') ?: 'Volver' }}
    </a>
@endsection

@section('content')
@php
    $record = $viewDescriptor['record'] ?? [];
    $recordId = $viewDescriptor['recordId'] ?? 'new';
    $isNew = ($recordId === 'new' || empty($recordId));
    $addresses = $contact_addresses ?? [];
    $channels = $contact_channels ?? [];
    $channelTypes = $channel_types ?? [];
@endphp

<div class="container-fluid">
    <form method="POST" action="?module=Agenda&controller=Contact" id="alxarafe-edit-form">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="id" value="{{ $recordId }}">

        {{-- Tabs Navigation --}}
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-general" type="button">
                    <i class="fas fa-user me-1"></i> {{ $me->trans('general') ?: 'General' }}
                </button>
            </li>
            @if(!$isNew)
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-addresses" type="button">
                    <i class="fas fa-map-marker-alt me-1"></i> {{ $me->trans('addresses') ?: 'Direcciones' }}
                    <span class="badge bg-info">{{ count($addresses) }}</span>
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-channels" type="button">
                    <i class="fas fa-phone-alt me-1"></i> {{ $me->trans('contact_channels') ?: 'Canales' }}
                    <span class="badge bg-info">{{ count($channels) }}</span>
                </button>
            </li>
            @endif
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content">
            {{-- General Tab --}}
            <div class="tab-pane fade show active" id="tab-general">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">{{ $me->trans('first_name') ?: 'Nombre' }} *</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               value="{{ $record['first_name'] ?? '' }}" required
                               placeholder="{{ $me->trans('first_name_placeholder') ?: '' }}">
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">{{ $me->trans('last_name') ?: 'Apellidos' }}</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                               value="{{ $record['last_name'] ?? '' }}"
                               placeholder="{{ $me->trans('last_name_placeholder') ?: '' }}">
                    </div>
                    <div class="col-12">
                        <label for="notes" class="form-label">{{ $me->trans('notes') ?: 'Observaciones' }}</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4"
                                  placeholder="{{ $me->trans('notes_placeholder') ?: '' }}">{{ $record['notes'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            @if(!$isNew)
            {{-- Addresses Tab --}}
            <div class="tab-pane fade" id="tab-addresses">
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-success" id="btn-add-address">
                        <i class="fas fa-plus me-1"></i> {{ $me->trans('add_address') ?: 'Añadir Dirección' }}
                    </button>
                </div>
                <div id="addresses-container">
                    @foreach($addresses as $idx => $addr)
                    <div class="card mb-3 address-card" data-address-id="{{ $addr->id }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>
                                <i class="fas fa-map-marker-alt me-1"></i>
                                <input type="text" class="form-control form-control-sm d-inline-block" style="width: 150px"
                                       name="addresses[{{ $idx }}][label]"
                                       value="{{ $addr->pivot->label ?? '' }}"
                                       placeholder="{{ $me->trans('address_label_help') ?: 'casa, trabajo...' }}">
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-address" data-idx="{{ $idx }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="addresses[{{ $idx }}][id]" value="{{ $addr->id }}">
                            <div class="row g-2">
                                <div class="col-12">
                                    <input type="text" class="form-control" name="addresses[{{ $idx }}][address]"
                                           value="{{ $addr->address }}" placeholder="{{ $me->trans('address') ?: 'Dirección' }}">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="addresses[{{ $idx }}][city]"
                                           value="{{ $addr->city ?? '' }}" placeholder="{{ $me->trans('city') ?: 'Ciudad' }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="addresses[{{ $idx }}][state]"
                                           value="{{ $addr->state ?? '' }}" placeholder="{{ $me->trans('state') ?: 'Provincia' }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="addresses[{{ $idx }}][postal_code]"
                                           value="{{ $addr->postal_code ?? '' }}" placeholder="{{ $me->trans('postal_code') ?: 'CP' }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="addresses[{{ $idx }}][country]"
                                           value="{{ $addr->country ?? '' }}" placeholder="{{ $me->trans('country') ?: 'País' }}">
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="addresses[{{ $idx }}][additional_info]"
                                           value="{{ $addr->additional_info ?? '' }}" placeholder="{{ $me->trans('additional_info') ?: 'Info adicional' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Channels Tab --}}
            <div class="tab-pane fade" id="tab-channels">
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-success" id="btn-add-channel">
                        <i class="fas fa-plus me-1"></i> {{ $me->trans('add_channel') ?: 'Añadir Canal' }}
                    </button>
                </div>
                <table class="table table-hover" id="channels-table">
                    <thead>
                        <tr>
                            <th style="width: 40px"></th>
                            <th>{{ $me->trans('channel_name') ?: 'Canal' }}</th>
                            <th>{{ $me->trans('channel_value') ?: 'Valor' }}</th>
                            <th style="width: 50px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($channels as $idx => $ch)
                        <tr class="channel-row">
                            <td><i class="{{ $ch->icon ?? 'fas fa-phone' }}"></i></td>
                            <td>
                                <select class="form-select form-select-sm" name="channels[{{ $idx }}][channel_id]">
                                    @foreach($channelTypes as $ct)
                                    <option value="{{ $ct->id }}" {{ ($ch->id == $ct->id) ? 'selected' : '' }}>
                                        {{ $ct->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="channels[{{ $idx }}][value]"
                                       value="{{ $ch->pivot->value ?? '' }}"
                                       placeholder="{{ $me->trans('channel_value_help') ?: 'Teléfono, email, URL...' }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-remove-channel">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </form>
</div>

{{-- JavaScript for dynamic rows --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    let addressIdx = {{ count($addresses) }};
    let channelIdx = {{ count($channels) }};

    // Add Address
    const btnAddAddr = document.getElementById('btn-add-address');
    if (btnAddAddr) {
        btnAddAddr.addEventListener('click', function() {
            const container = document.getElementById('addresses-container');
            const i = addressIdx++;
            const html = `
            <div class="card mb-3 address-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-map-marker-alt me-1"></i>
                        <input type="text" class="form-control form-control-sm d-inline-block" style="width: 150px"
                               name="addresses[${i}][label]" value="" placeholder="{{ $me->trans('address_label_help') ?: 'casa, trabajo...' }}">
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-address">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="card-body">
                    <input type="hidden" name="addresses[${i}][id]" value="new">
                    <div class="row g-2">
                        <div class="col-12">
                            <input type="text" class="form-control" name="addresses[${i}][address]" placeholder="{{ $me->trans('address') ?: 'Dirección' }}">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="addresses[${i}][city]" placeholder="{{ $me->trans('city') ?: 'Ciudad' }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="addresses[${i}][state]" placeholder="{{ $me->trans('state') ?: 'Provincia' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="addresses[${i}][postal_code]" placeholder="{{ $me->trans('postal_code') ?: 'CP' }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="addresses[${i}][country]" placeholder="{{ $me->trans('country') ?: 'País' }}">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control" name="addresses[${i}][additional_info]" placeholder="{{ $me->trans('additional_info') ?: 'Info adicional' }}">
                        </div>
                    </div>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
        });
    }

    // Remove Address
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-address')) {
            e.target.closest('.address-card').remove();
        }
    });

    // Add Channel
    const btnAddCh = document.getElementById('btn-add-channel');
    if (btnAddCh) {
        btnAddCh.addEventListener('click', function() {
            const tbody = document.querySelector('#channels-table tbody');
            const i = channelIdx++;
            const options = @json($channelTypes ?? []);
            let optHtml = '';
            options.forEach(ct => {
                optHtml += `<option value="${ct.id}">${ct.name}</option>`;
            });
            const html = `
            <tr class="channel-row">
                <td><i class="fas fa-plus-circle"></i></td>
                <td><select class="form-select form-select-sm" name="channels[${i}][channel_id]">${optHtml}</select></td>
                <td><input type="text" class="form-control form-control-sm" name="channels[${i}][value]" placeholder="{{ $me->trans('channel_value_help') ?: 'Teléfono, email, URL...' }}"></td>
                <td><button type="button" class="btn btn-sm btn-outline-danger btn-remove-channel"><i class="fas fa-trash"></i></button></td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', html);
        });
    }

    // Remove Channel
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-channel')) {
            e.target.closest('.channel-row').remove();
        }
    });
});
</script>
@endsection
