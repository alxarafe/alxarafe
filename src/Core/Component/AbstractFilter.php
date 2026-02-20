<?php

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

/* Copyright (C) 2026      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Component;

abstract class AbstractFilter implements \JsonSerializable
{
    protected string $field;
    protected string $label;
    protected array $options;

    public function __construct(string $field, string $label, array $options = [])
    {
        $this->field = $field;
        $this->label = $label;
        $this->options = $options;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Aplica el filtro a la consulta SQL.
     * 
     * @param \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query
     * @param mixed $value Valor del filtro enviado por el usuario
     */
    abstract public function apply($query, $value): void;

    /**
     * Devuelve la definición del filtro para el frontend (JSON/Array).
     * Esto permitirá que la vista sepa qué tipo de input renderizar.
     */
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'field' => $this->field,
            'label' => $this->label,
            'options' => $this->options
        ];
    }

    #[\ReturnTypeWillChange]
    #[\Override]
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    abstract public function getType(): string;
}
