<?php

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

namespace Alxarafe\Base\Component\Filter;

use Alxarafe\Base\Component\AbstractFilter;
use Xnet\Core\DBSchema;

class RelationFilter extends AbstractFilter
{
    private string $relatedModelClass;
    private string $relatedTable;
    private string $relatedPK;

    public function __construct(string $field, string $relatedModelClass, string $label)
    {
        parent::__construct($field, $label, []);
        $this->relatedModelClass = $relatedModelClass;

        // Determinar tabla y PK soportando tanto XnetModel (estático/camelCase) como Legacy (propiedades/snake_case)
        if (method_exists($relatedModelClass, 'tableName')) {
            $this->relatedTable = $relatedModelClass::tableName();
        } else {
            // Legacy fallback
            $model = new $relatedModelClass();
            $this->relatedTable = $model->table_name;
        }

        if (method_exists($relatedModelClass, 'primaryColumn')) {
            $this->relatedPK = $relatedModelClass::primaryColumn();
        } else {
            // Legacy fallback (algunos tienen primary_column() como método, otros property)
            $model = new $relatedModelClass();
            if (method_exists($model, 'primary_column')) {
                $this->relatedPK = $model->primary_column();
            } else {
                $this->relatedPK = $model->primary_column ?? 'id';
            }
        }
    }

    public function apply(array &$whereParts, $value): void
    {
        $searchSQL = $this->getSearchSQL($value);
        if ($searchSQL) {
            // Construimos la subconsulta:
            // FIELD IN (SELECT PK FROM RELATED_TABLE WHERE SEARCH_SQL)
            $whereParts[] = "{$this->field} IN (SELECT {$this->relatedPK} FROM {$this->relatedTable} WHERE {$searchSQL})";
        }
    }

    private function getSearchSQL(string $value): string
    {
        // 1. Si el modelo tiene un método específico para devolver el SQL de búsqueda
        if (method_exists($this->relatedModelClass, 'getSearchSQL')) {
            return call_user_func([$this->relatedModelClass, 'getSearchSQL'], $value);
        }

        // 2. Si el modelo define campos de búsqueda estándar
        if (method_exists($this->relatedModelClass, 'getSearchFields')) {
            $fields = call_user_func([$this->relatedModelClass, 'getSearchFields']);
        } else {
            // 3. Fallback: Intentamos adivinar campos comunes (nombre, titulo, descripcion)
            $fields = ['nombre', 'titulo', 'descripcion', 'name', 'title'];
            // Verificamos que existan en la tabla (opcional, pero seguro)
            // Para simplificar, asumimos que si no define getSearchFields, no podemos garantizar nada 
            // y quizás deberíamos fallar o buscar solo en 'nombre' si existe.
            // Mejor: Check if 'nombre' exists via DBSchema if possible, or just try 'nombre'.
            $fields = ['nombre'];
        }

        $parts = [];
        foreach ($fields as $field) {
            // Usamos DBSchema si está disponible para búsqueda insensible a acentos
            if (class_exists('\Xnet\Core\DBSchema') && method_exists('\Xnet\Core\DBSchema', 'search_diacritic_insensitive')) {
                $parts[] = \Xnet\Core\DBSchema::search_diacritic_insensitive($field, $value);
            } else {
                $safeValue = addslashes($value);
                $parts[] = "LOWER({$field}) LIKE LOWER('%{$safeValue}%')";
            }
        }

        return empty($parts) ? '' : '(' . implode(' OR ', $parts) . ')';
    }

    public function getType(): string
    {
        return 'text'; // En el frontend se comporta como un input texto
    }
}
