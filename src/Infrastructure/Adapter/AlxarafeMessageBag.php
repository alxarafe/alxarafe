<?php

declare(strict_types=1);

namespace Alxarafe\Infrastructure\Adapter;

use Alxarafe\Infrastructure\Lib\Messages;
use Alxarafe\ResourceController\Contracts\MessageBagContract;

/**
 * AlxarafeMessageBag — Bridges Messages to MessageBagContract.
 */
class AlxarafeMessageBag implements MessageBagContract
{
    public function success(string $message): void
    {
        Messages::addMessage($message);
    }

    public function error(string $message): void
    {
        Messages::addError($message);
    }

    public function warning(string $message): void
    {
        Messages::addAdvice($message);
    }

    public function getMessages(): array
    {
        return Messages::getMessages();
    }
}
