<?php

namespace App;

use PhpLlm\McpSdk\Capability\Tool\MetadataInterface;

class ExampleTool implements MetadataInterface
{
    public function __invoke(string $format = 'Y-m-d H:i:s'): string
    {
        return (new \DateTime('now', new \DateTimeZone('UTC')))->format($format);
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
