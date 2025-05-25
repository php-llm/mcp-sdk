<?php

namespace PhpLlm\McpSdk\Capability\Tool;

interface ToolCollectionInterface
{
    /**
     * @return MetadataInterface[]
     */
    public function getMetadata(): array;
}
