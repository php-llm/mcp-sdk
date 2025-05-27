<?php

namespace PhpLlm\McpSdk\Capability\Resource;

use PhpLlm\McpSdk\Exception\ResourceNotFoundException;
use PhpLlm\McpSdk\Exception\ResourceReadException;

interface ResourceReaderInterface
{
    /**
     * @throws ResourceReadException     if the resource execution fails
     * @throws ResourceNotFoundException if the resource is not found
     */
    public function read(ResourceRead $input): ResourceReadResult;
}
