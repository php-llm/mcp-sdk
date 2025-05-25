<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Tool;

interface MetadataInterface extends IdentifierInterface
{
    public function getDescription(): string;

    /**
     * @return array{
     *   type?: string,
     *   required?: list<string>,
     *   properties?: array<string, array{
     *       type: string,
     *       description?: string,
     *   }>,
     * }
     */
    public function getInputSchema(): array;
}
