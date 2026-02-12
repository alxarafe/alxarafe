<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

/**
 * Class StaticText
 * Renders a static text block (HTML allowed) instead of an input field.
 */
class StaticText extends AbstractField
{
    protected string $component = 'static_text';

    public function __construct(string $content, array $options = [])
    {
        // Field name is irrelevant for static text, use hash
        parent::__construct('static_' . md5($content), $content, $options);
    }

    #[\Override]
    public function getType(): string
    {
        return 'static_text';
    }
}
