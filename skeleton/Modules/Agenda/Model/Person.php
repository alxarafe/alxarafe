<?php

namespace Modules\Agenda\Model;

use Alxarafe\Base\Model\Model;

/**
 * Class Person
 *
 * @property int $id
 * @property string $name
 * @property string $lastname
 * @property bool $active
 * @property string $birth_date
 * @property string $observations
 *
 * @package Modules\Agenda\Model
 */
class Person extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'people';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'active',
        'birth_date',
        'observations',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'birth_date' => 'date:Y-m-d',
        'active' => 'boolean',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}
