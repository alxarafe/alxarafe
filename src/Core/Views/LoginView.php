<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Views;

use Alxarafe\Base\View;
use Alxarafe\Helpers\Skin;

/**
 * Class LoginView
 *
 * @package Alxarafe\Views
 */
class LoginView extends View
{

    /**
     * Login constructor.
     *
     * @param $ctrl
     */
    public function __construct($ctrl)
    {
        parent::__construct($ctrl);
        Skin::setTemplate('login');
    }

    /**
     * TODO: Undocummented
     */
    public function addCss(): void
    {
        parent::addCss();
        $this->addToVar('cssCode', $this->addResource('/css/login', 'css'));
    }
}
