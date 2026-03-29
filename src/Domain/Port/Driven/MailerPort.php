<?php

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

declare(strict_types=1);

namespace Alxarafe\Domain\Port\Driven;

/**
 * MailerPort — Secondary (driven) port for sending emails.
 *
 * Decouples the application from specific mailer implementations
 * (Symfony Mailer, PHPMailer, SendGrid API, etc.).
 *
 * @package Alxarafe\Domain\Port\Driven
 */
interface MailerPort
{
    /**
     * Send an email to one or more recipients.
     *
     * @param string|array<string> $to          Recipient email address(es).
     * @param string               $subject     Email subject line.
     * @param string               $body        Email body content.
     * @param bool                 $isHtml      Whether the body is HTML (default: true).
     * @param array<string>        $attachments File paths to attach.
     *
     * @return bool True if the email was sent successfully.
     *
     * @throws \RuntimeException If sending fails.
     */
    public function send(
        string|array $to,
        string $subject,
        string $body,
        bool $isHtml = true,
        array $attachments = []
    ): bool;

    /**
     * Send an email to multiple recipients, returning per-recipient results.
     *
     * @param array<string> $recipients List of email addresses.
     * @param string        $subject    Email subject line.
     * @param string        $body       Email body content.
     * @param bool          $isHtml     Whether the body is HTML.
     *
     * @return array<string, bool> Map of email address => success status.
     */
    public function sendBatch(
        array $recipients,
        string $subject,
        string $body,
        bool $isHtml = true
    ): array;
}
