<?php

namespace Modules\Agenda\Controller;

use Alxarafe\Base\Controller\ResourceController;
use Alxarafe\Component\Fields\Boolean;
use Alxarafe\Component\Fields\Date;
use Alxarafe\Component\Fields\RelationList;
use Alxarafe\Component\Fields\Select;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Component\Fields\Textarea;
use Alxarafe\Lib\Trans;
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
            new Text('id', Trans::_('person.id'), ['width' => '50px']),
            new Text('name', Trans::_('person.name')),
            new Text('lastname', Trans::_('person.lastname')),

            // 1:1 Relation Field (Dot Notation)
            new Text('country.name', Trans::_('person.country.name')),

            new Boolean('active', Trans::_('person.active')),
            new Date('birth_date', Trans::_('person.birthdate')),
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
                'label' => Trans::_('person.tab.general'),
                'fields' => [
                    new Text('name', Trans::_('person.name')),
                    new Text('lastname', Trans::_('person.lastname')),
                    new Select('country_id', Trans::_('person.country.name'), $countries),
                    new Boolean('active', Trans::_('person.active')),
                    new Date('birth_date', Trans::_('person.birthdate')),
                ]
            ],
            'observations' => [
                'label' => Trans::_('person.tab.observations'),
                'fields' => [
                    new Textarea('observations', Trans::_('person.tab.observations'), ['full_width' => true, 'rows' => 4]),
                ]
            ],
            'addresses' => [
                'label' => Trans::_('person.tab.addresses'),
                'fields' => [
                    new RelationList('addresses', Trans::_('person.tab.addresses'), [
                        ['field' => 'street', 'label' => Trans::_('person.address.street')],
                        ['field' => 'city', 'label' => Trans::_('person.address.city')],
                        ['field' => 'zip', 'label' => Trans::_('person.address.zip')]
                    ], ['col' => 12])
                ]
            ]
        ];
    }
}
