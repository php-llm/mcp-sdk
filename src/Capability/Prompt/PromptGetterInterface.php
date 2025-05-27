<?php

namespace PhpLlm\McpSdk\Capability\Prompt;

use PhpLlm\McpSdk\Exception\PromptGetException;
use PhpLlm\McpSdk\Exception\PromptNotFoundException;

interface PromptGetterInterface
{
    /**
     * @throws PromptGetException      if the prompt execution fails
     * @throws PromptNotFoundException if the prompt is not found
     */
    public function get(PromptGet $input): PromptGetResult;
}
