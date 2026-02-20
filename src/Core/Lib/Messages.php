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

namespace Alxarafe\Lib;

abstract class Messages
{
    /**
     * Contains messages, advices and errors pending to be shown.
     *
     * @var array
     */
    private static array $messages = [];

    /**
     * Add a new message (success) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addMessage($message): void
    {
        self::$messages[]['success'] = $message;
    }

    /**
     * Add a new advice (warning) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addAdvice($message): void
    {
        self::$messages[]['warning'] = $message;
    }

    /**
     * Add a new error (danger) to show the user
     *
     * @param $message
     * @return void
     */
    public static function addError($message): void
    {
        self::$messages[]['danger'] = $message;
    }

    /**
     * Generates an array with the messages to be displayed, indicating the
     * type (message, advice or error) and the text to be displayed.
     *
     * @return array
     */
    public static function getMessages(): array
    {
        $alerts = [];
        foreach (self::$messages as $message) {
            foreach ($message as $type => $text) {
                $alerts[] = [
                    'type' => $type,
                    'text' => $text
                ];
            }
        }
        self::$messages = [];
        return $alerts;
    }
}
