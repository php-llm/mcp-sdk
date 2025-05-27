<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Server;

interface TransportInterface
{
    public function initialize(): void;

    public function isConnected(): bool;

    public function receive(): \Generator;

    public function send(string $data): void;

    public function close(): void;
}
