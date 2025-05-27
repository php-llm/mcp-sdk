<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Resource;

final readonly class ResourceRead
{
    public function __construct(
        public string $id,
        public string $uri,
    ) {
    }
}
