# Example app with CLI

This is just for testing and debugging purposes.


Install and create symlink with:

```bash
cd /path/to/your/project/examples/cli
composer update
rm -rf vendor/php-llm/mcp-sdk/src
ln -s /path/to/your/project/src /path/to/your/project/examples/cli/vendor/php-llm/mcp-sdk/src
```

Run the CLI with:

```bash
DEBUG=1 php index.php
```

You will see debug outputs to help you understand what is happening.

In this terminal you can now test add some json strings. See `example-requests.json`.

Run with Inspector:

```bash
npx @modelcontextprotocol/inspector php index.php
```
