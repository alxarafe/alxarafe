<?php

namespace Modules\Agenda\Controller;

use Alxarafe\Base\Controller\ResourceController;
use Modules\Agenda\Model\Person;

class PersonController extends ResourceController
{
    const MENU = 'agenda|person';

    public static function getModuleName(): string
    {
        return 'Agenda';
    }

    public static function getControllerName(): string
    {
        return 'Person';
    }

    protected function getModelClass(): array
    {
        return [
            'general' => Person::class,
            'address' => \Modules\Agenda\Model\Address::class,
            'phone' => \Modules\Agenda\Model\Phone::class,
        ];
    }

    protected function getListColumns(): array
    {
        return [
            'id',
            'name',
            'lastname',
            'active' => ['type' => 'boolean'],
            'birth_date' => ['type' => 'date']
        ];
    }

    protected function getEditFields(): array
    {
        return [
            'id' => ['readonly' => true],
            'created_at' => ['readonly' => true],
            'updated_at' => ['readonly' => true],
            'name',
            'lastname',
            'active' => ['type' => 'boolean'],
            'birth_date' => ['type' => 'date'],
            'observations'
        ];
    }
}
