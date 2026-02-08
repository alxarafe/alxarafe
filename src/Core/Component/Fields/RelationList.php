<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class RelationList extends AbstractField
{
    protected string $component = 'relation_list';

    /**
     * @param string $relation Name of the relation method (e.g. 'addresses')
     * @param string $label Label for the list
     * @param array $columns List of columns to display: ['street', 'city'] or [['field'=>'street', 'label'=>'Calle']]
     * @param array $options Additional options
     */
    public function __construct(string $relation, string $label, array $columns = [], array $options = [])
    {
        // Wrap everything for the frontend
        $payload = array_merge($options, ['columns' => $columns]);
        parent::__construct($relation, $label, ['options' => $payload]);
    }

    #[\Override]
    public function getType(): string
    {
        return 'relation_list';
    }
}
