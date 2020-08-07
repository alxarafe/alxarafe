<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

/**
 * Class ModalComponent
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class ModalComponent extends AbstractComponent
{
    /**
     * Contains image alternative text.
     *
     * @var string
     */
    public $imageAlt;
    /**
     * Contains modal title.
     *
     * @var string
     */
    public $modalTitle;
    /**
     * Contains modal text.
     *
     * @var string
     */
    public $modalText;
    /**
     * Contains modal buttons.
     *
     * @var string
     */
    public $modalButtons;

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/modal.html';
    }
}
