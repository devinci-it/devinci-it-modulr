<?php
namespace DevinciIT\Modulr\CLI\Dev\Handlers;

class ServeDemoHandler
{
    public function handle(array $argv): void
    {
        $host = $argv[2] ?? 'localhost';
        $port = $argv[3] ?? '9999';
        $docroot = realpath(__DIR__ . '/../../../../demo');
        if (!is_dir($docroot)) {
            echo "Demo directory not found: $docroot\n";
            return;
        }
        echo "Serving demo at http://$host:$port ...\n";
        passthru("php -S $host:$port -t $docroot");
    }
}
