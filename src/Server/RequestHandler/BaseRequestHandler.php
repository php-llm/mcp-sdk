<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server\RequestHandler;

use PhpLlm\McpSdk\Message\Request;
use PhpLlm\McpSdk\Server\RequestHandlerInterface;

abstract class BaseRequestHandler implements RequestHandlerInterface
{
    public function supports(Request $message): bool
    {
        return $message->method === $this->supportedMethod();
    }

    abstract protected function supportedMethod(): string;
}
