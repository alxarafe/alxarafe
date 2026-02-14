<?php

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $type
 * @property string $message
 * @property string|null $link
 * @property bool $read
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Notification extends Model
{
    protected $table = 'sys_notifications';

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'link',
        'read',
        'read_at',
    ];

    protected $casts = [
        'read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
