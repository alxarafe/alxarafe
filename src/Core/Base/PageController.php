<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Base;

use Alxarafe\Helpers\Auth;
use Alxarafe\Helpers\Debug;

/**
 * Class PageController, all controllers that needs to be accessed as a page must extends from this.
 *
 * @package Alxarafe\Base
 */
class PageController extends Controller
{

    /**
     * Page title.
     *
     * @var string
     */
    public $title;

    /**
     * Page icon.
     *
     * @var string
     */
    public $icon;

    /**
     * Page description.
     *
     * @var string
     */
    public $descripcion;

    /**
     * Page menu place.
     *
     * @var array
     */
    public $menu;

    /**
     * Contains the data of the currently identified user.
     *
     * @var Auth
     */
    public $userAuth;

    /**
     * Contains the user's name or null
     *
     * @var string|null
     */
    public $userName;

    /**
     * PageController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setPageDetails();
    }

    /**
     * Start point
     */
    public function run()
    {
        if ($this->ensureLogin()) {
            parent::run();
        }
    }

    /**
     * Check if user is logged in, and redirect to this controller if needed.
     *
     * @return bool
     */
    private function ensureLogin()
    {
        if ($this->userAuth === null) {
            $this->userAuth = new Auth();
            $this->userName = $this->userAuth->getUserName();
        }
        if ($this->userName) {
            Debug::addMessage('messages', "User '" . $this->userName . "' logged in.");
            $perms = [
                'Access' => ($this->canAccess($this->userName) ? 'yes' : 'no'),
                'Create' => ($this->canCreate($this->userName) ? 'yes' : 'no'),
                'Read' => ($this->canRead($this->userName) ? 'yes' : 'no'),
                'Update' => ($this->canUpdate($this->userName) ? 'yes' : 'no'),
                'Delete' => ($this->canDelete($this->userName) ? 'yes' : 'no'),
            ];
            Debug::addMessage(
                'messages', "Perms for user '" . $this->userName . "': <pre>" . var_export($perms, true) . "</pre>"
            );
            return true;
        }
        $this->userAuth->login();
        Debug::addMessage('messages', 'User must log in!');
        return false;
    }

    /**
     * Set the page details.
     */
    protected function setPageDetails()
    {
        foreach ($this->pageDetails() as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * Returns the page details.
     */

    public function pageDetails()
    {
        $details = [
            'title' => 'Default title ' . random_int(PHP_INT_MIN, PHP_INT_MAX),
            'icon' => '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>',
            'description' => 'If you can read this, you are missing pageDetails() on your page class.',
            'menu' => 'default',
        ];
        return $details;
    }

    /**
     * Returns the page details as array.
     */
    protected function getPageDetails()
    {
        $pageDetails = [];
        foreach ($this->pageDetails() as $property => $value) {
            $pageDetails[$property] = $this->{$property};
        }
        ksort($pageDetails);
        return $pageDetails;
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
