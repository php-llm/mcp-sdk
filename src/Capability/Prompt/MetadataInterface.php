<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Prompt;

interface MetadataInterface extends IdentifierInterface
{
    public function getDescription(): ?string;

    /**
     * @return list<array{
     *   name: string,
     *   description?: string,
     *   required?: bool,
     * }>
     */
    public function getArguments(): array;
}
