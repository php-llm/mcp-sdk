<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Exception;

use PhpLlm\McpSdk\Capability\Prompt\PromptGet;

final class PromptNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(
        public readonly PromptGet $promptGet,
    ) {
        parent::__construct(sprintf('Resource not found for uri: "%s"', $promptGet->name));
    }
}
