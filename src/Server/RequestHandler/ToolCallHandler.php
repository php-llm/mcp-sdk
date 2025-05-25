<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server\RequestHandler;

use PhpLlm\LlmChain\Chain\Toolbox\ToolboxInterface;
use PhpLlm\LlmChain\Exception\ExceptionInterface;
use PhpLlm\LlmChain\Model\Response\ToolCall;
use PhpLlm\McpSdk\Message\Error;
use PhpLlm\McpSdk\Message\Request;
use PhpLlm\McpSdk\Message\Response;

final class ToolCallHandler extends BaseRequestHandler
{
    public function __construct(
        private readonly ToolboxInterface $toolbox,
    ) {
    }

    public function createResponse(Request $message): Response|Error
    {
        $name = $message->params['name'];
        $arguments = $message->params['arguments'] ?? [];

        try {
            $result = $this->toolbox->execute(new ToolCall(uniqid(), $name, $arguments));
        } catch (ExceptionInterface) {
            return Error::internalError($message->id, 'Error while executing tool');
        }

        return new Response($message->id, [
            'content' => [
                ['type' => 'text', 'text' => $result],
            ],
        ]);
    }

    protected function supportedMethod(): string
    {
        return 'tools/call';
    }
}
