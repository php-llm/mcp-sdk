<?php

namespace App;

use App\Manager\PromptManager;
use App\Manager\ResourceManager;
use App\Manager\ToolManager;
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
        $promptManager = new PromptManager();
        $resourceManager = new ResourceManager();
        $toolManager = new ToolManager();

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
