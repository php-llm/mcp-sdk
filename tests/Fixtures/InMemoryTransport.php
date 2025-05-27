<?php

namespace PhpLlm\McpSdk\Tests\Fixtures;

use PhpLlm\McpSdk\Server\TransportInterface;

class InMemoryTransport implements TransportInterface
{
    private bool $connected = true;

    /**
     * @param list<string> $messages
     */
    public function __construct(
        private readonly array $messages = [],
    ) {
    }

    public function initialize(): void
    {
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function receive(): \Generator
    {
        yield from $this->messages;
        $this->connected = false;
    }

    public function send(string $data): void
    {
    }

    public function close(): void
    {
    }
}
