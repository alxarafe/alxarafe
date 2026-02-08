<?php

namespace Modules\Agenda\Model;

use Alxarafe\Base\Model\Model;

class Country extends Model
{
    protected $table = 'countries';

    protected $fillable = [
        'code',
        'name',
    ];

    public function people()
    {
        return $this->hasMany(Person::class);
    }
}
