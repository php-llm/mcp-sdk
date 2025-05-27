<?php

namespace PhpLlm\McpSdk\Capability\Tool;

interface CollectionInterface
{
    /**
     * @return MetadataInterface[]
     */
    public function getMetadata(): array;
}
