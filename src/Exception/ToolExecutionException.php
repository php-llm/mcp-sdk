<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Exception;

use PhpLlm\McpSdk\Capability\Tool\ToolCall;

final class ToolExecutionException extends \RuntimeException implements ExceptionInterface
{
    public function __construct(
        public readonly ToolCall $toolCall,
        ?\Throwable $previous = null,
    ) {
        parent::__construct(sprintf('Execution of tool "%s" failed with error: %s', $toolCall->name, $previous?->getMessage() ?? ''), previous: $previous);
    }
}
