<?php

namespace Alxarafe\Component\Fields;

use Alxarafe\Component\AbstractField;

class Image extends AbstractField
{
    protected string $component = 'image';

    /**
     * @param string $src URL of the image
     * @param string $alt Alt text
     * @param array $options Additional options (width, height, class)
     */
    public function __construct(string $src, string $alt = '', array $options = [])
    {
        parent::__construct('img_' . md5($src), $alt, array_merge(['src' => $src], $options));
    }

    #[\Override]
    public function getType(): string
    {
        return 'image';
    }
}
