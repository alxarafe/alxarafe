<?php

namespace Alxarafe\Component\Container;

use Alxarafe\Component\AbstractField;

class Panel extends AbstractField
{
    protected string $component = 'panel';
    protected array $fields = [];

    public function __construct(string $title, array $fields = [], array $options = [])
    {
        // Use title slug as ID to allow merging of sections with same name (case-insensitive)
        $id = 'panel_' . strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', $title));
        parent::__construct($id, $title, $options);
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
