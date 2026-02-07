<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Agenda\Model\Person;

class PersonTest extends TestCase
{
    public function testItCanCreateAPerson()
    {
        $person = Person::create([
            'name' => 'John',
            'lastname' => 'Doe',
            'birth_date' => '1990-01-01',
            'active' => true
        ]);

        $this->assertNotNull($person->id);
        $this->assertEquals('John', $person->name);
        $this->assertEquals('Doe', $person->lastname);
        $this->assertTrue($person->active);

        // Ensure it is in the database (within this transaction)
        $this->assertDatabaseHas('people', [
            'id' => $person->id,
            'name' => 'John'
        ]);
    }

    protected function assertDatabaseHas($table, array $data)
    {
        $query = \Illuminate\Database\Capsule\Manager::table($table);
        foreach ($data as $key => $value) {
            $query->where($key, $value);
        }
        $this->assertTrue($query->exists(), "Record not found in table $table");
    }
}
