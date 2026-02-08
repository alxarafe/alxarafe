<?php

namespace Modules\Agenda\Controller;

use Alxarafe\Base\Controller\ResourceController;
use Alxarafe\Component\Fields\Boolean;
use Alxarafe\Component\Fields\Date;
use Alxarafe\Component\Fields\Text;
use Modules\Agenda\Model\Address;
use Modules\Agenda\Model\Person;
use Alxarafe\Component\Fields\Select;

class DemoAddressController extends ResourceController
{
    // Define the model
    protected function getModelClass()
    {
        return Address::class;
    }

    // Eager Load 'person' relation to avoid N+1 queries
    protected array $with = ['person'];

    // Define columns for the List View
    protected function getListFields(): array
    {
        return [
            new Text('id', 'ID', ['width' => '50px']),
            new Text('street', 'Calle'),
            new Text('city', 'Ciudad'),
            new Text('zip', 'C. Postal'),

            // Related Fields (N:1) - Demonstrating Dot Notation
            new Text('person.name', 'Persona (Nombre)'),
            new Text('person.lastname', 'Persona (Apellido)'),

            // Related Boolean Field
            new Boolean('person.active', 'Persona Activa'),

            // Related Date Field
            new Date('person.birth_date', 'Fecha Nacimiento'),
        ];
    }

    // Define fields for the Edit Form
    protected function getEditFields(): array
    {
        // Fetch persons for the select (simple example, ideally should be cached or optimized)
        $persons = [];
        try {
            $persons = Person::all()->pluck('name', 'id')->toArray();
        } catch (\Exception $e) {
        }

        return [
            new Text('street', 'Calle', ['required' => true]),
            new Text('city', 'Ciudad', ['required' => true]),
            new Text('zip', 'C. Postal', ['required' => true]),

            // Edit relation via Select
            new Select('person_id', 'Persona', $persons),
        ];
    }
}
