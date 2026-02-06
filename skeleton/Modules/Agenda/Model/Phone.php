<?php

namespace Modules\Agenda\Model;

use Alxarafe\Base\Model\Model;

/**
 * Class Phone
 *
 * @property int $id
 * @property string $number
 * @property string $type
 * @property int $person_id
 *
 * @package Modules\Agenda\Model
 */
class Phone extends Model
{
    protected $table = 'phones';

    protected $fillable = [
        'number',
        'type',
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
