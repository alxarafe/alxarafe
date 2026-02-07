<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class Integer extends AbstractField
{
    protected string $component = 'integer';

    #[\Override]
    public function getType(): string
    {
        return 'integer';
    }
}
