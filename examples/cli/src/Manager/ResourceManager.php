<?php

namespace App\Manager;

use PhpLlm\McpSdk\Capability\Resource\CollectionInterface;
use PhpLlm\McpSdk\Capability\Resource\MetadataInterface;
use PhpLlm\McpSdk\Capability\Resource\ResourceRead;
use PhpLlm\McpSdk\Capability\Resource\ResourceReaderInterface;
use PhpLlm\McpSdk\Capability\Resource\ResourceReadResult;
use PhpLlm\McpSdk\Exception\ResourceNotFoundException;
use PhpLlm\McpSdk\Exception\ResourceReadException;

class ResourceManager implements CollectionInterface, ResourceReaderInterface
{
    public function __construct(
        /**
         * TODO this is bad design. What if we want to add resource/exists, then this becomes invalid and we need a BC break
         * @var (MetadataInterface | callable(ResourceRead):ResourceReadResult)[]
         */
        private array $items,
    ) {
    }

    public function getMetadata(): array
    {
        return $this->items;
    }

    public function read(ResourceRead $request): ResourceReadResult
    {
        foreach ($this->items as $item) {
            if ($item instanceof ReadInterface && $request->uri === $item->getUri()) {
                try {
                    return $item($request);
                } catch (\Throwable $e) {
                    throw new ResourceReadException($request, $e);
                }
            }
        }

        throw new ResourceNotFoundException($request);
    }
}
