<?php

namespace DevinciIT\Modulr\Assets;

class AssetRenderer
{
    public static function renderStyles(array $paths, array $inline = []): string
    {
        $html = "<!-- Modulr Styles -->\n";

        foreach (array_unique($paths) as $path) {
            $html .= '<link rel="stylesheet" href="' . htmlspecialchars($path, ENT_QUOTES) . '">' . "\n";
        }

        if (!empty($inline)) {
            $html .= "<style>\n" . implode("\n", $inline) . "\n</style>\n";
        }

        return $html;
    }

    public static function renderScripts(array $paths, array $inline = []): string
    {
        $html = "<!-- Modulr Scripts -->\n";

        foreach (array_unique($paths) as $path) {
            $html .= '<script src="' . htmlspecialchars($path, ENT_QUOTES) . '"></script>' . "\n";
        }

        if (!empty($inline)) {
            $html .= "<script>\n" . implode("\n", $inline) . "\n</script>\n";
        }

        return $html;
    }
}