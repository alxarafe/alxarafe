<?php

namespace Test\Core\Base;

use Alxarafe\Controllers\EditConfig;
use Alxarafe\Core\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use Psr\Http\Message\ResponseInterface;

abstract class AuthControllerTest extends ControllerTest
{
    /**
     * @var Client;
     */
    public $http;

    /**
     * @var string
     */
    public $url;

    /**
     * @var array
     */
    public $httpData;

    /**
     * @var FileCookieJar
     */
    public $cookies;

    /**
     * @var
     */
    public $user;

    /**
     * @var
     */
    public $logkey;

    /**
     * @var
     */
    public $username;

    public function __construct()
    {
        parent::__construct();
        $this->url = baseUrl('/index.php?');
        $this->httpData = [
            'base_uri' => $this->url,
            'allow_redirects' => true,
        ];
        $cookieFile = realpath(__DIR__ . '/../../../../../config') . '/user_cookies.txt';
        $this->cookies = new FileCookieJar($cookieFile, true);
    }

    /**
     * @use EditConfig::checkAuth
     */
    public function testLogin(): void
    {
        $postData = [
            'form_params' => [
                'username' => 'admin',
                'password' => 'admin',
                'remember-me' => 'true',
                'action' => 'login',
            ],
            'cookies' => $this->cookies,
        ];
        $this->http = new Client($this->httpData);
        $response = $this->http->post($this->url, $postData);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(400, $response->getStatusCode());
        $this->assertNotEquals(404, $response->getStatusCode());
        // Store the cookies received to be used in next requests
        $this->httpData['cookies'] = $this->cookies;
        $this->username = $this->cookies->getCookieByName('username') ?? $this->username ?? '';
        $this->logkey = $this->cookies->getCookieByName('logKey') ?? $this->logkey ?? '';
        $user = new User();
        if ($user->verifyLogKey($this->username, $this->logkey)) {
            $this->user = $user;
            $this->object->user = $user;
            $this->object->username = $user->username;
        }
    }

    /**
     * @param array $data
     *
     * @return Client
     */
    public function newClient(array $data): Client
    {
        return new Client($data);
    }

    /**
     * @param        $url
     * @param string $action
     *
     * @return ResponseInterface
     */
    public function doGetRequest($url, $action = ''): ResponseInterface
    {
        return $this->http->get($url . $action, ['cookies' => $this->cookies]);
    }

    /**
     * @use AuthController::logout
     */
    public function testLogout(): void
    {
        if (method_exists($this->object, 'logout')) {
            foreach ($this->cookies->toArray() as $key => $value) {
                $_COOKIE[$key] = $value;
            }
            $this->object->user = new User();
            $this->object->logout();
        }
    }
}
