<?php

declare(strict_types=1);

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;

/**
 * Class EmailTemplate.
 * Stores email templates with variable placeholders.
 *
 * @property int $id
 * @property string $code       Unique template code (e.g., 'password_reset')
 * @property string $subject    Subject line with {variable} placeholders
 * @property string $body       HTML body with {variable} placeholders
 * @property string|null $variables  JSON array of available variable names
 * @property bool $active
 */
class EmailTemplate extends Model
{
    protected $table = 'email_templates';

    protected $fillable = [
        'code',
        'subject',
        'body',
        'variables',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Get the list of available variable names for this template.
     *
     * @return array
     */
    public function getVariableNames(): array
    {
        if (empty($this->variables)) {
            return [];
        }
        $decoded = json_decode($this->variables, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Render this template with the given variables.
     *
     * @param array $variables Key-value pairs to substitute
     * @return array {subject: string, body: string}
     */
    public function render(array $variables = []): array
    {
        $subject = $this->subject;
        $body = $this->body;

        foreach ($variables as $key => $value) {
            $placeholder = '{' . $key . '}';
            $subject = str_replace($placeholder, (string) $value, $subject);
            $body = str_replace($placeholder, (string) $value, $body);
        }

        return [
            'subject' => $subject,
            'body' => $body,
        ];
    }
}
