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

namespace Alxarafe\Infrastructure\Adapter\Mailer;

use Alxarafe\Domain\Port\Driven\MailerPort;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

/**
 * SymfonyMailerAdapter — Mailer adapter using Symfony Mailer.
 *
 * Wraps the existing Symfony Mailer integration behind the MailerPort contract.
 *
 * @package Alxarafe\Infrastructure\Adapter\Mailer
 */
class SymfonyMailerAdapter implements MailerPort
{
    private Mailer $mailer;
    private string $fromAddress;
    private string $fromName;

    /**
     * @param string $dsn         Symfony Mailer DSN (e.g., 'smtp://user:pass@host:port').
     * @param string $fromAddress Default sender email address.
     * @param string $fromName    Default sender name.
     */
    public function __construct(
        string $dsn,
        string $fromAddress = 'noreply@localhost',
        string $fromName = 'Alxarafe'
    ) {
        $transport = Transport::fromDsn($dsn);
        $this->mailer = new Mailer($transport);
        $this->fromAddress = $fromAddress;
        $this->fromName = $fromName;
    }

    /** @inheritDoc */
    public function send(
        string|array $to,
        string $subject,
        string $body,
        bool $isHtml = true,
        array $attachments = []
    ): bool {
        $email = new Email();
        $email->from(new Address($this->fromAddress, $this->fromName));

        $recipients = is_array($to) ? $to : [$to];
        foreach ($recipients as $recipient) {
            $email->addTo($recipient);
        }

        $email->subject($subject);

        if ($isHtml) {
            $email->html($body);
        } else {
            $email->text($body);
        }

        foreach ($attachments as $filePath) {
            if (file_exists($filePath)) {
                $email->attachFromPath($filePath);
            }
        }

        try {
            $this->mailer->send($email);
            return true;
        } catch (\Throwable $e) {
            throw new \RuntimeException('Email sending failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /** @inheritDoc */
    public function sendBatch(
        array $recipients,
        string $subject,
        string $body,
        bool $isHtml = true
    ): array {
        $results = [];

        foreach ($recipients as $recipient) {
            try {
                $results[$recipient] = $this->send($recipient, $subject, $body, $isHtml);
            } catch (\Throwable) {
                $results[$recipient] = false;
            }
        }

        return $results;
    }
}
