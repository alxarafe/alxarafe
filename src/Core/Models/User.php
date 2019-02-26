<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;
use Alxarafe\Helpers\Utils;

/**
 * Class Users
 *
 * @property int    $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $register_date
 * @property int    $active
 * @property string $logkey
 *
 * @package Alxarafe\Models
 */
class User extends Table
{
    /**
     * User constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = true)
    {
        parent::__construct(
            'users',
            [
                'idField' => 'id',
                'nameField' => 'username',
                'create' => $create,
            ]
        );
    }

    /**
     * Verify is log key is correct.
     *
     * @param string $userName
     * @param string $hash
     *
     * @return bool
     */
    public function verifyLogKey(string $userName, string $hash): bool
    {
        $status = false;
        $this->user = new User();
        if ($this->user->getBy('username', $userName) === true && $hash === $this->user->logkey) {
            $this->username = $this->user->username;
            $this->logkey = $this->user->logkey;
            $status = true;
        }
        return $status;
    }

    /**
     * Verify that user password was valid.
     *
     * @param string $password
     *
     * @return bool
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * Generate a log key.
     *
     * @param string $ip
     * @param bool   $unique
     *
     * @return string
     */
    public function generateLogKey(string $ip = '', bool $unique = true): string
    {
        $logkey = '';
        if (!empty($this->username)) {
            $user = new User();
            $user->getBy('username', $this->username);
            $text = $this->username;
            if ($unique) {
                $text .= '|' . $ip . '|' . date('Y-m-d H:i:s');
            }
            $text .= '|' . Utils::randomString();
            $logkey = password_hash($text, PASSWORD_DEFAULT);

            $this->user->logkey = $logkey;
            $this->user->save();
        }

        return $logkey;
    }
}
