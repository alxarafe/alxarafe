<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class TableComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class TableComponent extends AbstractComponent
{
    /**
     * Contains the main table class.
     *
     * @var bool
     */
    public $tableClass;
    /**
     * Contains the thead class.
     *
     * @var bool
     */
    public $theadClass;
    /**
     * Contains the tbody class.
     *
     * @var bool
     */
    public $tbodyClass;
    /**
     * Contains the tfoot class.
     *
     * @var bool
     */
    public $tfootClass;
    /**
     * Contains the thead items.
     *
     * @var array
     */
    public $thead;
    /**
     * Contains the tbody items.
     *
     * @var array
     */
    public $tbody;
    /**
     * Contains the tfoot items.
     *
     * @var array
     */
    public $tfoot;
    /**
     * TODO:
     *
     * @var bool
     */
    public $first;

    /**
     * TableComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);

        // TODO: Verify all fields
//        if (!isset($this->path)) {
//            $this->path = $parameters['value'];
//        }
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/table.html';
    }
}
