<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server\RequestHandler;

use PhpLlm\McpSdk\Message\Request;
use PhpLlm\McpSdk\Message\Response;

final class InitializeHandler extends BaseRequestHandler
{
    public function __construct(
        private readonly string $name = 'app',
        private readonly string $version = 'dev',
    ) {
    }

    public function createResponse(Request $message): Response
    {
        return new Response($message->id, [
            'protocolVersion' => '2025-03-26',
            'capabilities' => [
                'prompts' => ['listChanged' => false],
                'tools' => ['listChanged' => false],
                'resources' => ['listChanged' => false, 'subscribe' => false],
            ],
            'serverInfo' => ['name' => $this->name, 'version' => $this->version],
        ]);
    }

    protected function supportedMethod(): string
    {
        return 'initialize';
    }
}
