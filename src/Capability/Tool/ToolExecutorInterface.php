<?php

namespace PhpLlm\McpSdk\Capability\Tool;

use PhpLlm\McpSdk\Exception\ToolExecutionException;
use PhpLlm\McpSdk\Exception\ToolNotFoundException;

interface ToolExecutorInterface
{
    /**
     * @throws ToolExecutionException if the tool execution fails
     * @throws ToolNotFoundException  if the tool is not found
     */
    public function call(ToolCall $input): ToolCallResult;
}
