<?php

namespace DevinciIT\Modulr\Components;

use DevinciIT\Modulr\Constants;
use DevinciIT\Modulr\Assets\AssetManager;
abstract class ComponentsBase
{
    protected ?string $cssFile = null;
    protected ?string $jsFile = null;

    protected array $inlineCss = [];
    protected array $inlineJs = [];

    protected bool $useDefaultAssets = true;
    protected bool $allowInlineAssets = true;
    protected bool $allowExternalAssets = true;

    /**
     * Render component (NO layout here)
     */
    protected function renderComponentView(array $vars = [], ?string $dir = null): string
    {
        $dir = $dir ?? $this->getComponentDir();
        $viewFile = $dir . '/' . Constants::DEFAULT_VIEW;

        // 🔥 ALWAYS register assets
        $this->registerAssets();

        extract($vars);

        ob_start();
        include $viewFile;

        return ob_get_clean();
    }

    /**
     * 🔥 Register assets EVERY render
     * (dedupe handled by AssetManager)
     */

    protected function registerAssets(): void
{
    $am = app(AssetManager::class); // ✅ shared singleton

    $assets = $this->resolveAssets();
        $am = app(AssetManager::class);

    // echo "Registering assets for: " . static::class . "<br>";
    // Debug what assets are being registered
    // echo "Resolved assets: " . print_r($assets, true) . "<br>";

    if ($assets['css']) {
        $am->registerStyle($this->assetHandle('css'), $assets['css']);
    }

    if ($assets['js']) {
        $am->registerScript($this->assetHandle('js'), $assets['js']);
    }

    if ($this->allowInlineAssets) {
        foreach ($assets['css_inline'] as $css) {
            $am->addInlineStyle($css);
        }

        foreach ($assets['js_inline'] as $js) {
            $am->addInlineScript($js);
        }
    }
}

    /**
     * Resolve assets
     */
    protected function resolveAssets(): array
    {
        $defaults = $this->getDefaultAssets();

        $css = null;
        $js = null;

        if ($this->allowExternalAssets) {
            $css = $this->useDefaultAssets
                ? ($this->cssFile ?? $defaults['css'])
                : $this->cssFile;

            $js = $this->useDefaultAssets
                ? ($this->jsFile ?? $defaults['js'])
                : $this->jsFile;
        }

        return [
            'css' => $css,
            'js'  => $js,
            'css_inline' => $this->inlineCss,
            'js_inline'  => $this->inlineJs,
        ];
    }

    protected function assetHandle(string $type): string
    {
        return static::class . ':' . $type;
    }

    protected function getDefaultAssets(): array
    {
        $ref = new \ReflectionClass($this);
        $ns = $ref->getNamespaceName();

        $parts = explode('Components\\', $ns, 2);
        $componentPath = isset($parts[1]) ? str_replace('\\', '/', $parts[1]) : '';

        $base = Constants::ASSET_BASE . $componentPath;
        // DEBUG: Show how default asset paths are resolved
        // echo "Resolving default assets for " . static::class . "<br>";
        // echo "Component namespace: " . $ns . "<br>";
        // echo "Component path: " . $componentPath . "<br>";
        // echo "Resolved CSS path: " . $base . '/' . Constants::DEFAULT_CSS . "<br>";
        // echo "Resolved JS path: " . $base . '/' . Constants::DEFAULT_JS . "<br>";
        
        return [
            'css' => $base . '/' . Constants::DEFAULT_CSS,
            'js'  => $base . '/' . Constants::DEFAULT_JS,
        ];
    }

    protected function getComponentDir(): string
    {
        $ref = new \ReflectionClass($this);
        return dirname($ref->getFileName());
    }

    /* ========================
     * Public API
     * ======================== */

    public function setCssFile(string $path): static
    {
        $this->cssFile = $path;
        return $this;
    }

    public function setJsFile(string $path): static
    {
        $this->jsFile = $path;
        return $this;
    }

    public function addCss(string $css): static
    {
        $this->inlineCss[] = $css;
        return $this;
    }

    public function addJs(string $js): static
    {
        $this->inlineJs[] = $js;
        return $this;
    }

    public function useDefaultAssets(bool $state = true): static
    {
        $this->useDefaultAssets = $state;
        return $this;
    }

    public function allowInline(bool $state = true): static
    {
        $this->allowInlineAssets = $state;
        return $this;
    }

    public function allowExternal(bool $state = true): static
    {
        $this->allowExternalAssets = $state;
        return $this;
    }

    public function disableAssets(): static
    {
        $this->useDefaultAssets = false;
        $this->allowInlineAssets = false;
        $this->allowExternalAssets = false;
        return $this;
    }
}