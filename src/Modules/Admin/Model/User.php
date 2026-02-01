<?php

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * @method static find($user)
 */
/**
 * @property string $token
 */
final class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'token', 'is_admin'];
    protected $hidden = ['password', 'token'];

    public function saveToken($token)
    {
        $this->attributes['token'] = $token;
        return $this->save();
    }

    public function getToken()
    {
        return $this->attributes['token'];
    }
}
