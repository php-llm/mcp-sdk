<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server;

use PhpLlm\McpSdk\Message\Notification;

interface NotificationHandler
{
    public function supports(Notification $message): bool;

    public function handle(Notification $notification): null;
}
