<?php

namespace App;

use PhpLlm\McpSdk\Capability\PromptChain;
use PhpLlm\McpSdk\Capability\ResourceChain;
use PhpLlm\McpSdk\Capability\ToolChain;
use PhpLlm\McpSdk\Server\NotificationHandler;
use PhpLlm\McpSdk\Server\NotificationHandler\InitializedHandler;
use PhpLlm\McpSdk\Server\RequestHandler;
use PhpLlm\McpSdk\Server\RequestHandler\InitializeHandler;
use PhpLlm\McpSdk\Server\RequestHandler\PingHandler;
use PhpLlm\McpSdk\Server\RequestHandler\PromptGetHandler;
use PhpLlm\McpSdk\Server\RequestHandler\PromptListHandler;
use PhpLlm\McpSdk\Server\RequestHandler\ResourceListHandler;
use PhpLlm\McpSdk\Server\RequestHandler\ResourceReadHandler;
use PhpLlm\McpSdk\Server\RequestHandler\ToolCallHandler;
use PhpLlm\McpSdk\Server\RequestHandler\ToolListHandler;

class Builder
{
    /**
     * @return list<RequestHandler>
     */
    public static function buildRequestHandlers(): array
    {
        $promptManager = new PromptChain([
            new ExamplePrompt(),
        ]);

        $resourceManager = new ResourceChain([
            new ExampleResource(),
        ]);

        $toolManager = new ToolChain([
            new ExampleTool(),
        ]);

        return [
            new InitializeHandler(),
            new PingHandler(),
            new PromptListHandler($promptManager),
            new PromptGetHandler($promptManager),
            new ResourceListHandler($resourceManager),
            new ResourceReadHandler($resourceManager),
            new ToolCallHandler($toolManager),
            new ToolListHandler($toolManager),
        ];
    }

    /**
     * @return list<NotificationHandler>
     */
    public static function buildNotificationHandlers(): array
    {
        return [
            new InitializedHandler(),
        ];
    }
}
