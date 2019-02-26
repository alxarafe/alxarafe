<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Models\User;
use Alxarafe\Providers\Logger;
use Symfony\Component\HttpFoundation\Response;

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
    }

    public function checkAuth(string $methodName): Bool
    {
        $return = false;
        $Auth = $this->request->headers->get('Authorization');
        $username = $this->request->cookies->get('user');
        $logkey = $this->request->cookies->get('logkey');

        if (!empty($username) && !empty($logkey)) {
            $user = new User();
            if ($user->verifyLogKey($username, $logkey)) {
                $this->user = $user;
                $return = true;
            }
        } elseif (!is_null($Auth)) {
            Logger::getInstance()->getLogger()->addDebug('Auth is null');
            // TODO: Check with Auth header if has valid credentials
            $return = true;
        }
        return $return;
    }

    /**
     * @param string $methodName
     *
     * @return Response
     */
    public function runMethod(string $methodName): Response
    {
        $method = $methodName . 'Method';
        Logger::getInstance()->getLogger()->addDebug('Call to ' . $this->shortName . '->' . $method . '()');
        if (!$this->checkAuth($methodName)) {
            Logger::getInstance()->getLogger()->addDebug('User not authenticated.');
            return $this->redirect(baseUrl($this->defaultRedirect));
        }
        return $this->{$method}();
    }
}
