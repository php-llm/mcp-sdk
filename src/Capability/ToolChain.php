<?php

namespace PhpLlm\McpSdk\Capability;

use PhpLlm\McpSdk\Capability\Tool\CollectionInterface;
use PhpLlm\McpSdk\Capability\Tool\IdentifierInterface;
use PhpLlm\McpSdk\Capability\Tool\MetadataInterface;
use PhpLlm\McpSdk\Capability\Tool\ToolCall;
use PhpLlm\McpSdk\Capability\Tool\ToolCallResult;
use PhpLlm\McpSdk\Capability\Tool\ToolExecutorInterface;
use PhpLlm\McpSdk\Exception\ToolExecutionException;
use PhpLlm\McpSdk\Exception\ToolNotFoundException;

/**
 * A collection of tools. All tools need to implement IdentifierInterface.
 */
class ToolChain implements ToolExecutorInterface, CollectionInterface
{
    /** @var MetadataInterface[] */
    private readonly array $items;

    /**
     * @param IdentifierInterface[] $items
     */
    public function __construct(array $items)
    {
        /** @var MetadataInterface[] $values */
        $values = array_values(array_filter($items, fn ($item) => $item instanceof MetadataInterface));
        $keys = array_map(fn ($item) => $item->getName(), $values);
        $this->items = array_combine($keys, $values);
    }

    public function getMetadata(): array
    {
        return array_values($this->items);
    }

    public function call(ToolCall $input): ToolCallResult
    {
        $item = $this->items[$input->name] ?? null;
        if (!empty($item) && $item instanceof ToolExecutorInterface) {
            try {
                return $item->call($input);
            } catch (\Throwable $e) {
                throw new ToolExecutionException($input, $e);
            }
        }

        throw new ToolNotFoundException($input);
    }
}
