<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

/**
 * Class PageController, all controllers that needs to be accessed as a page must extends from this.
 *
 * @package Alxarafe\Base
 */
class PageController extends Controller
{
    /**
     * Page title.
     *
     * @var string
     */
    public $title;

    /**
     * Page icon.
     *
     * @var string
     */
    public $icon;

    /**
     * Page description.
     *
     * @var string
     */
    public $descripcion;

    /**
     * Page menu place.
     *
     * @var array
     */
    public $menu;

    /**
     * PageController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setPageDetails();
    }

    /**
     * Start point
     */
    public function run()
    {
        parent::run();
    }

    /**
     * Set the page details.
     */
    protected function setPageDetails()
    {
        foreach ($this->pageDetails() as $property => $value) {
            $this->{$property} = $value;
        }
    }

    /**.
     * Returns the page details.
     */
    public function pageDetails()
    {
        $details = [
            'title' => 'Default title ' . random_int(PHP_INT_MIN, PHP_INT_MAX),
            'icon' => '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>',
            'description' => 'If you can read this, you are missing pageDetails() on your page class.',
            'menu' => [],
        ];
        return $details;
    }

    /**
     * Returns the page details as array.
     */
    protected function getPageDetails()
    {
        $pageDetails = [];
        foreach ($this->pageDetails() as $property => $value) {
            $pageDetails[$property] = $this->{$property};
        }
        ksort($pageDetails);
        return $pageDetails;
    }
}
