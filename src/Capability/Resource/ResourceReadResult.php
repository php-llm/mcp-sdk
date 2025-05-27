<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Resource;

final readonly class ResourceReadResult
{
    public function __construct(
        public string $result,
        public string $uri,

        /**
         * @var "text"|"blob"
         */
        public string $type = 'text',
        public string $mimeType = 'text/plain',
    ) {
    }
}
