<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class CardComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class CardComponent extends AbstractComponent
{
    /**
     * If setted, contains an image on the top of the component.
     *
     * @var string
     */
    public $imageTop;

    /**
     * If setted imageTop, contains an alternative text for image on the top of the component.
     *
     * @var string
     */
    public $imgAlt;

    /**
     * Title of the card.
     *
     * @var string
     */
    public $cardTitle;

    /**
     * Subtitle of the card.
     *
     * @var string
     */
    public $cardSubTitle;

    /**
     * Text of the card.
     *
     * @var string
     */
    public $cardText;

    /**
     * Buttons of the card.
     *
     * @var array
     */
    public $cardButtons;

    /**
     * CardComponent constructor.
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
        return '@Core/components/card.html';
    }
}
