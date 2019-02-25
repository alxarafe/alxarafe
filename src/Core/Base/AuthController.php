<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Auth;
use Alxarafe\Models\User;

/**
 * Class AuthController
 *
 * @package Alxarafe\Base
 */
class AuthController extends Controller
{

    /**
     * The user logged.
     *
     * @var User
     */
    public $user;

    /**
     * Contains the data of the currently identified user.
     *
     * @var Auth
     */
    public $userAuth;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}
