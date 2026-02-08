<?php

namespace Modules\Agenda\Controller;

use Alxarafe\Base\Controller\ResourceController;
use Alxarafe\Component\Fields\Boolean;
use Alxarafe\Component\Fields\Date;
use Alxarafe\Component\Fields\RelationList;
use Alxarafe\Component\Fields\Select;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Component\Fields\Textarea;
use Modules\Agenda\Model\Country;
use Modules\Agenda\Model\Person;

class DemoPersonController extends ResourceController
{
    protected function getModelClass()
    {
        return Person::class;
    }

    // Eager load addresses and country for the RelationList and List View
    protected array $with = ['addresses', 'country'];

    protected function getListFields(): array
    {
        return [
            new Text('id', 'ID', ['width' => '50px']),
            new Text('name', 'Nombre'),
            new Text('lastname', 'Apellidos'),

            // 1:1 Relation Field (Dot Notation)
            new Text('country.name', 'País'),

            new Boolean('active', 'Activo'),
            new Date('birth_date', 'Fecha Nacimiento'),
        ];
    }

    protected function getEditFields(): array
    {
        $countries = [];
        try {
            $countries = Country::orderBy('name')->pluck('name', 'id')->toArray();
        } catch (\Exception $e) {
            \Alxarafe\Tools\Debug::addException($e);
        }

        return [
            'general' => [
                'label' => 'General',
                'fields' => [
                    new Text('name', 'Nombre'),
                    new Text('lastname', 'Apellidos'),
                    new Select('country_id', 'País', $countries),
                    new Boolean('active', 'Activo'),
                    new Date('birth_date', 'Fecha Nacimiento'),
                ]
            ],
            'observations' => [
                'label' => 'Observaciones',
                'fields' => [
                    new Textarea('observations', 'Observaciones', ['full_width' => true, 'rows' => 4]),
                ]
            ],
            'addresses' => [
                'label' => 'Direcciones',
                'fields' => [
                    new RelationList('addresses', 'Direcciones', [
                        ['field' => 'street', 'label' => 'Calle'],
                        ['field' => 'city', 'label' => 'Ciudad'],
                        ['field' => 'zip', 'label' => 'C. Postal']
                    ], ['col' => 12])
                ]
            ]
        ];
    }
}
