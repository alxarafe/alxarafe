<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class Select extends AbstractField
{
    protected string $component = 'select';

    public function __construct(string $field, string $label, array $values = [], array $options = [])
    {
        $options['values'] = $values;
        parent::__construct($field, $label, $options);
    }

    #[\Override]
    public function getType(): string
    {
        return 'select';
    }
}
