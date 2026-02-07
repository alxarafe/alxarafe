<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class Textarea extends AbstractField
{
    protected string $component = 'textarea';

    #[\Override]
    public function getType(): string
    {
        return 'textarea';
    }
}
