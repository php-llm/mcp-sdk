<?php

namespace App\Manager;

use App\ExampleTool;
use PhpLlm\McpSdk\Capability\Tool\CollectionInterface;
use PhpLlm\McpSdk\Capability\Tool\ToolCall;
use PhpLlm\McpSdk\Capability\Tool\ToolCallResult;
use PhpLlm\McpSdk\Capability\Tool\ToolExecutorInterface;
use PhpLlm\McpSdk\Exception\ToolExecutionException;
use PhpLlm\McpSdk\Exception\ToolNotFoundException;

class ToolManager implements ToolExecutorInterface, CollectionInterface
{
    /**
     * @var mixed[]
     */
    private array $items;

    public function __construct(
    ) {
        $this->items = [
            new ExampleTool(),
        ];
    }

    public function getMetadata(): array
    {
        return $this->items;
    }

    public function execute(ToolCall $toolCall): ToolCallResult
    {
        foreach ($this->items as $tool) {
            if ($toolCall->name === $tool->getName()) {
                try {
                    return new ToolCallResult(
                        $tool->__invoke(...$toolCall->arguments),
                    );
                } catch (\Throwable $e) {
                    throw new ToolExecutionException($toolCall, $e);
                }
            }
        }

        throw new ToolNotFoundException($toolCall);
    }
}
