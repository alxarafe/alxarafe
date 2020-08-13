<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

use Alxarafe\Core\Models\TableModel;

/**
 * Class Select2Component
 *
 * @package Alxarafe\Core\Renders\Twig\Components
 */
class Select2Component extends AbstractComponent
{
    /**
     * Contains if component must use multiple selection.
     *
     * @var bool
     */
    public $multiple;

    /**
     * Contains the text for the option.
     *
     * @var array
     */
    public $texts;

    /**
     * Contains the values for the option.
     *
     * @var array
     */
    public $values;

    /**
     * AbstractComponent constructor.
     *
     * @param $parameters
     */
    public function __construct($parameters)
    {
        parent::__construct($parameters);

        $this->dataAttr = [
            'ajax--url' => $parameters['ctrlUrl'] . '&method=ajaxSearch&table=' . $parameters['struct']->referencedtable,
            'placeholder' => $parameters['placeholder'] ?? '',
            'id' => $parameters['value'] ?? null,
            'allow-clear' => 'true',
        ];

        if (isset($parameters['value']) && !empty($parameters['value'])) {
            $refTable = (new TableModel())->get($parameters['struct']->referencedtable);
            $newClass = $refTable->namespace;
            $item = (new $newClass())->get($parameters['value']);
            $this->dataAttr['text'] = $item->getDescription();
        }

        if (isset($parameters['data']) && !empty($parameters['data'])) {
            $this->dataAttr = array_merge($this->dataAttr, $parameters['data']);
        }
    }

    /**
     * Sets default value for id and text fields (value and text of select).
     *
     * @param $data
     *
     * @return bool
     */
    public function setValue($data)
    {
        parent::setValue($data);
        if (!isset($this->struct)) {
            return false;
        }

        $referenced = TableModel::getModel($this->struct->referencedtable);
        if ($referenced === null || !$referenced->load($data)) {
            return false;
        }
        $this->dataAttr['id'] = $data;
        $this->dataAttr['text'] = $referenced->getDescription();
        return true;
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/select2.html';
    }
}
