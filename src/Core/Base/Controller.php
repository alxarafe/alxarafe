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
        $this->username = Config::$user->getUserName();
        if ($this->username) {
            Debug::addMessage('messages', "User '" . $this->username . "' logged in.");
            $perms = [
                'Access' => ($this->canAccess($this->username) ? 'yes' : 'no'),
                'Create' => ($this->canCreate($this->username) ? 'yes' : 'no'),
                'Read' => ($this->canRead($this->username) ? 'yes' : 'no'),
                'Update' => ($this->canUpdate($this->username) ? 'yes' : 'no'),
                'Delete' => ($this->canDelete($this->username) ? 'yes' : 'no'),
            ];
            Debug::addMessage(
                'messages',
                "Perms for user '" . $this->username . "': <pre>" . var_export($perms, true) . "</pre>"
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
