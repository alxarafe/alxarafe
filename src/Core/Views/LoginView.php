<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Views;

use Alxarafe\Base\View;

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
        $this->renderer->setTemplate('login');
    }

    /**
     * Add new CSS code related to this view.
     */
    public function addCss(): void
    {
        parent::addCss();
        $this->addToVar('cssCode', $this->addResource('/css/login.css'));
    }
}
