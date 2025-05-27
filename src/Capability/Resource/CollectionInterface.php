<?php

namespace PhpLlm\McpSdk\Capability\Resource;

interface CollectionInterface
{
    /**
     * @return MetadataInterface[]
     */
    public function getMetadata(): array;
}
