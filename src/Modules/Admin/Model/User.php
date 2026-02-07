<?php

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * @method static find($user)
 * @method static where($column, $operator = null, $value = null, $boolean = 'and')
 */
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $token
 * @property bool $is_admin
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
