<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server\RequestHandler;

use PhpLlm\McpSdk\Message\Request;
use PhpLlm\McpSdk\Message\Response;

final class PingHandler extends BaseRequestHandler
{
    public function createResponse(Request $message): Response
    {
        return new Response($message->id, []);
    }

    protected function supportedMethod(): string
    {
        return 'ping';
    }
}
