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

use Alxarafe\Base\Controller\Controller;
use Alxarafe\Base\Controller\Trait\DbTrait;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;

class AuthController extends Controller
{
    const MENU = 'admin|auth';
    const SIDEBAR_MENU = [
        ['option' => 'admin|auth|login', 'url' => 'index.php?module=Admin&controller=Auth&method=login'],
        ['option' => 'admin|auth|register', 'url' => 'index.php?module=Admin&controller=Auth&method=register'],
        ['option' => 'admin|auth|forgot_password', 'url' => 'index.php?module=Admin&controller=Auth&method=forgotPassword']
    ];

    use DbTrait;

    public ?string $username = null;
    public $password;
    public $remember;

    public function __construct()
    {
        parent::__construct();

        //        if (!static::connectDb($this->config->db)) {
        //            throw new \Exception('Cannot connect to database.');
        //        }
    }

    /**
     * Returns the module name for use in url function
     *
     * @return string
     */
    #[\Override]
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    /**
     * Returns the controller name for use in url function
     *
     * @return string
     */
    #[\Override]
    public static function getControllerName(): string
    {
        return 'Auth';
    }

    public function doIndex()
    {
        return $this->doLogin();
    }

    public function doLogin()
    {
        $this->setDefaultTemplate('page/login');

        $this->username = filter_input(INPUT_POST, 'username');
        $this->password = filter_input(INPUT_POST, 'password');
        $this->remember = filter_input(INPUT_POST, 'remember') === 'on';

        $login = filter_input(INPUT_POST, 'action') === 'login';
        if (!$login) {
            return true;
        }

        if (!Auth::login($this->username, $this->password)) {
            Messages::addAdvice(Trans::_('authenticated_error'));
            return true;
        }

        $redirect = filter_input(INPUT_GET, 'redirect') ?? filter_input(INPUT_POST, 'redirect');
        if ($redirect) {
            Functions::httpRedirect(urldecode($redirect));
        }

        $this->setDefaultTemplate('page/info');
        Messages::addMessage(Trans::_('authenticated_user', ['user' => $this->username]));

        return true;
    }

    public function doLogout()
    {
        Auth::logout();
        return true;
    }
}
