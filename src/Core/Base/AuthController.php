<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Auth;
use Alxarafe\Models\User;
use Alxarafe\Providers\Logger;

/**
 * Class AuthController
 *
 * @package Alxarafe\Base
 */
class AuthController extends Controller
{
    /**
     * Page to redirect.
     *
     * @var string
     */
    private $defaultRedirect = 'index.php?call=Login';

    /**
     * The user logged.
     *
     * @var User
     */
    public $user;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $Auth = $this->request->headers->get('Authorization');
        $username = $this->request->cookies->get('user');
        $logkey = $this->request->cookies->get('logkey');

        if (!empty($username) && !empty($logkey)) {
            $user = new User();
            if (!$user->getBy('username', $username)) {
                Logger::getInstance()->getLogger()->addDebug("User auth: '" . $username . "' doesn't exists");
                $this->redirect(baseUrl($this->defaultRedirect))->send();
            } elseif (!$user->verifyLogKey($username, $logkey)) {
                Logger::getInstance()->getLogger()->addDebug("User auth: '" . $username . "' invalid logkey");
                $this->redirect(baseUrl($this->defaultRedirect))->send();
            }
            $this->user = $user;
            return $this->response;
        } elseif (!is_null($Auth)) {
            Logger::getInstance()->getLogger()->addDebug('Auth is null');
            //$this->response = $this->redirect(baseUrl($this->defaultRedirect));
            return $this->response;
        }

        $this->redirect(baseUrl($this->defaultRedirect))->send();
        return;
    }
}
