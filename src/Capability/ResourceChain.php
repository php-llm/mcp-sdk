<?php

namespace PhpLlm\McpSdk\Capability;

use PhpLlm\McpSdk\Capability\Resource\CollectionInterface;
use PhpLlm\McpSdk\Capability\Resource\IdentifierInterface;
use PhpLlm\McpSdk\Capability\Resource\MetadataInterface;
use PhpLlm\McpSdk\Capability\Resource\ResourceRead;
use PhpLlm\McpSdk\Capability\Resource\ResourceReaderInterface;
use PhpLlm\McpSdk\Capability\Resource\ResourceReadResult;
use PhpLlm\McpSdk\Exception\ResourceNotFoundException;
use PhpLlm\McpSdk\Exception\ResourceReadException;

/**
 * A collection of resources. All resources need to implement IdentifierInterface.
 */
class ResourceChain implements CollectionInterface, ResourceReaderInterface
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
        $keys = array_map(fn ($item) => $item->getUri(), $values);
        $this->items = array_combine($keys, $values);
    }

    public function getMetadata(): array
    {
        return array_values($this->items);
    }

    public function read(ResourceRead $input): ResourceReadResult
    {
        $item = $this->items[$input->uri] ?? null;
        if (!empty($item) && $item instanceof ResourceReaderInterface) {
            try {
                return $item->read($input);
            } catch (\Throwable $e) {
                throw new ResourceReadException($input, $e);
            }
        }

        throw new ResourceNotFoundException($input);
    }
}
