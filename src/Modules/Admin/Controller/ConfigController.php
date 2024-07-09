<?php

/* Copyright (C) 2024       Rafael San José         <rsanjose@alxarafe.com>
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

namespace CoreModules\Admin\Controller;

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\ViewController;
use Alxarafe\Lib\Functions;
use stdClass;

class ConfigController extends ViewController
{
    public $data;

    public function doIndex(): bool
    {
        /**
         * TODO: The value of this variable will be filled in when the roles
         *       are correctly implemented.
         */
        $restricted_access = false;

        $this->template = 'page/config';
        if (isset($this->config) && $restricted_access) {
            $this->template = 'page/forbidden';
        }

        $this->getPost();

        return true;
    }

    private function getPost()
    {
        if (!isset($this->data)) {
            $this->data = new stdClass();
        }
        foreach (Config::getConfig() as $section => $values) {
            if (!isset($this->data->{$section})) {
                $this->data->{$section} = new stdClass();
            }
            foreach ($values as $variable => $value) {
                $this->data->{$section}->{$variable} = Functions::getIfIsset($variable, $value);
            }
        }
    }

    public function doLogin()
    {
        $this->template = 'page/admin/login';
        $login = filter_input(INPUT_POST, 'login');
        if (!$login) {
            return true;
        }

        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        if (!Auth::login($username, $password)) {
            $this->advice[] = $this->langs->trans('ErrorBadLoginPassword');
            dump([
                'ConfigController' => $this
            ]);
            return true;
        }
        $this->template = 'page/admin/info';
    }

    public function doLogout()
    {
        Auth::logout(true);
        return true;
    }

    public function doCheckConnection()
    {
        $this->template = 'page/config';

        static::getPost();
        $ok = Config::checkDatabaseConnection($this->data->db);
        if (!$ok) {
            $messages = Config::getMessages();
            foreach ($messages as $message) {
                static::addAdvice($message);
            }
            static::addError('Error al conectar a la base de datos "' . $this->data->db->name . '".');
            return true;
        }
        static::addMessage('Conexión satisfactoria con la base de datos "' . $this->data->db->name . '".');
        return true;
    }

    public function doSave(): bool
    {
        static::getPost();

        /**
         * Converts the stdClass to an array
         */
        $data = json_decode(json_encode($this->data), true);

        $result = config::setConfig($data);
        if (!$result) {
            $this->template = 'page/config';
            static::addError('Error al guardar la configuración');
            return false;
        }

        /**
         * TODO: Loads public page
         */
        $this->template = 'page/public';
        static::addMessage('Configuración guardada correctamente');
        return true;
    }
}
