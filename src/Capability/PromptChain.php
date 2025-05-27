<?php

namespace PhpLlm\McpSdk\Capability;

use PhpLlm\McpSdk\Capability\Prompt\CollectionInterface;
use PhpLlm\McpSdk\Capability\Prompt\IdentifierInterface;
use PhpLlm\McpSdk\Capability\Prompt\MetadataInterface;
use PhpLlm\McpSdk\Capability\Prompt\PromptGet;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetResult;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetterInterface;
use PhpLlm\McpSdk\Exception\PromptGetException;
use PhpLlm\McpSdk\Exception\PromptNotFoundException;

/**
 * A collection of prompts. All prompts need to implement IdentifierInterface.
 */
class PromptChain implements PromptGetterInterface, CollectionInterface
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

    public function get(PromptGet $input): PromptGetResult
    {
        $item = $this->items[$input->name] ?? null;
        if (!empty($item) && $item instanceof PromptGetterInterface) {
            try {
                return $item->get($input);
            } catch (\Throwable $e) {
                throw new PromptGetException($input, $e);
            }
        }

        throw new PromptNotFoundException($input);
    }
}
