<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server\RequestHandler;

use PhpLlm\McpSdk\Capability\Prompt\CollectionInterface;
use PhpLlm\McpSdk\Capability\Prompt\MetadataInterface;
use PhpLlm\McpSdk\Message\Notification;
use PhpLlm\McpSdk\Message\Request;
use PhpLlm\McpSdk\Message\Response;

final class PromptListHandler extends BaseRequestHandler
{
    public function __construct(
        private readonly CollectionInterface $collection,
    ) {
    }

    public function createResponse(Request|Notification $message): Response
    {
        return new Response($message->id, [
            'prompts' => array_map(function (MetadataInterface $metadata) {
                $result = [
                    'name' => $metadata->getName(),
                ];

                $description = $metadata->getDescription();
                if (null !== $description) {
                    $result['description'] = $description;
                }

                $arguments = [];
                foreach ($metadata->getArguments() as $data) {
                    $argument = [
                        'name' => $data['name'],
                        'required' => $data['required'] ?? false,
                    ];

                    if (isset($data['description'])) {
                        $argument['description'] = $data['description'];
                    }
                    $arguments[] = $argument;
                }

                if ([] !== $arguments) {
                    $result['arguments'] = $arguments;
                }

                return $result;
            }, $this->collection->getMetadata()),
        ]);
    }

    protected function supportedMethod(): string
    {
        return 'prompts/list';
    }
}
