<?php
namespace DevinciIT\Modulr\CLI\Dev\Handlers;

class DevPublishAssetsHandler
{
    private function color(string $text, string $color): string
    {
        $colors = [
            'reset' => "\033[0m",
            'red' => "\033[31m",
            'green' => "\033[32m",
            'yellow' => "\033[33m",
            'blue' => "\033[34m",
            'magenta' => "\033[35m",
            'cyan' => "\033[36m",
            'gray' => "\033[90m",
        ];
        return ($colors[$color] ?? '') . $text . $colors['reset'];
    }

    private function info($msg) { echo $this->color($msg, 'cyan') . "\n"; }
    private function success($msg) { echo $this->color($msg, 'green') . "\n"; }
    private function warn($msg) { echo $this->color($msg, 'yellow') . "\n"; }
    private function error($msg) { echo $this->color($msg, 'red') . "\n"; }

    public function handle(array $argv): void
    {
        $src = realpath(__DIR__ . '/../../../../src/Components');
        $dest = realpath(__DIR__ . '/../../../../demo/vendor/modulr');
        if (!$src || !$dest) {
            $this->error("Source or destination directory not found.");
            return;
        }

        $force = in_array('--force', $argv, true);
        $clean = in_array('--clean', $argv, true);

        if ($clean) {
            $this->warn("Cleaning $dest ...");
            $this->rrmdir($dest);
            mkdir($dest, 0777, true);
        }

        $this->info("Publishing assets from $src to $dest ...");

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($src, \FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if (in_array($file->getExtension(), ['css', 'js'])) {
                $relPath = substr($file->getPathname(), strlen($src) + 1);
                $target = $dest . '/' . $relPath;
                if (!is_dir(dirname($target))) {
                    mkdir(dirname($target), 0777, true);
                }
                if (file_exists($target)) {
                    if ($force) {
                        copy($file->getPathname(), $target);
                        $this->success("Overwritten: $relPath");
                    } else {
                        $this->warn("Warning: $relPath exists. Use --force to overwrite.");
                        continue;
                    }
                } else {
                    copy($file->getPathname(), $target);
                    $this->success("Copied: $relPath");
                }
            }
        }
        $this->info("Assets published.");
    }

    private function rrmdir($dir): void
    {
        if (!is_dir($dir)) return;
        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->rrmdir($path);
            } else {
                unlink($path);
            }
        }
        rmdir($dir);
    }
}
