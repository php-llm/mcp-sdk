<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server\NotificationHandler;

use PhpLlm\McpSdk\Message\Notification;
use PhpLlm\McpSdk\Server\NotificationHandlerInterface;

abstract class BaseNotificationHandler implements NotificationHandlerInterface
{
    public function supports(Notification $message): bool
    {
        return $message->method === sprintf('notifications/%s', $this->supportedNotification());
    }

    abstract protected function supportedNotification(): string;
}
