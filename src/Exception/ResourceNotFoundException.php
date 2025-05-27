<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Exception;

use PhpLlm\McpSdk\Capability\Resource\ResourceRead;

final class ResourceNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(
        public readonly ResourceRead $readRequest,
    ) {
        parent::__construct(sprintf('Resource not found for uri: "%s"', $readRequest->uri));
    }
}
