<?php

namespace DevinciIT\Modulr\Assets;

use DevinciIT\Modulr\Constants;

/**
 * AssetManager
 *
 * Pure state container for registered assets.
 */
class AssetManager
{
    protected array $styles = [];
    protected array $scripts = [];

    // Fast lookup to prevent duplicates (internal use only)
    protected array $styleLookup = [];
    protected array $scriptLookup = [];

    protected array $inlineStyles = [];
    protected array $inlineScripts = [];

    protected string $baseDir;

    public function __construct(string $baseDir = null)
    {
        $this->baseDir = rtrim(
            $baseDir ?? Constants::ASSET_BASE,
            '/'
        );
    }

    /* -----------------------
     * Registration
     * ----------------------- */

    public function registerStyle(string $handle, string $path): void
    {
        $path = $this->normalizePath($path);

        // Prevent duplicate paths (global dedupe)
        if (isset($this->styleLookup[$path])) {
            return;
        }

        $this->styles[$handle] = $path;
        $this->styleLookup[$path] = true;
    }

    public function registerScript(string $handle, string $path): void
    {
        $path = $this->normalizePath($path);

        // Prevent duplicate paths (global dedupe)
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

    public function addInlineScript(string $js): void
    {
        $this->inlineScripts[] = $js;
    }

    /* -----------------------
     * Getters
     * ----------------------- */

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

    /* -----------------------
     * Helpers
     * ----------------------- */

    protected function normalizePath(string $path): string
    {
        return rtrim($path, '/');
    }
}