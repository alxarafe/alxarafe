<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\EditConfig;
use Alxarafe\Test\Core\Base\AuthPageControllerTest;

/**
 * Class EditConfigTest
 *
 * @doc https://blog.cloudflare.com/using-guzzle-and-phpunit-for-rest-api-testing/
 * @package Alxarafe\Test\Core\Controllers
 */
class EditConfigTest extends AuthPageControllerTest
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new EditConfig();
        $this->url .= constant('CALL_CONTROLLER') . '=Login&' . constant('METHOD_CONTROLLER') . '=index';
    }

    /**
     * @use EditConfig::indexMethod
     */
    public function testIndexMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=index');
        $this->http = $this->newClient($this->httpData);
        $actions = [
            '',
            '&action=clear-cache',
            '&action=regenerate-data',
            '&action=save',
            '&action=cancel',
        ];
        foreach ($actions as $action) {
            $response = $this->doGetRequest($this->url, $action);
            $this->assertEquals(200, $response->getStatusCode());
            $this->assertNotEquals(400, $response->getStatusCode());
            $this->assertNotEquals(404, $response->getStatusCode());
        }

        $this->assertIsObject($this->object->indexMethod());
    }

    /**
     * @use EditConfig::readMethod
     */
    public function testReadMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=read');
        $this->http = $this->newClient($this->httpData);
        $response = $this->doGetRequest($this->url);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(400, $response->getStatusCode());
        $this->assertNotEquals(404, $response->getStatusCode());

        $this->assertIsObject($this->object->readMethod());
    }

    /**
     * @use EditConfig::updateMethod
     */
    public function testUpdateMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=update');
        $this->http = $this->newClient($this->httpData);
        $response = $this->doGetRequest($this->url);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(400, $response->getStatusCode());
        $this->assertNotEquals(404, $response->getStatusCode());

        $this->assertIsObject($this->object->updateMethod());
    }

    /**
     * @use EditConfig::createMethod
     */
    public function testCreateMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=create');
        $this->http = $this->newClient($this->httpData);
        $response = $this->doGetRequest($this->url);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(400, $response->getStatusCode());
        $this->assertNotEquals(404, $response->getStatusCode());

        $this->assertIsObject($this->object->createMethod());
    }

    /**
     * @use EditConfig::deleteMethod
     */
    public function testDeleteMethod()
    {
        $this->httpData['base_uri'] = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=EditConfig&' . constant('METHOD_CONTROLLER') . '=delete');
        $this->http = $this->newClient($this->httpData);
        $response = $this->doGetRequest($this->url);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(400, $response->getStatusCode());
        $this->assertNotEquals(404, $response->getStatusCode());

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
