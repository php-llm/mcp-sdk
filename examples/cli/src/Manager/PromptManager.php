<?php

namespace App\Manager;

use PhpLlm\McpSdk\Capability\Prompt\CollectionInterface;
use PhpLlm\McpSdk\Capability\Prompt\MetadataInterface;
use PhpLlm\McpSdk\Capability\Prompt\PromptGet;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetResult;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetterInterface;
use PhpLlm\McpSdk\Exception\PromptGetException;
use PhpLlm\McpSdk\Exception\PromptNotFoundException;

class PromptManager implements PromptGetterInterface, CollectionInterface
{
    public function __construct(
        /**
         * @var (MetadataInterface | callable(PromptGet):PromptGetResult)[]
         */
        private array $items,
    ) {
    }

    public function getMetadata(): array
    {
        return $this->items;
    }

    public function get(PromptGet $request): PromptGetResult
    {
        foreach ($this->items as $item) {
            if ($request->name === $item->getName()) {
                try {
                    return $item($request);
                } catch (\Throwable $e) {
                    throw new PromptGetException($request, $e);
                }
            }
        }

        throw new PromptNotFoundException($request);
    }
}
