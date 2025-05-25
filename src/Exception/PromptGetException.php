<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Exception;

use PhpLlm\McpSdk\Capability\Prompt\PromptGet;

final class PromptGetException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(
        public readonly PromptGet $promptGet,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(sprintf('Handling prompt "%s" failed with error: %s', $promptGet->name, $previous->getMessage()), previous: $previous);
    }
}
