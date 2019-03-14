<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Models\Page;
use Alxarafe\Core\Models\RolePage;
use Alxarafe\Core\Models\UserRole;
use Alxarafe\Core\Providers\Logger;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthPageController, all controllers that needs to be accessed as a page must extends from this.
 *
 * @package Alxarafe\Core\Base
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
     * Can user print?
     *
     * @var bool
     */
    public $canPrint;

    /**
     * Can user export?
     *
     * @var bool
     */
    public $canExport;

    /**
     * Can user send mail?
     *
     * @var bool
     */
    public $canSendMail;

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
        try {
            $random = random_int(PHP_INT_MIN, PHP_INT_MAX);
        } catch (\Exception $e) {
            Logger::getInstance()::exceptionHandler($e);
            $random = rand(PHP_INT_MIN, PHP_INT_MAX);
        }
        $details = [
            'title' => 'Default title ' . $random,
            'icon' => '<i class="fas fa-info-circle"></i>',
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
    abstract public function readMethod(): Response;

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
        if (!$this->checkAuth()) {
            return $this->redirect(baseUrl('index.php?call=Login'));
        }
        $this->loadPerms();
        $method = $methodName . 'Method';
        $this->debugTool->addMessage('messages', $this->translator->trans('call-to', ['%called%' => $this->shortName . '->' . $method . '()']));

        switch ($methodName) {
            case 'index':
            case 'ajaxTableData':
                if ($this->canAccess) {
                    $this->debugTool->addMessage('messages', $this->translator->trans('user-can-access-to', ['%where%' => $this->shortName . '->' . $method . '()']));
                    return $this->{$method}();
                }
                break;
            case 'add':
                $method = 'createMethod';
            // no-break
            case 'create':
                if ($this->canAccess && $this->canCreate) {
                    $this->debugTool->addMessage('messages', $this->translator->trans('user-can-create-to', ['%where%' => $this->shortName . '->' . $method . '()']));
                    return $this->{$method}();
                }
                break;
            case 'show':
                $method = 'readMethod';
            // no-break
            case 'read':
                if ($this->canAccess && $this->canRead) {
                    $this->debugTool->addMessage('messages', $this->translator->trans('user-can-read-to', ['%where%' => $this->shortName . '->' . $method . '()']));
                    return $this->{$method}();
                }
                break;
            case 'edit':
                $method = 'updateMethod';
            // no-break
            case 'update':
                if ($this->canAccess && $this->canUpdate) {
                    $this->debugTool->addMessage('messages', $this->translator->trans('user-can-update-to', ['%where%' => $this->shortName . '->' . $method . '()']));
                    return $this->{$method}();
                }
                break;
            case 'remove':
                $method = 'deleteMethod';
            // no-break
            case 'delete':
                if ($this->canAccess && $this->canDelete) {
                    $this->debugTool->addMessage('messages', $this->translator->trans('user-can-delete-to', ['%where%' => $this->shortName . '->' . $method . '()']));
                    return $this->{$method}();
                }
                break;
        }

        // Forced to this template because needs to verify perms on this final method.
        $this->renderer->setTemplate('master/noaccess');
        $this->debugTool->addMessage('messages', $this->translator->trans('user-unknown-perms-to', ['%where%' => $this->shortName . '->' . $method . '()']));
        return $this->{$method}();
    }

    /**
     * Load perms for this user.
     */
    private function loadPerms(): void
    {
        $details = [
            $this->username => [
                'access' => $this->canAccess = $this->canAction('access'),
                'create' => $this->canCreate = $this->canAction('create'),
                'read' => $this->canRead = $this->canAction('read'),
                'update' => $this->canUpdate = $this->canAction('update'),
                'delete' => $this->canDelete = $this->canAction('delete'),
                'print' => $this->canPrint = $this->canAction('print'),
                'export' => $this->canExport = $this->canAction('export'),
                'sendmail' => $this->canSendMail = $this->canAction('sendmail'),
            ],
        ];
        $this->debugTool->addMessage('messages', ' <pre>' . print_r($details, true) . '</pre>');
    }

    /**
     * Verify if this user can do an action.
     *
     * @param string $action
     *
     * @return bool
     */
    private function canAction(string $action): bool
    {
        $pages = [[]];

        if ($this->roles === null) {
            $this->roles = (new UserRole())->getAllRecordsBy('id_user', $this->user->getId());
        }
        if (!empty($this->roles)) {
            foreach ($this->roles as $pos => $role) {
                // If it's in role superadmin or admin
                $allowedRoles = [1, 2];
                if (in_array($role['id'], $allowedRoles, false)) {
                    return true;
                }

                if ($pagesAccess = (new RolePage())->getAllRecordsBy('id_role', $role['id'])) {
                    $pages[] = $pagesAccess;
                }
            }
        }
        $pages = array_merge(...$pages);

        $action = 'can_' . $action;
        foreach ($pages as $page) {
            if ($page->controller === $this->shortName && $page->{$action} === 1) {
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
        $pages = (new Page())->getAllRecordsBy('active', 1);
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
