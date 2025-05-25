<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Tests\Message;

use PhpLlm\McpSdk\Message\Response;
use PHPUnit\Framework\TestCase;

final class ResponseTest extends TestCase
{
    public function testWithIntegerId(): void
    {
        $response = new Response(1, ['foo' => 'bar']);
        $expected = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'result' => ['foo' => 'bar'],
        ];

        self::assertSame($expected, $response->jsonSerialize());
    }

    public function testWithStringId(): void
    {
        $response = new Response('abc', ['foo' => 'bar']);
        $expected = [
            'jsonrpc' => '2.0',
            'id' => 'abc',
            'result' => ['foo' => 'bar'],
        ];

        self::assertSame($expected, $response->jsonSerialize());
    }
}
