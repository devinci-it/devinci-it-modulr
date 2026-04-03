<?php
/**
 * AssetRenderer: Converts asset data to HTML.
 *
 * NOTE:
 * The styles and scripts rendered by this class are collected and injected by the
 * Modulr library (AssetManager + component system).
 *
 * These assets are not hardcoded in templates — they are dynamically registered
 * and passed into the rendering pipeline by Modulr.
 */

namespace DevinciIT\Modulr\Assets;

class AssetRenderer
{
    public static function renderStyles(array $stylePaths, array $inlineStyles = []): string
    {
        $html = '';
        $html .= "<!-- Assets injected by Modulr AssetRenderer -->\n";
        $uniquePaths = array_unique(array_filter($stylePaths, fn($p) => is_string($p) && trim($p) !== ''));
        foreach ($uniquePaths as $path) {
            $html .= '<link rel="stylesheet" href="' . htmlspecialchars($path) . '">' . "\n";
        }
        if (!empty($inlineStyles)) {
            $html .= "<style>\n" . implode("\n", $inlineStyles) . "\n</style>\n";
        }
        return $html;
    }

    public static function renderScripts(array $scriptPaths, array $inlineScripts = []): string
    {
        $html = '';
        $html .= "<!-- Assets injected by Modulr AssetRenderer -->\n";
        $uniquePaths = array_unique(array_filter($scriptPaths, fn($p) => is_string($p) && trim($p) !== ''));
        foreach ($uniquePaths as $path) {
            $html .= '<script src="' . htmlspecialchars($path) . '"></script>' . "\n";
        }
        if (!empty($inlineScripts)) {
            $html .= "<script>\n" . implode("\n", $inlineScripts) . "\n</script>\n";
        }
        return $html;
    }
}