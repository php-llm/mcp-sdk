<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Exception;

use PhpLlm\McpSdk\Capability\Tool\ToolCall;

final class ToolNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(
        public readonly ToolCall $toolCall,
    ) {
        parent::__construct(sprintf('Tool not found for call: "%s"', $toolCall->name));
    }
}
