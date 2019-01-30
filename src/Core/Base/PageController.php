<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Auth;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Models\Page;
use Alxarafe\Models\RolePage;
use Alxarafe\Models\User;
use Alxarafe\Models\UserRole;
use ReflectionClass;
use Xfs\Controllers\UsersRoles;

/**
 * Class PageController, all controllers that needs to be accessed as a page must extends from this.
 *
 * @package Alxarafe\Base
 */
class PageController extends Controller
{
    /**
     * Symbol to split menu/submenu items.
     */
    const MENU_DELIMITER = '|';

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
    public $description;

    /**
     * Page menu place.
     *
     * @var array
     */
    public $menu;

    /**
     * The user logged.
     *
     * @var User
     */
    public $user;

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
     * Can user access?
     *
     * @var bool
     */
    public $canAccess;

    /**
     * Can user create?
     *
     * @var bool
     */
    public $canCreate;

    /**
     * Can user read?
     *
     * @var bool
     */
    public $canRead;

    /**
     * Can user update?
     *
     * @var bool
     */
    public $canUpdate;

    /**
     * Can user delete?
     *
     * @var bool
     */
    public $canDelete;

    /**
     * The roles where user is assigned.
     *
     * @var UsersRoles
     */
    public $roles;

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
    public function index()
    {
        if ($this->ensureLogin()) {
            // Stored to avoid duplicate queries
            $this->canAccess = $this->canAction($this->userName, 'access');
            $this->canCreate = $this->canAction($this->userName, 'create');
            $this->canRead = $this->canAction($this->userName, 'read');
            $this->canUpdate = $this->canAction($this->userName, 'update');
            $this->canDelete = $this->canAction($this->userName, 'delete');

            parent::index();
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
            $this->user = $this->userAuth->getUser();
        }
        if ($this->userName) {
            Debug::addMessage('messages', "User '" . $this->userName . "' logged in.");
            $perms = [
                'Access' => ($this->canAccess ? 'yes' : 'no'),
                'Create' => ($this->canCreate ? 'yes' : 'no'),
                'Read' => ($this->canRead ? 'yes' : 'no'),
                'Update' => ($this->canUpdate ? 'yes' : 'no'),
                'Delete' => ($this->canDelete ? 'yes' : 'no'),
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
            'title' => Config::$lang->trans('Default title ') . random_int(PHP_INT_MIN, PHP_INT_MAX),
            'icon' => '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>',
            'description' => Config::$lang->trans('If you can read this, you are missing pageDetails() on your page class.'),
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
     * Verify if this user can do an action.
     *
     * @param string $username
     * @param string $action
     *
     * @return bool
     */
    private function canAction(string $username, string $action): bool
    {
        $pages = [];
        try {
            $className = (new ReflectionClass($this))->getShortName();
        } catch (\ReflectionException $e) {
            // $this must exists always, this exception must never success
            Debug::addException($e);
        }

        if ($this->roles === null) {
            $this->roles = (new UserRole())->getAllRecordsBy('user_id', $this->user->id);
        }
        if (!empty($this->roles)) {
            foreach ($this->roles as $pos => $role) {
                // If it's in role superadmin or admin
                $allowedRoles = [1, 2];
                if (in_array($role['id'], $allowedRoles)) {
                    return true;
                }
                $pagesAccess = new RolePage();
                if ($pagesAccess->getAllRecordsBy('role_id', $role['id'])) {
                    $pages = array_merge($pages, $pagesAccess);
                }
            }
        }

        Debug::addMessage('messages', "Available '" . $action . "' pages for '" . $username . "': <pre>" . var_export($pages, true) . "</pre>");
        $action = 'can_' . $action;
        foreach ($pages as $page) {
            if ($page->controller == $className && $page->{$action} == 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return a list of pages for generate user menu.
     *
     * @return array
     */
    public function getUserMenu()
    {
        $list = [];
        $pages = (new Page())->getAllRecords();
        foreach ($pages as $page) {
            // Ignore item if menu is empty
            if (empty($page['menu'])) {
                continue;
            }
            // Add every page to list
            $pos = '$list';
            $positions = explode(self::MENU_DELIMITER, $page['menu']);
            foreach ($positions as $position) {
                $pos .= "['$position']";
            }
            $pos .= "[]";
            $pageDetails = [
                'controller' => $page['controller'],
                'title' => $page['title'],
                'description' => $page['description'],
                'icon' => $page['icon'],
            ];
            eval("$pos=" . var_export($pageDetails, true) . ";");
        }
        return $list;
    }
}
