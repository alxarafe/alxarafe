<?php

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;

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
