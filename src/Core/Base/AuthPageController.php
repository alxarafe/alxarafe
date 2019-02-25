<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Auth;
use Alxarafe\Models\Page;
use Alxarafe\Models\RolePage;
use Alxarafe\Models\UserRole;
use Alxarafe\Providers\Logger;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthPageController, all controllers that needs to be accessed as a page must extends from this.
 *
 * @package Alxarafe\Base
 */
abstract class AuthPageController extends AuthController
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
     * @var UserRole[]
     */
    public $roles;

    /**
     * Contiene la url que se usará en el formulario.
     *
     * @var string
     */
    public $url;

    /**
     * AuthPageController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->url = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=' . $this->shortName);

        $this->setPageDetails();
    }

    /**
     * Set the page details.
     *
     * @return void
     */
    protected function setPageDetails(): void
    {
        foreach ($this->pageDetails() as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
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
     * Start point and default list of registers.
     *
     * @return Response
     */
    abstract public function indexMethod(): Response;

    /**
     * Default create method for new registers.
     *
     * @return Response
     */
    abstract public function createMethod(): Response;

    /**
     * Default show method for show an individual register.
     *
     * @return Response
     */
    abstract public function showMethod(): Response;

    /**
     * Default update method for update an individual register.
     *
     * @return Response
     */
    abstract public function updateMethod(): Response;

    /**
     * Default delete method for delete an individual register.
     *
     * @return Response
     */
    abstract public function deleteMethod(): Response;

    /**
     * @param string $methodName
     *
     * @return Response
     */
    public function runMethod(string $methodName): Response
    {
        $this->checkLogin();
        $method = $methodName . 'Method';
        $vars = [];
        Logger::getInstance()->getLogger()->addDebug('Call to ' . $this->shortName . '->' . $method . '()');

        switch ($methodName) {
            case 'index':
            case 'ajaxTableData':
                if ($this->canAccess) {
                    return $this->{$method}();
                }
                break;
            case 'create':
                if ($this->canAccess && $this->canCreate) {
                    return $this->{$method}();
                }
                break;
            case 'show':
                if ($this->canAccess && $this->canRead) {
                    return $this->{$method}();
                }
                break;
            case 'update':
                if ($this->canAccess && $this->canUpdate) {
                    return $this->{$method}();
                }
                break;
            case 'delete':
                if ($this->canAccess && $this->canDelete) {
                    return $this->{$method}();
                }
                break;
            default:
                $vars = [
                    'action' => $method,
                ];
                break;
        }
        $this->renderer->setTemplate('master/noaccess');
        return $this->sendResponseTemplate($vars);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|null
     */
    public function checkLogin()
    {
        if (!$this->ensureLogin()) {
            return $this->redirect();
        }
        return null;
    }

    /**
     * Check if user is logged in, and redirect to this controller if needed.
     *
     * @return bool
     */
    private function ensureLogin(): bool
    {
        if ($this->userAuth === null) {
            $this->userAuth = new Auth();
            $this->userName = $this->userAuth->getUserName();
            $this->user = $this->userAuth->getUser();
        }
        if ($this->userName) {
            // Stored to avoid duplicate queries
            $this->canAccess = $this->canAction($this->userName, 'access');
            $this->canCreate = $this->canAction($this->userName, 'create');
            $this->canRead = $this->canAction($this->userName, 'read');
            $this->canUpdate = $this->canAction($this->userName, 'update');
            $this->canDelete = $this->canAction($this->userName, 'delete');
            $perms = [
                'Access' => ($this->canAccess ? 'yes' : 'no'),
                'Create' => ($this->canCreate ? 'yes' : 'no'),
                'Read' => ($this->canRead ? 'yes' : 'no'),
                'Update' => ($this->canUpdate ? 'yes' : 'no'),
                'Delete' => ($this->canDelete ? 'yes' : 'no'),
            ];
            $this->debugTool->addMessage(
                'messages', "Perms for user '" . $this->userName . "': <pre>" . var_export($perms, true) . "</pre>"
            );
            return true;
        } else {
            $this->debugTool->addMessage(
                'messages', "No user logged in"
            );
        }
        $this->userAuth->login();
        return false;
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

        if ($this->roles === null) {
            $this->roles = (new UserRole())->getAllRecordsBy('id_user', $this->user->getId());
        }
        if (!empty($this->roles)) {
            foreach ($this->roles as $pos => $role) {
                // If it's in role superadmin or admin
                $allowedRoles = [1, 2];
                if (in_array($role['id'], $allowedRoles)) {
                    return true;
                }

                if ($pagesAccess = (new RolePage())->getAllRecordsBy('id_role', $role['id'])) {
                    $pages = array_merge($pages, $pagesAccess);
                }
            }
        }

        $this->debugTool->addMessage('messages', "Available '" . $action . "' pages for '" . $username . "': <pre>" . var_export($pages, true) . "</pre>");
        $action = 'can_' . $action;
        foreach ($pages as $page) {
            if ($page->controller == $this->shortName && $page->{$action} == 1) {
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
    public function getUserMenu(): array
    {
        $list = [];
        $pages = (new Page())->getAllRecords();
        foreach ($pages as $page) {
            // Ignore item if menu is empty
            if (empty($page['menu'])) {
                continue;
            }
            // Add every page to list
            $positions = explode(self::MENU_DELIMITER, $page['menu']);
            $pageDetails = [
                'controller' => $page['controller'],
                'title' => $page['title'],
                'description' => $page['description'],
                'icon' => $page['icon'],
            ];
            $list[implode(self::MENU_DELIMITER, $positions)][] = $pageDetails;
        }
        return $list;
    }

    /**
     * Returns the page details as array.
     *
     * @return array
     */
    protected function getPageDetails(): array
    {
        $pageDetails = [];
        foreach ($this->pageDetails() as $property => $value) {
            $pageDetails[$property] = $this->{$property};
        }
        ksort($pageDetails);
        return $pageDetails;
    }
}
