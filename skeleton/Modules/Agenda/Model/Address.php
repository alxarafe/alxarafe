<?php

namespace Modules\Agenda\Model;

use Alxarafe\Base\Model\Model;

/**
 * Class Address
 *
 * @property int $id
 * @property string $street
 * @property string $city
 * @property string $zip
 * @property int $person_id
 *
 * @package Modules\Agenda\Model
 */
class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'street',
        'city',
        'zip',
        'person_id',
    ];

    protected $casts = [
        'person_id' => 'integer',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
