<?php

namespace Alxarafe\Test\Core\Base;

use Alxarafe\Core\Base\AuthController;
use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * @var AuthController
     */
    protected $object;

    /**
     * @use AuthController::runMethod
     */
    public function testRunMethod()
    {

    }

    /**
     * @use AuthController::logout
     */
    public function testLogout()
    {

    }

    /**
     * @use AuthController::checkAuth
     */
    public function testCheckAuth()
    {

    }

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new AuthController();
    }
}
