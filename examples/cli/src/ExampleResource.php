<?php

namespace App;

use PhpLlm\McpSdk\Capability\Resource\MetadataInterface;

class ExampleResource implements MetadataInterface
{
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
