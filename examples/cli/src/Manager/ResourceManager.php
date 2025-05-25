<?php

namespace App\Manager;

use App\ExampleResource;
use PhpLlm\McpSdk\Capability\Resource\CollectionInterface;
use PhpLlm\McpSdk\Capability\Resource\ResourceRead;
use PhpLlm\McpSdk\Capability\Resource\ResourceReaderInterface;
use PhpLlm\McpSdk\Capability\Resource\ResourceReadResult;
use PhpLlm\McpSdk\Exception\ResourceNotFoundException;

class ResourceManager implements CollectionInterface, ResourceReaderInterface
{
    /**
     * @var mixed[]
     */
    private array $items;

    public function __construct(
    ) {
        $this->items = [
            new ExampleResource(),
        ];
    }

    public function getMetadata(): array
    {
        return $this->items;
    }

    public function read(ResourceRead $request): ResourceReadResult
    {
        foreach ($this->items as $resource) {
            if ($request->uri === $resource->getUri()) {
                // In a real implementation, you would read the resource from its URI.
                // Here we just return a dummy string for demonstration purposes.
                return new ResourceReadResult(
                    'Content of '.$resource->getName(),
                    $resource->getUri(),
                );
            }
        }

        throw new ResourceNotFoundException($request);
    }
}
