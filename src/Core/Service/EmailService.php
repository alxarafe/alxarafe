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

namespace Alxarafe\Service;

use CoreModules\Admin\Model\Setting;

/**
 * Class EmailService.
 *
 * Generic email sending service with SMTP configuration
 * managed via the Settings model.
 *
 * SMTP settings are stored with keys:
 *   smtp_host, smtp_port, smtp_user, smtp_password, smtp_encryption, smtp_from, smtp_from_name
 *
 * Requires: symfony/mailer
 */
class EmailService
{
    /**
     * Send an email.
     *
     * @param string|array $to      Recipient email(s)
     * @param string       $subject Email subject
     * @param string       $body    Email body (HTML or plain text)
     * @param bool         $isHtml  Whether body is HTML (default: true)
     * @param array        $attachments Array of file paths to attach
     * @return bool True on success
     * @throws \RuntimeException If SMTP is not configured or sending fails
     */
    public static function send(
        string|array $to,
        string $subject,
        string $body,
        bool $isHtml = true,
        array $attachments = []
    ): bool {
        $transport = self::createTransport();
        $mailer = new \Symfony\Component\Mailer\Mailer($transport);

        $email = new \Symfony\Component\Mime\Email();

        // From
        $fromAddress = Setting::get('smtp_from', 'noreply@localhost');
        $fromName = Setting::get('smtp_from_name', 'Alxarafe');
        $email->from(new \Symfony\Component\Mime\Address($fromAddress, $fromName));

        // To (support single or multiple)
        $recipients = is_array($to) ? $to : [$to];
        foreach ($recipients as $recipient) {
            $email->addTo($recipient);
        }

        // Subject and body
        $email->subject($subject);
        if ($isHtml) {
            $email->html($body);
        } else {
            $email->text($body);
        }

        // Attachments
        foreach ($attachments as $filePath) {
            if (file_exists($filePath)) {
                $email->attachFromPath($filePath);
            }
        }

        try {
            $mailer->send($email);
            return true;
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            error_log('EmailService send error: ' . $e->getMessage());
            throw new \RuntimeException('Email sending failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Send an email using a named template with variable substitution.
     *
     * @param string $templateCode Template code (e.g., 'password_reset')
     * @param string|array $to     Recipient email(s)
     * @param array $variables     Variables to substitute in the template
     * @return bool True on success
     * @throws \RuntimeException If template not found
     */
    public static function sendTemplate(string $templateCode, string|array $to, array $variables = []): bool
    {
        $template = \CoreModules\Admin\Model\EmailTemplate::where('code', $templateCode)
            ->where('active', true)
            ->first();

        if (!$template) {
            throw new \RuntimeException("Email template not found or inactive: {$templateCode}");
        }

        $subject = self::substituteVariables($template->subject, $variables);
        $body = self::substituteVariables($template->body, $variables);

        return self::send($to, $subject, $body);
    }

    /**
     * Replace {variable_name} placeholders in a string with actual values.
     */
    private static function substituteVariables(string $text, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $text = str_replace('{' . $key . '}', (string) $value, $text);
        }
        return $text;
    }

    /**
     * Create the Symfony Mailer transport from settings.
     *
     * @return \Symfony\Component\Mailer\Transport\TransportInterface
     */
    private static function createTransport(): \Symfony\Component\Mailer\Transport\TransportInterface
    {
        $host = Setting::get('smtp_host', 'localhost');
        $port = (int) Setting::get('smtp_port', '587');
        $user = Setting::get('smtp_user', '');
        $password = Setting::get('smtp_password', '');
        $encryption = Setting::get('smtp_encryption', 'tls'); // tls, ssl, or empty

        // Build DSN: smtp://user:password@host:port
        $dsn = 'smtp://';
        if (!empty($user)) {
            $dsn .= urlencode($user);
            if (!empty($password)) {
                $dsn .= ':' . urlencode($password);
            }
            $dsn .= '@';
        }
        $dsn .= $host . ':' . $port;

        // Add encryption parameter
        if (!empty($encryption) && $encryption !== 'none') {
            $dsn .= '?encryption=' . $encryption;
        }

        return \Symfony\Component\Mailer\Transport::fromDsn($dsn);
    }

    /**
     * Test current SMTP configuration by sending a test email.
     *
     * @param string $to Test recipient address
     * @return bool True if test email sent successfully
     */
    public static function testConnection(string $to): bool
    {
        return self::send(
            $to,
            'Alxarafe SMTP Test',
            '<h1>SMTP Configuration Test</h1><p>If you received this email, your SMTP settings are correct.</p>'
        );
    }
}
