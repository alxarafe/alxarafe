<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Models\User;
use Alxarafe\Providers\FlashMessages;

/**
 * Class Auth
 *
 * @package Alxarafe\Helpers
 */
class Auth extends User
{

    /**
     * Cookie time expiration.
     */
    const COOKIE_EXPIRATION = 86400 * 30;   // 30 days

    /**
     * Minimum cookie time expiration.
     */
    const COOKIE_EXPIRATION_MIN = 3600;     // 1 hour

    /**
     * User log key.
     *
     * @var string|null
     */
    public $logkey = null;

    /**
     * To manage PHP Sessions.
     *
     * @var \Alxarafe\Helpers\Session
     */
    protected $session;

    /**
     * Username in use.
     *
     * @var string|null
     */

    private $username = null;

    /**
     * User in use.
     *
     * @var User|null
     */
    private $user = null;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->username = $this->getCookieUser();
        $this->session = Session::getInstance();
    }

    /**
     * Returns the cookie from the user
     *
     * @return string|null
     */
    public function getCookieUser()
    {
        if ($this->username === null) {
            if (isset($_COOKIE['user']) && isset($_COOKIE['logkey']) && !$this->verifyLogKey($_COOKIE['user'], $_COOKIE['logkey'])) {
                $this->clearCookieUser();
                $this->login();
            }
        }
        return $this->username;
    }

    /**
     * Verify is log key is correct.
     *
     * @param string $userName
     * @param string $hash
     *
     * @return bool
     */
    public function verifyLogKey(string $userName, string $hash): bool
    {
        $status = false;
        $this->user = new User();
        if ($this->user->getBy('username', $userName) !== null && $hash === $this->user->logkey) {
            $this->username = $this->user->username;
            $this->logkey = $this->user->logkey;
            $status = true;
        }
        return $status;
    }

    /**
     * Clear the cookie user.
     *
     * @return void
     */
    private function clearCookieUser(): void
    {
        $this->adjustCookieUser();
    }

    /**
     * Adjust auth cookie user.
     *
     * @return void
     */
    private function adjustCookieUser($time = 0): void
    {
        if ($time == 0) {
            $time = time() - 3600;
        }
        setcookie('user', $this->username, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        $this->logkey = $this->generateLogKey();
        setcookie('logkey', $this->logkey, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
    }

    /**
     * Generate a log key.
     *
     * @param string $ip
     * @param bool   $unique
     *
     * @return string
     */
    public function generateLogKey(string $ip = '', bool $unique = true): string
    {
        $logkey = '';
        if (!empty($this->username)) {
            $this->user = new User();
            $this->user->getBy('username', $this->username);
            $text = $this->username;
            if ($unique) {
                $text .= '|' . $ip . '|' . date('Y-m-d H:i:s');
            }
            $text .= '|' . Utils::randomString();
            $logkey = password_hash($text, PASSWORD_DEFAULT);

            $this->user->logkey = $logkey;
            $this->user->save();
        }

        return $logkey;
    }

    /**
     * Login the user.
     *
     * @return void
     */
    public function login(): void
    {
        if (strpos($_SERVER['REQUEST_URI'], constant('CALL_CONTROLLER') . '=Login') === false) {
            $redirectTo = '&redirect=' . urlencode(base64_encode($_SERVER['REQUEST_URI']));
            header('Location: ' . constant('BASE_URI') . '/index.php?' . constant('CALL_CONTROLLER') . '=Login' . $redirectTo);
        }
    }

    /**
     * Logout the user.
     *
     * @return void
     */
    public function logout(): void
    {
        FlashMessages::getInstance()::setInfo('Logout: ' . ($this->username === null ? 'There was no identified user.' : 'User' . $this->username . ' has successfully logged out'));

        $this->username = null;

        $this->clearCookieUser();
        header('Location: ' . constant('BASE_URI') . '/index.php');
    }

    /**
     * Returns the user name if setted or null.
     *
     * @return string|null
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * Returns the user if setted or null.
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $userName
     * @param string $password
     * @param bool   $remember
     *
     * @return bool
     */
    public function setUser($userName, $password, $remember = false): bool
    {
        $this->user = new User();
        $this->username = null;

        if ($this->user->getBy('username', $userName) !== null) {
            if (password_verify($password, $this->user->password)) {
                $this->username = $this->user->username;
                $time = time() + ($remember ? self::COOKIE_EXPIRATION : self::COOKIE_EXPIRATION_MIN);
                $this->adjustCookieUser($time);
                $this->debugTool->addMessage('messages', $this->user->username . " authenticated");
            } else {
                $this->clearCookieUser();
                $this->debugTool->addMessage('messages', "Checking hash wrong password");
            }
        } else {
            $this->debugTool->addMessage('messages', "User '" . $userName . "' not founded.");
        }
        return $this->username !== null;
    }
}
