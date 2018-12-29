<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Views;

use Alxarafe\Base\View;
use Alxarafe\Helpers\Skin;

class Login extends View
{

    public function __construct($ctrl)
    {
        parent::__construct($ctrl);
        Skin::setTemplate('login');
    }

    public function addCss()
    {
        parent::addCss();
        $this->addToVar('cssCode', $this->addResource('/css/login', 'css'));
    }
}
