<?php

namespace App;

use PhpLlm\McpSdk\Capability\Resource\MetadataInterface;
use PhpLlm\McpSdk\Capability\Resource\ResourceRead;
use PhpLlm\McpSdk\Capability\Resource\ResourceReaderInterface;
use PhpLlm\McpSdk\Capability\Resource\ResourceReadResult;

class ExampleResource implements MetadataInterface, ResourceReaderInterface
{
    public function read(ResourceRead $input): ResourceReadResult
    {
        return new ResourceReadResult(
            'Content of '.$this->getName(),
            $this->getUri(),
        );
    }

    public function getUri(): string
    {
        return 'file:///project/src/main.rs';
    }

    public function getName(): string
    {
        return 'My resource';
    }

    public function getDescription(): ?string
    {
        return 'This is just an example';
    }

    public function getMimeType(): ?string
    {
        return null;
    }

    public function getSize(): ?int
    {
        return null;
    }
}
