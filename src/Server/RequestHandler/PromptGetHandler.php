<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server\RequestHandler;

use PhpLlm\McpSdk\Capability\Prompt\PromptGet;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetterInterface;
use PhpLlm\McpSdk\Exception\ExceptionInterface;
use PhpLlm\McpSdk\Message\Error;
use PhpLlm\McpSdk\Message\Request;
use PhpLlm\McpSdk\Message\Response;

final class PromptGetHandler extends BaseRequestHandler
{
    public function __construct(
        private readonly PromptGetterInterface $getter,
    ) {
    }

    public function createResponse(Request $message): Response|Error
    {
        $name = $message->params['name'];
        $arguments = $message->params['arguments'] ?? [];

        try {
            $result = $this->getter->get(new PromptGet(uniqid('', true), $name, $arguments));
        } catch (ExceptionInterface) {
            return Error::internalError($message->id, 'Error while handling prompt');
        }

        $messages = [];
        foreach ($result->messages as $resultMessage) {
            $content = match ($resultMessage->type) {
                'text' => [
                    'type' => 'text',
                    'text' => $resultMessage->result,
                ],
                'image', 'audio' => [
                    'type' => $resultMessage->type,
                    'data' => $resultMessage->result,
                    'mimeType' => $resultMessage->mimeType,
                ],
                'resource' => [
                    'type' => 'resource',
                    'resource' => [
                        'uri' => $resultMessage->uri,
                        'mimeType' => $resultMessage->mimeType,
                        'text' => $resultMessage->result,
                    ],
                ],
                // TODO better exception
                default => throw new \InvalidArgumentException('Unsupported PromptGet result type: '.$resultMessage->type),
            };

            $messages[] = [
                'role' => $resultMessage->role,
                'content' => $content,
            ];
        }

        return new Response($message->id, [
            'description' => $result->description,
            'messages' => $messages,
        ]);
    }

    protected function supportedMethod(): string
    {
        return 'prompts/get';
    }
}
