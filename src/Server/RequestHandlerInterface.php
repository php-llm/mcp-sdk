<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server;

use PhpLlm\McpSdk\Message\Error;
use PhpLlm\McpSdk\Message\Request;
use PhpLlm\McpSdk\Message\Response;

interface RequestHandlerInterface
{
    public function supports(Request $message): bool;

    public function createResponse(Request $message): Response|Error;
}
