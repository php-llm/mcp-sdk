<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Exception;

use PhpLlm\McpSdk\Capability\Resource\ResourceRead;

final class ResourceReadException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(
        public readonly ResourceRead $readRequest,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(sprintf('Reading resource "%s" failed with error: %s', $readRequest->uri, $previous?->getMessage() ?? ''), previous: $previous);
    }
}
