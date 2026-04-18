<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Infrastructure\Lib;

abstract class Messages
{
    /**
     * Initializes the session if needed and ensures the storage array exists.
     *
     * @return void
     */
    private static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['alxarafe_messages'])) {
            $_SESSION['alxarafe_messages'] = [];
        }
    }

    /**
     * Add a new message (success) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addMessage($message): void
    {
        self::init();
        $_SESSION['alxarafe_messages'][] = ['success' => $message];
    }

    /**
     * Add a new advice (warning) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addAdvice($message): void
    {
        self::init();
        $_SESSION['alxarafe_messages'][] = ['warning' => $message];
    }

    /**
     * Add a new error (danger) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addError($message): void
    {
        self::init();
        $_SESSION['alxarafe_messages'][] = ['danger' => $message];
    }

    /**
     * Generates an array with the messages to be displayed, indicating the
     * type (message, advice or error) and the text to be displayed.
     *
     * @return array
     */
    public static function getMessages(): array
    {
        self::init();
        $alerts = [];
        foreach ($_SESSION['alxarafe_messages'] as $message) {
            foreach ($message as $type => $text) {
                $alerts[] = [
                    'type' => $type,
                    'text' => $text
                ];
            }
        }
        $_SESSION['alxarafe_messages'] = [];
        return $alerts;
    }
}
