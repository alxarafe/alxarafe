<?php

namespace Alxarafe\Test\Core\Controllers;

use Alxarafe\Core\Controllers\Languages;
use Alxarafe\Test\Core\Base\AuthPageExtendedControllerTest;
use Symfony\Component\HttpFoundation\Response;

class LanguagesTest extends AuthPageExtendedControllerTest
{

    public function __construct()
    {
        parent::__construct();
        $this->object = new Languages();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    public function tearDown(): void
    {
        $this->object = null;
    }

    /**
     * @use Languages::pageDetails
     */
    public function testPageDetails(): void
    {
        $this->assertNotEmpty($this->object->pageDetails());
    }

    /**
     * @use Languages::indexMethod
     */
    public function testIndexMethod(): void
    {
        $this->assertInstanceOf(Response::class, $this->object->indexMethod());
    }

    /**
     * @use Languages::getExtraActions
     */
    public function testGetExtraActions(): void
    {
        $this->assertNotEmpty($this->object->getExtraActions());
    }
}
