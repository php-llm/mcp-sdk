<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Tool;

final readonly class ToolCallResult
{
    public function __construct(
        public string $result,
        /**
         * @var "text"|"image"|"audio"|"resource"|non-empty-string
         */
        public string $type = 'text',
        public string $mimeType = 'text/plan',
        public bool $isError = false,
        public ?string $uri = null,
    ) {
    }
}
