<?php

namespace App;

use PhpLlm\McpSdk\Capability\Prompt\MetadataInterface;
use PhpLlm\McpSdk\Capability\Prompt\PromptGet;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetResult;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetResultMessages;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetterInterface;

class ExamplePrompt implements MetadataInterface, PromptGetterInterface
{
    public function get(PromptGet $input): PromptGetResult
    {
        $firstName = $input->arguments['first name'] ?? null;

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
