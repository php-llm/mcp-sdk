<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Resource;

interface MetadataInterface extends IdentifierInterface
{
    public function getName(): string;

    public function getDescription(): ?string;

    public function getMimeType(): ?string;

    /**
     * Size in bytes.
     */
    public function getSize(): ?int;
}
