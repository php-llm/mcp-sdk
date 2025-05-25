<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Capability\Tool;

interface MetadataInterface
{
    public function getName(): string;

    public function getDescription(): string;

    public function getInputSchema(): array;
}
