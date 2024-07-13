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
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Trans;
use stdClass;

/**
 * Class ConfigController. App settings controller.
 */
class ConfigController extends ViewController
{
    /**
     * Configuration file information
     *
     * @var stdClass
     */
    public $data;

    /**
     * Index action.
     *
     * @return bool
     */
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

    /**
     * Sets $data with the information sent by POST
     *
     * @return void
     */
    private function getPost(): void
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

    /**
     * Login action.
     *
     * @return bool
     */
    public function doLogin(): bool
    {
        $this->template = 'page/login';
        $login = filter_input(INPUT_POST, 'login');
        if (!$login) {
            return true;
        }

        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        if (!Auth::login($username, $password)) {
            self::addAdvice(Trans::_('bad_login'));
            return false;
        }
        $this->template = 'page/admin/info';
        return true;
    }

    /**
     * Logout action.
     *
     * @return bool
     */
    public function doLogout(): bool
    {
        Auth::logout();
        return true;
    }

    /**
     * CheckConnection action.
     *
     * @return bool
     */
    public function doCheckConnection(): bool
    {
        $this->template = 'page/config';

        static::getPost();
        $ok = Config::checkDatabaseConnection($this->data->db);
        if (!$ok) {
            $messages = Config::getMessages();
            foreach ($messages as $message) {
                static::addAdvice($message);
            }
            static::addError(Trans::_('error_connecting_database', ['db' => $this->data->db->name]));
            return true;
        }
        static::addMessage(Trans::_('successful-connection-database', ['db' => $this->data->db->name]));
        return true;
    }

    /**
     * Save action.
     *
     * @return bool
     */
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
            static::addError(Trans::_('error-saving-settings'));
            return false;
        }

        /**
         * TODO: Loads public page
         */
        $this->template = 'page/public';
        static::addMessage(Trans::_('settings-saved-successfully'));
        return true;
    }
}
