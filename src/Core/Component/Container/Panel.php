<?php

namespace Alxarafe\Component\Container;

use Alxarafe\Component\AbstractField;

class Panel extends AbstractField
{
    protected string $component = 'panel';
    protected array $fields = [];

    public function __construct(string $title, array $fields = [], array $options = [])
    {
        // Panel doesn't have a single 'field' name in the DB sense, but we need an ID.
        // Use title slug as ID? Or random?
        parent::__construct('panel_' . md5($title), $title, $options);
        $this->fields = $fields;
    }

    #[\Override]
    public function getType(): string
    {
        return 'panel';
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    #[\ReturnTypeWillChange]
    #[\Override]
    public function jsonSerialize(): mixed
    {
        $data = parent::jsonSerialize();
        $fieldsData = [];
        foreach ($this->fields as $f) {
            if ($f instanceof AbstractField) {
                $fieldsData[] = $f->jsonSerialize();
            } else {
                $fieldsData[] = $f;
            }
        }
        $data['fields'] = $fieldsData;
        return $data;
    }
}
