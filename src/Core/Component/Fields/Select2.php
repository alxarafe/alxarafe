<?php

namespace Alxarafe\Component\Fields;

class Select2 extends Select
{
    public function __construct(string $field, string $label, array $values = [], array $options = [])
    {
        // Ensure 'class' key exists in options or merge it
        $options['class'] = ($options['class'] ?? '') . ' select2';
        parent::__construct($field, $label, $values, $options);
    }

    #[\Override]
    public function getType(): string
    {
        return 'select2';
    }
}
