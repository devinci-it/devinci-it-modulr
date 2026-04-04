<?php

namespace DevinciIT\Modulr\Layouts;

use DevinciIT\Modulr\Assets\AssetManager;
use DevinciIT\Modulr\Assets\AssetRenderer;

class LayoutBase
{
    public function render(string $content, AssetManager $assets, array $options = []): string
    {
        $styles = AssetRenderer::renderStyles(
            $assets->getStylePaths(),
            $assets->getInlineStyles()
        );

        $scripts = AssetRenderer::renderScripts(
            $assets->getScriptPaths(),
            $assets->getInlineScripts()
        );

        $foucStyle = $this->foucStyle($options);
        $foucScript = $this->foucScript($options);

        $head = $this->renderHead($options, $foucStyle . $styles);
        $body = $this->renderBody($content, $options, $scripts . $foucScript);

        return $this->buildHtml($head, $body);
    }

    /* ========================
     * FOUC
     * ======================== */

    protected function foucStyle(array $options): string
    {
        if (!($options['fouc_protection'] ?? true)) {
            return '';
        }

        return '<style id="modulr-fouc-style">body{opacity:0;}</style>';
    }

    protected function foucScript(array $options): string
    {
        if (!($options['fouc_protection'] ?? true)) {
            return '';
        }

        return '<script>
        window.addEventListener("load", function () {
            const s = document.getElementById("modulr-fouc-style");
            if (s) s.remove();
            document.body.style.opacity = "";
        });
        </script>';
    }

    /* ========================
     * Structure
     * ======================== */

    protected function renderHead(array $options, string $styles): string
    {
        $title = htmlspecialchars($options['title'] ?? 'Component', ENT_QUOTES);
        $extra = $options['head'] ?? '';

        return <<<HTML
<meta charset="UTF-8">
<title>{$title}</title>

{$extra}
{$styles}
HTML;
    }

    protected function renderBody(string $content, array $options, string $scripts): string
    {
        $class = htmlspecialchars($options['body_class'] ?? '', ENT_QUOTES);

        return <<<HTML
<body class="{$class}">
<!-- {$this->wrapContainer($content, $options)} -->
 {$content}
{$scripts}
</body>
HTML;
    }

    protected function wrapContainer(string $content, array $options): string
    {
        $class = $options['container_class'] ?? 'modulr-container';

        return "<div class=\"{$class}\">{$content}</div>";
    }

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