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

namespace CoreModules\Admin\Controller;

use Alxarafe\Base\Controller\GenericPublicController;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;
use Alxarafe\Attribute\Menu;

class AuthController extends GenericPublicController
{


    public ?string $username = null;
    public $password;
    public $remember;

    public function __construct()
    {
        parent::__construct();
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

    #[Menu(
        menu: 'user_menu',
        icon: 'fas fa-user-circle',
        label: 'My Profile',
        order: 10,
        permission: null, // Public inside auth check
        visibility: 'auth',
        url: 'index.php?module=Admin&controller=Profile', // Points to ProfileController::doIndex
        badgeResolver: null
    )]
    #[Menu(
        menu: 'user_menu',
        icon: 'fas fa-sign-in-alt',
        label: 'Login',
        order: 10,
        permission: null,
        visibility: 'guest',
        url: 'index.php?module=Admin&controller=Auth&action=login'
    )]
    public function doIndex()
    {
        return $this->doLogin();
    }

    public function doLogin()
    {
        $this->setDefaultTemplate('page/login');
        $this->addVariable('title', Trans::_('login'));

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

        // If no redirect provided, default to Home/Index
        if (!$redirect) {
            $redirect = \Alxarafe\Lib\Auth::$user->getDefaultPage();
        }

        Functions::httpRedirect(urldecode($redirect));
        return true;
    }

    public function logout()
    {
        Auth::logout();
        Functions::httpRedirect('index.php?module=Admin&controller=Auth&action=index');
        return true;
    }

    #[Menu(
        menu: 'user_menu',
        icon: 'fas fa-sign-out-alt',
        label: 'Logout',
        order: 99,
        permission: null,
        visibility: 'auth',
        url: 'index.php?module=Admin&controller=Auth&action=logout'
    )]
    public function doLogout()
    {
        return $this->logout();
    }
}
