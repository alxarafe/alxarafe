<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class Select extends AbstractField
{
    protected string $component = 'select';

    public function __construct(string $field, string $label, array $values = [], array $options = [])
    {
        $payload = array_merge($options, ['values' => $values]);
        parent::__construct($field, $label, ['options' => $payload]);
    }

    #[\Override]
    public function getType(): string
    {
        return 'select';
    }
}
