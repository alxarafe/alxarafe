<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class Time extends AbstractField
{
    protected string $component = 'time';

    #[\Override]
    public function getType(): string
    {
        return 'time';
    }
}
