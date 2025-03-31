# Model Context Protocol PHP SDK [WIP]

Model Context Protocol SDK for Client and Server applications in PHP.
**Currently only support Tool Calls as Server via Server-Sent Events (SSE) and STDIO.**

See [Demo App](https://github.com/php-llm/mcp-demo) for a working example and [MCP Bundle](https://github.com/php-llm/mcp-bundle) for Symfony integration.

## Installation

```bash
composer require php-llm/mcp-sdk
```

## Usage with Symfony

Server integration points for are tailored to Symfony Console and HttpFoundation (Laravel compatible).

### Console Command for STDIO Server

```php
namespace App\Command;

use PhpLlm\McpSdk\Server;
use PhpLlm\McpSdk\Server\Transport\Stdio\SymfonyConsoleTransport;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('mcp', 'Starts an MCP server')]
final class McpCommand extends Command
{
    public function __construct(
        private readonly Server $server,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->server->connect(
            new SymfonyConsoleTransport($input, $output)
        );

        return Command::SUCCESS;
    }
}
```

### Controller for Server-Sent Events Server

```php
namespace App\Controller;

use PhpLlm\McpSdk\Server;
use PhpLlm\McpSdk\Server\Transport\Sse\Store\CachePoolStore;
use PhpLlm\McpSdk\Server\Transport\Sse\StreamTransport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;

#[AsController]
#[Route('/mcp', name: 'mcp_')]
final readonly class McpController
{
    public function __construct(
        private Server $server,
        private CachePoolStore $store,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    #[Route('/sse', name: 'sse', methods: ['GET'])]
    public function sse(): StreamedResponse
    {
        $id = Uuid::v4();
        $endpoint = $this->urlGenerator->generate('mcp_messages', ['id' => $id], UrlGeneratorInterface::ABSOLUTE_URL);
        $transport = new StreamTransport($endpoint, $this->store, $id);

        return new StreamedResponse(fn() => $this->server->connect($transport), headers: [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    #[Route('/messages/{id}', name: 'messages', methods: ['POST'])]
    public function messages(Request $request, Uuid $id): Response
    {
        $this->store->push($id, $request->getContent());

        return new Response();
    }
}
```

### Exposing Tools

Under the hood the SDK uses [LLM Chain](https://github.com/php-llm/llm-chain)'s `ToolBox` to register, analyze and
execute tools. In combination with its [Symfony Bundle](https://github.com/php-llm/llm-chain-bundle) you can expose
tools with `#[AsTool]` attribute.

```php
use PhpLlm\LlmChain\ToolBox\Attribute\AsTool;

#[AsTool('company_name', 'Provides the name of your company')]
final class CompanyName
{
    public function __invoke(): string
    {
        return 'ACME Corp.'
    }
}
```
See [LLM Chain Documentation](https://github.com/php-llm/llm-chain?tab=readme-ov-file#tools) for more information.
