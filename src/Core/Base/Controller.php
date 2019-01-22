<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;

/**
 * Class Controller
 *
 * @package Alxarafe\Base
 */
class Controller
{
    public $username;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->username = null;
    }

    /**
     * Start point
     */
    public function run()
    {
        $this->username = Config::$user->getUser();
        if ($this->username) {
            Debug::addMessage('messages', "User '" . $this->username . "' logged in");
            Debug::addMessage(
                'messages',
                "User '" . $this->username . "' can access? " . ($this->canCreate($this->username) ? 'yes' : 'no')
            );
            if ($this->canAccess($this->username)) {
                var_dump($this->username);
            }

            Debug::addMessage(
                'messages',
                "User '" . $this->username . "' can create? " . ($this->canCreate($this->username) ? 'yes' : 'no')
            );
            Debug::addMessage(
                'messages',
                "User '" . $this->username . "' can read? " . ($this->canRead($this->username) ? 'yes' : 'no')
            );
            Debug::addMessage(
                'messages',
                "User '" . $this->username . "' can update? " . ($this->canUpdate($this->username) ? 'yes' : 'no')
            );
            Debug::addMessage(
                'messages',
                "User '" . $this->username . "' can delete? " . ($this->canDelete($this->username) ? 'yes' : 'no')
            );

            return;
        }
        Debug::addMessage('messages', 'User must log in!');
        return;
    }

    /**
     * Returns if user can access this controller.
     *
     * @param string $username
     *
     * @return bool
     */
    public function canAccess(string $username): bool
    {
        return true;
    }

    /**
     * Returns if user can create on this controller.
     *
     * @param string $username
     *
     * @return bool
     */
    public function canCreate(string $username): bool
    {
        return true;
    }

    /**
     * Returns if user can read on this controller.
     *
     * @param string $username
     *
     * @return bool
     */
    public function canRead(string $username): bool
    {
        return true;
    }

    /**
     * Returns if user can update on this controller.
     *
     * @param string $username
     *
     * @return bool
     */
    public function canUpdate(string $username): bool
    {
        return true;
    }

    /**
     * Return if user can delete on this controller.
     *
     * @param string $username
     *
     * @return bool
     */
    public function canDelete(string $username): bool
    {
        return false;
    }
}
