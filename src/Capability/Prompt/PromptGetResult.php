<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Prompt;

final readonly class PromptGetResult
{
    /**
     * @param list<PromptGetResultMessages> $messages
     */
    public function __construct(
        public string $description,
        public array $messages = [],
    ) {
    }
}
