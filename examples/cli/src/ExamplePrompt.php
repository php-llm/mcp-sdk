<?php

namespace App;

use PhpLlm\McpSdk\Capability\Prompt\MetadataInterface;

class ExamplePrompt implements MetadataInterface
{
    public function __invoke(?string $firstName = null): string
    {
        return sprintf('Hello %s', $firstName ?? 'World');
    }

    public function getName(): string
    {
        return 'Greet';
    }

    public function getDescription(): ?string
    {
        return 'Greet a person with a nice message';
    }

    public function getArguments(): array
    {
        return [
            [
                'name' => 'firstName',
                'description' => 'The name of the person to greet',
                'required' => false,
            ],
        ];
    }
}
