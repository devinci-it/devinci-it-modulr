<?php

namespace DevinciIT\Modulr\Assets;

use DevinciIT\Modulr\Constants;

class AssetManager
{
    protected array $styles = [];
    protected array $scripts = [];

    protected array $styleLookup = [];
    protected array $scriptLookup = [];

    protected array $inlineStyles = [];
    protected array $inlineScripts = [];

    protected array $inlineStyleLookup = [];
    protected array $inlineScriptLookup = [];

    protected string $baseDir;

    public function __construct(?string $baseDir = null)
    {
        $this->baseDir = rtrim($baseDir ?? Constants::ASSET_BASE, '/');
    }

    /* ========================
     * Registration
     * ======================== */

    public function registerStyle(string $handle, string $path): void
    {
        $path = $this->resolvePath($path);

        if (isset($this->styleLookup[$path])) {
            return;
        }

        $this->styles[$handle] = $path;
        $this->styleLookup[$path] = true;
    }

    public function registerScript(string $handle, string $path): void
    {
        $path = $this->resolvePath($path);

        if (isset($this->scriptLookup[$path])) {
            return;
        }

        $this->scripts[$handle] = $path;
        $this->scriptLookup[$path] = true;
    }

    public function addInlineStyle(string $css): void
    {
        $this->inlineStyles[] = $css;
    }

    public function addInlineStyleOnce(string $key, string $css): void
    {
        if (isset($this->inlineStyleLookup[$key])) {
            return;
        }

        $this->inlineStyleLookup[$key] = true;
        $this->inlineStyles[] = $css;
    }

    public function addInlineScript(string $js): void
    {
        $this->inlineScripts[] = $js;
    }

    public function addInlineScriptOnce(string $key, string $js): void
    {
        if (isset($this->inlineScriptLookup[$key])) {
            return;
        }

        $this->inlineScriptLookup[$key] = true;
        $this->inlineScripts[] = $js;
    }

    /* ========================
     * Getters
     * ======================== */

    public function getStylePaths(): array
    {
        return array_values($this->styles);
    }

    public function getScriptPaths(): array
    {
        return array_values($this->scripts);
    }

    public function getInlineStyles(): array
    {
        return $this->inlineStyles;
    }

    public function getInlineScripts(): array
    {
        return $this->inlineScripts;
    }

    /* ========================
     * Helpers
     * ======================== */

  protected function resolvePath(string $path): string
{
    if (str_starts_with($path, 'http')) {
        return $path;
    }

    $base = rtrim($this->baseDir, '/');

    // If already contains baseDir, don't prepend again
    if (str_starts_with($path, $base)) {
        return $path;
    }

    return $base . '/' . ltrim($path, '/');
}

    public function debug(): array {
    return [
        'styles' => $this->styles,
        'scripts' => $this->scripts,
        'inlineStyles' => $this->inlineStyles,
        'inlineScripts' => $this->inlineScripts,
    ];
    }

    public function reset(): void
{
    $this->styles = [];
    $this->scripts = [];
    $this->inlineStyles = [];
    $this->inlineScripts = [];
    $this->styleLookup = [];
    $this->scriptLookup = [];
    $this->inlineStyleLookup = [];
    $this->inlineScriptLookup = [];
}
}