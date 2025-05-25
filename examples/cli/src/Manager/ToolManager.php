<?php

namespace App\Manager;

use PhpLlm\McpSdk\Capability\Tool\CollectionInterface;
use PhpLlm\McpSdk\Capability\Tool\MetadataInterface;
use PhpLlm\McpSdk\Capability\Tool\ToolCall;
use PhpLlm\McpSdk\Capability\Tool\ToolCallResult;
use PhpLlm\McpSdk\Capability\Tool\ToolExecutorInterface;
use PhpLlm\McpSdk\Exception\ToolExecutionException;
use PhpLlm\McpSdk\Exception\ToolNotFoundException;

class ToolManager implements ToolExecutorInterface, CollectionInterface
{
    public function __construct(
        /**
         * @var (MetadataInterface | callable(ToolCall):ToolCallResult)[] $items
         */
        private array $items,
    ) {
    }

    public function getMetadata(): array
    {
        return $this->items;
    }

    public function execute(ToolCall $toolCall): ToolCallResult
    {
        foreach ($this->items as $item) {
            if ($toolCall->name === $item->getName()) {
                try {
                    return $item($toolCall);
                } catch (\Throwable $e) {
                    throw new ToolExecutionException($toolCall, $e);
                }
            }
        }

        throw new ToolNotFoundException($toolCall);
    }
}
