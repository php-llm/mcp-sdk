<?php

namespace App\Manager;

use App\ExamplePrompt;
use PhpLlm\McpSdk\Capability\Prompt\CollectionInterface;
use PhpLlm\McpSdk\Capability\Prompt\PromptGet;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetResult;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetResultMessages;
use PhpLlm\McpSdk\Capability\Prompt\PromptGetterInterface;
use PhpLlm\McpSdk\Exception\PromptGetException;
use PhpLlm\McpSdk\Exception\PromptNotFoundException;

class PromptManager implements PromptGetterInterface, CollectionInterface
{
    /**
     * @var mixed[]
     */
    private array $items;

    public function __construct(
    ) {
        $this->items = [
            new ExamplePrompt(),
        ];
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
                    return new PromptGetResult(
                        $item->getDescription(),
                        [new PromptGetResultMessages(
                            'user',
                            $item->__invoke(...$request->arguments),
                        )]
                    );
                } catch (\Throwable $e) {
                    throw new PromptGetException($request, $e);
                }
            }
        }

        throw new PromptNotFoundException($request);
    }
}
