<?php

namespace App;

use PhpLlm\McpSdk\Capability\Tool\MetadataInterface;
use PhpLlm\McpSdk\Capability\Tool\ToolCall;
use PhpLlm\McpSdk\Capability\Tool\ToolCallResult;
use PhpLlm\McpSdk\Capability\Tool\ToolExecutorInterface;

class ExampleTool implements MetadataInterface, ToolExecutorInterface
{
    public function call(ToolCall $input): ToolCallResult
    {
        $format = $input->arguments['format'] ?? 'Y-m-d H:i:s';

        return new ToolCallResult(
            (new \DateTime('now', new \DateTimeZone('UTC')))->format($format)
        );
    }

    public function getName(): string
    {
        return 'Current time';
    }

    public function getDescription(): string
    {
        return 'Returns the current time in UTC';
    }

    public function getInputSchema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'format' => [
                    'type' => 'string',
                    'description' => 'The format of the time, e.g. "Y-m-d H:i:s"',
                    'default' => 'Y-m-d H:i:s',
                ],
            ],
            'required' => [],
        ];
    }
}
