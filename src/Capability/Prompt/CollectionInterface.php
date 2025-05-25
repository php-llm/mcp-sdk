<?php

namespace PhpLlm\McpSdk\Capability\Prompt;

interface CollectionInterface
{
    /**
     * @return MetadataInterface[]
     */
    public function getMetadata(): array;
}
