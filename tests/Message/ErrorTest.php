<?php

declare(strict_types=1);

namespace PhpLlm\McpSdk\Tests\Message;

use PhpLlm\McpSdk\Message\Error;
use PHPUnit\Framework\TestCase;

final class ErrorTest extends TestCase
{
    public function testWithIntegerId(): void
    {
        $error = new Error(1, -32602, 'Another error occurred');
        $expected = [
            'jsonrpc' => '2.0',
            'id' => 1,
            'error' => [
                'code' => -32602,
                'message' => 'Another error occurred',
            ],
        ];

        self::assertSame($expected, $error->jsonSerialize());
    }

    public function testWithStringId(): void
    {
        $error = new Error('abc', -32602, 'Another error occurred');
        $expected = [
            'jsonrpc' => '2.0',
            'id' => 'abc',
            'error' => [
                'code' => -32602,
                'message' => 'Another error occurred',
            ],
        ];

        self::assertSame($expected, $error->jsonSerialize());
    }
}
