<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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

declare(strict_types=1);

namespace Alxarafe\Base\Model\Trait;

use stdClass;

/**
 * Trait DtoTrait.
 * Provides magic methods for dynamic getters, setters, and data hydration.
 */
trait DtoTrait
{
    /**
     * Magic getter supporting get_property and getProperty.
     */
    public function __get(string $name): mixed
    {
        $methods = ['get_' . $name, 'get' . ucfirst($name)];

        foreach ($methods as $method) {
            if (method_exists($this, $method)) {
                return $this->$method();
            }
        }

        return property_exists($this, $name) ? $this->{$name} : null;
    }

    /**
     * Magic setter supporting set_property and setProperty.
     */
    public function __set(string $name, mixed $value): void
    {
        $methods = ['set_' . $name, 'set' . ucfirst($name)];

        foreach ($methods as $method) {
            if (method_exists($this, $method)) {
                $this->$method($value);
                return;
            }
        }

        $this->{$name} = $value;
    }

    /**
     * Magic caller supporting call_method and callMethod.
     */
    public function __call(string $name, array $arguments): mixed
    {
        $methods = ['call_' . $name, 'call' . ucfirst($name)];

        foreach ($methods as $method) {
            if (method_exists($this, $method)) {
                return $this->$method(...$arguments);
            }
        }

        return null;
    }

    /**
     * Magic isset check for dynamic properties.
     */
    public function __isset(string $name): bool
    {
        $methods = ['get_' . $name, 'get' . ucfirst($name)];

        foreach ($methods as $method) {
            if (method_exists($this, $method)) {
                return $this->$method() !== null;
            }
        }

        return isset($this->{$name});
    }

    /**
     * Hydrates the object from an stdClass.
     */
    public function setData(stdClass $data): self
    {
        foreach (get_object_vars($data) as $field => $value) {
            $this->{$field} = $value;
        }
        return $this;
    }

    /**
     * Converts the object to an associative array.
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
