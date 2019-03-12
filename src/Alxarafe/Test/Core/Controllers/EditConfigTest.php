<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\EditConfig;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\FileCookieJar;
use PHPUnit\Framework\TestCase;

/**
 * Class EditConfigTest
 *
 * @doc https://blog.cloudflare.com/using-guzzle-and-phpunit-for-rest-api-testing/
 * @package Alxarafe\Test\Core\Controllers
 */
class EditConfigTest extends TestCase
{
    /**
     * @var EditConfig
     */
    protected $object;

    /**
     * @var Client;
     */
    protected $http;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $httpData;

    /**
     * @var FileCookieJar
     */
    protected $cookies;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new EditConfig();
        $this->url = baseUrl('/index.php?' . constant('CALL_CONTROLLER') . '=Login&' . constant('METHOD_CONTROLLER') . '=index');
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
    public function testLogin()
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
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertEquals(200, $response->getStatusCode());
        // Store the cookies received to be used in next requests
        $this->httpData['cookies'] = $this->cookies;
    }

    /**
     * @param        $url
     * @param string $action
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function doGetRequest($url, $action = '')
    {
        return $this->http->get($url . $action, ['cookies' => $this->cookies]);
    }

    /**
     * @use EditConfig::indexMethod
     */
    public function testIndexMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=index');
        $this->http = new Client($this->httpData);
        $actions = [
            '',
            '&action=clear-cache',
            '&action=regenerate-data',
            '&action=save',
            '&action=cancel',
        ];
        foreach ($actions as $action) {
            $response = $this->doGetRequest($this->url, $action);
            $this->assertNotEquals(404, $response->getStatusCode());
            $this->assertEquals(200, $response->getStatusCode());
        }

        $this->assertIsObject($this->object->indexMethod());
    }

    /**
     * @use EditConfig::readMethod
     */
    public function testReadMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=read');
        $this->http = new Client($this->httpData);
        $response = $this->doGetRequest($this->url);
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertEquals(200, $response->getStatusCode());
    }

    /**
     * @use EditConfig::updateMethod
     */
    public function testUpdateMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=update');
        $this->http = new Client($this->httpData);
        $response = $this->doGetRequest($this->url);
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertIsObject($this->object->updateMethod());
    }

    /**
     * @use EditConfig::createMethod
     */
    public function testCreateMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=create');
        $this->http = new Client($this->httpData);
        $response = $this->doGetRequest($this->url);
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertIsObject($this->object->createMethod());
    }

    /**
     * @use EditConfig::deleteMethod
     */
    public function testDeleteMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=delete');
        $this->http = new Client($this->httpData);
        $response = $this->doGetRequest($this->url);
        $this->assertNotEquals(404, $response->getStatusCode());
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertIsObject($this->object->deleteMethod());
    }

    /**
     * @use EditConfig::pageDetails
     */
    public function testPageDetails()
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }

    /**
     * @use EditConfig::getTimezoneList
     */
    public function testGetTimezoneList()
    {
        $this->assertIsArray($this->object->getTimezoneList());
    }

    public function tearDown()
    {
        $this->http = null;
        $this->object = null;
    }
}
