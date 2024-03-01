<?php

declare(strict_types=1);

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Password Reset Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are the default lines which match reasons
    | that are given by the password broker for a password update attempt
    | has failed, such as for an invalid token or invalid new password.
    |
    */
    'reset' => 'Tu contraseña ha sido restablecida.',
    'sent' => 'Hemos enviado por correo electrónico el enlace para restablecer tu contraseña.',
    'throttled' => 'Por favor, espera antes de intentarlo de nuevo.',
    'token' => 'Este token de restablecimiento de contraseña no es válido.',
    'user' => 'No podemos encontrar un usuario con esa dirección de correo electrónico.',
];
