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

<!-- Templates/common/form/select.blade.php -->
<div class="form-group">
    <label for="{!! $name !!}" class="form-label">{!! $label !!}</label>
    <select class="form-select" name="{!! $name !!}" class="form-control" id="{!! $name !!}">
        @foreach($values as $option => $text)
            <option value="{!! $option !!}" @if($value === $option) selected @endif>{!! $text !!}</option>
        @endforeach
    </select>
</div>
