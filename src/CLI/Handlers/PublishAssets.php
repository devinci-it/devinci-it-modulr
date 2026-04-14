<?php

namespace DevinciIT\Modulr\CLI\Handlers;

class PublishAssets
{
    private function color(string $text, string $color): string
    {
        $colors = [
            'reset' => "\033[0m",
            'red' => "\033[31m",
            'green' => "\033[32m",
            'yellow' => "\033[33m",
            'cyan' => "\033[36m",
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

        $force   = in_array('--force', $argv, true);
        $clean   = in_array('--clean', $argv, true);
        $dev     = in_array('--dev', $argv, true);
        $restore = in_array('--restore', $argv, true);

        $backupDir = $dest . '/.backup';

        // RESTORE MODE
        if ($restore) {
            $this->restore($backupDir, $dest);
            return;
        }

        // CLEAN MODE
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
            if (!in_array($file->getExtension(), ['css', 'js'])) {
                continue;
            }

            $relPath = substr($file->getPathname(), strlen($src) + 1);
            $target  = $dest . '/' . $relPath;

            if (!is_dir(dirname($target))) {
                mkdir(dirname($target), 0777, true);
            }

            // If file exists → backup before overwrite
            if (file_exists($target) || is_link($target)) {
                if (!$force) {
                    $this->warn("Warning: $relPath exists. Use --force to overwrite.");
                    continue;
                }

                $this->backupFile($target, $backupDir, $dest);
                unlink($target);
            }

            if ($dev) {
                // SYMLINK
                symlink($file->getPathname(), $target);
                $this->success("Linked: $relPath");
            } else {
                // COPY
                copy($file->getPathname(), $target);
                $this->success("Copied: $relPath");
            }
        }

        $this->info("Assets published.");
    }

    private function backupFile(string $target, string $backupDir, string $srcRoot): void
    {
        if (!file_exists($target)) {
            return;
        }

        $relPath = substr($target, strlen($srcRoot) + 1);
        $backupPath = $backupDir . '/' . $relPath;

        if (!is_dir(dirname($backupPath))) {
            mkdir(dirname($backupPath), 0777, true);
        }

        copy($target, $backupPath);

        $this->info("Backed up: $relPath");
    }

    private function restore(string $backupDir, string $dest): void
    {
        if (!is_dir($backupDir)) {
            $this->error("No backup directory found.");
            return;
        }

        $this->info("Restoring from backup...");

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($backupDir, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            $relPath = substr($file->getPathname(), strlen($backupDir) + 1);
            $target = $dest . '/' . $relPath;

            if (!is_dir(dirname($target))) {
                mkdir(dirname($target), 0777, true);
            }

            copy($file->getPathname(), $target);

            $this->success("Restored: $relPath");
        }

        $this->info("Restore complete.");
    }

    private function rrmdir($dir): void
    {
        if (!is_dir($dir)) return;

        foreach (scandir($dir) as $item) {
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