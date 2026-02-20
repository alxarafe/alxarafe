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
    @component('component.card', ['title' => 'Regeneration Options', 'name' => 'regenerate'])
        <p>Select the option you want to perform:</p>

        <div class="list-group">
            <a href="index.php?module=Admin&controller=Config&action=regenerate&execute=autoload" class="list-group-item list-group-item-action">
                <i class="fas fa-sync mr-2"></i> Regenerate Autoload
            </a>
            <a href="index.php?module=Admin&controller=Config&action=regenerate&execute=cache" class="list-group-item list-group-item-action">
                <i class="fas fa-trash-alt mr-2"></i> Clear Cache
            </a>
             <a href="index.php?module=Admin&controller=Config&action=regenerate&execute=full" class="list-group-item list-group-item-action list-group-item-warning">
                <i class="fas fa-exclamation-triangle mr-2"></i> Full System Regeneration
            </a>
        </div>
        
        <div class="mt-3">
             <a href="index.php?module=Admin&controller=Config" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Config
            </a>
        </div>

    @endcomponent
@endsection
