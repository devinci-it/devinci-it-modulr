<?php

namespace DevinciIT\Modulr\Layouts;

use DevinciIT\Modulr\Assets\AssetManager;
use DevinciIT\Modulr\Assets\AssetRenderer;

class LayoutBase
{
    public function render(string $content, AssetManager $assets, array $options = []): string
    {
        [$styles, $scripts] = $this->renderAssets($assets);

        [$foucStyle, $foucScript] = $this->renderFouc($options);

        $head = $this->renderHead($options, $styles . $foucStyle);
        $body = $this->renderBody($content, $options, $scripts . $foucScript);

        return $this->buildHtml($head, $body);
    }

    /* ========================
     * Asset Handling
     * ======================== */

    protected function renderAssets(AssetManager $assets): array
    {
        $styles = AssetRenderer::renderStyles(
            $assets->getStylePaths(),
            $assets->getInlineStyles()
        );

        $scripts = AssetRenderer::renderScripts(
            $assets->getScriptPaths(),
            $assets->getInlineScripts()
        );

        return [$styles, $scripts];
    }

    /* ========================
     * FOUC Handling
     * ======================== */

    protected function renderFouc(array $options): array
    {
        if (!($options['fouc_protection'] ?? true)) {
            return ['', ''];
        }

        return [
            $this->foucStyle(),
            $this->foucScript()
        ];
    }

    protected function foucStyle(): string
    {
        return '<style id="modulr-fouc-style">body{opacity:0!important;transition:none!important;}</style>';
    }

    protected function foucScript(): string
    {
        return '<script>
        console.log("[Modulr] FOUC protection active: hiding content until fully loaded.");
        (function () {
            function show() {
                var s = document.getElementById("modulr-fouc-style");
                if (s) s.remove();
                document.body.style.opacity = "";
            }

            if (document.readyState === "complete") {
                show();
            } else if (window.addEventListener) {
                window.addEventListener("load", show);
            } else if (window.attachEvent) {
                window.attachEvent("onload", show);
            }
        })();
        </script>';
    }

    /* ========================
     * Structure Rendering
     * ======================== */

    protected function renderHead(array $options, string $styles): string
    {
        $title = htmlspecialchars($options['title'] ?? 'Component', ENT_QUOTES);
        $extraHead = $options['head'] ?? '';

        return <<<HTML
<meta charset="UTF-8">
<title>{$title}</title>


{$extraHead}
{$styles}
HTML;
    }

    protected function renderBody(string $content, array $options, string $scripts): string
    {
        $bodyClass = htmlspecialchars($options['body_class'] ?? '', ENT_QUOTES);
        $containerClass = $options['container_class'] ?? 'modulr-component-container';
        $containerHtml = $this->wrapContainer($content, $containerClass);

        return <<<HTML
<body class="{$bodyClass}">
{$containerHtml}
{$scripts}
</body>
HTML;
    }

    protected function wrapContainer(string $content, string $class): string
    {
        $container = new LayoutContainer();

        return $container->render($content, [
            'class' => $class
        ]);
    }

    /* ========================
     * Final HTML
     * ======================== */

    protected function buildHtml(string $head, string $body): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
{$head}
</head>
{$body}
</html>
HTML;
    }
}