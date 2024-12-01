<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
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

namespace Alxarafe\Base\Model\Trait;

/**
 * Trait for controllers using databases.
 */
trait DtoTrait
{
    public function __get($name)
    {
        /**
         * TODO: Option to use camel_case and snake_case formats
         */
        $getter = 'get_' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }
        return property_exists($this, $name) ? $this->{$name} : null;
    }

    public function __set($name, $value)
    {
        /**
         * TODO: Option to use camel_case and snake_case formats
         */
        $setter = 'set_' . $name;
        if (method_exists($this, $setter)) {
            return $this->$setter($value);
        }
        /**
         * TODO: See if it is necessary to use ...$value and give the option to
         *       receive more than one value.
         */
        $setter = 'set' . ucfirst($name);
        if (method_exists($this, $setter)) {
            return $this->$setter($value);
        }
        $this->{$name} = $value;
        return $this;
    }

    public function __call($name, $arguments)
    {
        /**
         * TODO: Option to use camel_case and snake_case formats
         */
        $caller = 'call_' . $name;
        if (method_exists($this, $caller)) {
            return $this->$caller($arguments);
        }
        $caller = 'call' . ucfirst($name);
        if (method_exists($this, $caller)) {
            return $this->$caller($arguments);
        }
        return null;
    }

    public function __isset($name)
    {
        /**
         * TODO: Option to use camel_case and snake_case formats
         */
        $getter = 'get_' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }
        $getter = 'get' . ucfirst($name);
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }

        return isset($this->$name);
    }

    public function getData()
    {
        $record = new static();
        foreach (get_class_vars(get_class($record)) as $field => $null) {
            if (!isset($data->{$field})) {
                continue;
            }
            $record->{$field} = $data->{$field};
        }
        return $record;
    }

    public function setData(\stdClass $data)
    {
        foreach ($data as $field => $value) {
            $this->{$field} = $value;
        }
    }

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
}
