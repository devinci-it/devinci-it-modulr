<?php

namespace DevinciIT\Modulr\CLI\Dev;

use DevinciIT\Modulr\CLI\Dev\Handlers\MakeComponentHandler;
use DevinciIT\Modulr\CLI\Dev\Handlers\ServeDemoHandler;
use DevinciIT\Modulr\CLI\Dev\Handlers\DevPublishAssetsHandler;


class DevCommand
{
    public function handle(array $argv): void
    {
        $command = $argv[1] ?? null;

        if (!$command) {
            $this->usage();
            return;
        }

        switch ($command) {
            case 'make:component':
                (new MakeComponentHandler())->handle($argv);
                break;
            case 'serve:demo':
                (new ServeDemoHandler())->handle($argv);
                break;
            case 'dev:publish-assets':
                (new DevPublishAssetsHandler())->handle($argv);
                break;
            default:
                echo "Unknown command: $command\n";
                $this->usage();
                break;
        }
    }

    protected function usage(): void
    {
        echo <<<TEXT
Modulr Dev CLI

Commands:
  make:component {Category} {Name}
  serve:demo [host] [port]
  dev:publish-assets

Example:
  php modulr make:component DataDisplay Token
  php modulr serve:demo localhost 8000
  php modulr dev:publish-assets

TEXT;
    }
}