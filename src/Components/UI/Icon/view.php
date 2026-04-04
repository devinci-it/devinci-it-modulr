<?php

$classes = [
    'modulr-icon',
    'modulr-icon--' . htmlspecialchars($size),
];

$style = '';

if (!empty($color)) {
    $style = ' style="color:' . htmlspecialchars($color) . '"';
}

/**
 * Accessibility
 */
$attrs = '';

if ($decorative) {
    $attrs .= ' aria-hidden="true"';
} else {
    $attrs .= ' role="img"';

    if (!empty($label)) {
        $attrs .= ' aria-label="' . htmlspecialchars($label) . '"';
    }
}

/**
 * Resolve SVG
 */
$content = $svg;

if (!$content && $name) {
    // Future: map icon names → SVG registry
    $content = '<span class="modulr-icon__placeholder">' . htmlspecialchars($name) . '</span>';
}

echo '<span class="' . implode(' ', $classes) . '"' . $style . $attrs . '>';
echo $content;
echo '</span>';