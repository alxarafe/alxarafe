<?php

namespace CoreModules\Admin\Controller;

use Alxarafe\Base\Controller\ResourceController;
use CoreModules\Admin\Model\User;
use Alxarafe\Base\Config;
use Alxarafe\Lib\Trans;
use Alxarafe\Lib\Functions;
use CoreModules\Admin\Model\Role;
use Alxarafe\Attribute\Menu;
use Alxarafe\Component\Fields\StaticText;
use Alxarafe\Component\Fields\Text;

#[Menu(
    menu: 'main_menu',
    label: 'users',
    icon: 'fas fa-users',
    order: 40,
    permission: 'Admin.User.doIndex'
)]
class UserController extends ResourceController
{
    #[\Override]
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    #[\Override]
    public static function getControllerName(): string
    {
        return 'User';
    }

    #[\Override]
    protected function getModelClass()
    {
        return User::class;
    }

    #[\Override]
    protected function getEditFields(): array
    {
        /** @var User $user */
        $user = ($this->recordId && $this->recordId !== 'new') ? User::find($this->recordId) : new User();

        $isAdminContext = \Alxarafe\Lib\Auth::$user->can('Admin.User.doEdit');

        return \CoreModules\Admin\Service\UserService::getFormPanels($user, $isAdminContext);
    }

    #[\Override]
    protected function beforeEdit()
    {
        // Default template logic uses the structure from getEditFields().
        // If you create 'templates/page/user_edit.blade.php', you can use:
        // $this->setDefaultTemplate('page/user_edit');
    }

    #[\Override]
    protected function beforeList()
    {
        $users = User::with('role')->get();
        $this->addVariable('users', $users);
        $this->setDefaultTemplate('page/user_list');
        $this->addVariable('title', \Alxarafe\Lib\Trans::_('user_management'));
    }

    #[\Override]
    protected function saveRecord()
    {
        try {
            $id = $_POST['id'] ?? null;

            // Handle JSON Input (mirrored from ResourceTrait)
            $contentType = $_SERVER["CONTENT_TYPE"] ?? $_SERVER["HTTP_CONTENT_TYPE"] ?? '';
            $rawInput = file_get_contents('php://input');

            if (stripos($contentType, 'application/json') !== false || ($rawInput && $rawInput[0] === '{')) {
                $json = json_decode($rawInput, true);
                if (is_array($json)) {
                    $_POST = array_merge($_POST, $json);

                    // Re-check ID in case it came in JSON
                    if (empty($id)) {
                        $id = $_POST['id'] ?? null;
                    }
                }
            }

            if ($id === 'new' || empty($id)) {
                $user = new User();
            } else {
                /** @var User|null $user */
                $user = User::find($id);
                if (!$user) {
                    throw new \Exception("User not found with ID: " . htmlspecialchars((string)$id));
                }
            }
            // @var User $user - Removed unnecessary annotation

            // @var User $user - Removed unnecessary annotation

            $isAdminContext = \Alxarafe\Lib\Auth::$user->can('Admin.User.doEdit');

            if (!\CoreModules\Admin\Service\UserService::saveUser($user, $_POST, $_FILES, $isAdminContext)) {
                throw new \Exception("Failed to save User to database.");
            }

            $this->recordId = (string)$user->id;

            // Redirect
            if (\Alxarafe\Lib\Auth::$user->can('Admin.User.doIndex')) {
                Functions::httpRedirect(static::url());
            } else {
                // If can't list users, go back to profile
                Functions::httpRedirect("index.php?module=Admin&controller=User&action=profile");
            }
        } catch (\Throwable $e) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border: 10px solid red; margin: 20px;'>";
            echo "<h1>Fatal Error on Save</h1>";
            echo "<h3>" . $e->getMessage() . "</h3>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            echo "</div>";
            die();
        }
    }
    /**
     * Sets the current page (Referer) as the default start page for the user.
     */
    public function doSetDefaultPage()
    {
        $user = \Alxarafe\Lib\Auth::$user;
        if ($user) {
            $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';

            // Clean URL to store relative path
            $baseUrl = Config::getConfig()->main->url;
            $urlToSave = str_replace($baseUrl, '', $redirect);
            // Remove leading/trailing slashes
            $urlToSave = trim($urlToSave, '/');

            // If empty (root), default to index.php
            if (empty($urlToSave)) {
                $urlToSave = 'index.php';
            }

            $user->default_page = $urlToSave;
            if ($user->save()) {
                \Alxarafe\Lib\Messages::addMessage(Trans::_('default_page_updated'));
            } else {
                \Alxarafe\Lib\Messages::addError(Trans::_('error_saving'));
            }

            Functions::httpRedirect($redirect);
        }
        return true;
    }
}
