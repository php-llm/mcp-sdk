<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Prompt;

final readonly class PromptGetResultMessages
{
    public function __construct(
        public string $role,
        public string $result,
        /**
         * @var "text"|"image"|"audio"|"resource"|non-empty-string
         */
        public string $type = 'text',
        public string $mimeType = 'text/plan',
        public ?string $uri = null,
    ) {
    }
}
