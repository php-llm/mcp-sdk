<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Output\OutputInterface;

$debug = (bool) ($_SERVER['DEBUG'] ?? false);

// Setup input, output and logger
$input = new Symfony\Component\Console\Input\ArgvInput($argv);
$output = new Symfony\Component\Console\Output\ConsoleOutput($debug ? OutputInterface::VERBOSITY_VERY_VERBOSE : OutputInterface::VERBOSITY_NORMAL);
$logger = new Symfony\Component\Console\Logger\ConsoleLogger($output);

// Configure the JsonRpcHandler
$jsonRpcHandler = new PhpLlm\McpSdk\Server\JsonRpcHandler(
    new PhpLlm\McpSdk\Message\Factory(),
    App\Builder::buildRequestHandlers(),
    App\Builder::buildNotificationHandlers(),
    $logger
);

// Set up the server
$sever = new PhpLlm\McpSdk\Server($jsonRpcHandler, $logger);

// Create the transport layer using Symfony Console
$transport = new PhpLlm\McpSdk\Server\Transport\Stdio\SymfonyConsoleTransport($input, $output);

// Start our application
$sever->connect($transport);
