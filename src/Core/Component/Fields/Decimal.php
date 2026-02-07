<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class Decimal extends AbstractField
{
    protected string $component = 'decimal';

    #[\Override]
    public function getType(): string
    {
        return 'decimal';
    }
}
