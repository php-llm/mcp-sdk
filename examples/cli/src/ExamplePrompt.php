<?php

namespace App;

use PhpLlm\McpSdk\Capability\Prompt\MetadataInterface;
use PhpLlm\McpSdk\Capability\Prompt\PromptGet;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetResult;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetResultMessages;

class ExamplePrompt implements MetadataInterface
{
    public function __invoke(PromptGet $request): PromptGetResult
    {
        $firstName = $request->arguments['first name'] ?? null;

        return new PromptGetResult(
            $this->getDescription(),
            [new PromptGetResultMessages(
                'user',
                sprintf('Hello %s', $firstName ?? 'World')
            )]
        );
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
                'name' => 'first name',
                'description' => 'The name of the person to greet',
                'required' => false,
            ],
        ];
    }
}
