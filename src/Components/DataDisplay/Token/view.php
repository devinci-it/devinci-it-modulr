<?php

/**
 * TOKEN GROUP
 */
if (isset($tokens)) {
    $count = count($tokens);
    $visible = array_slice($tokens, 0, $maxVisible);
    $hidden = array_slice($tokens, $maxVisible);
    $hiddenCount = count($hidden);

    echo '<span class="modulr-token-group" role="list" data-modulr-token-group>';

    // Visible tokens
    foreach ($visible as $token) {
        echo '<span role="listitem">' . $token->render() . '</span>';
    }

    // Hidden tokens (rendered but hidden)
    if ($hiddenCount > 0) {


        $label = sprintf($counterLabel, $hiddenCount);
             echo '<div class="modulr-token-group__hidden" hidden>';

        foreach ($hidden as $token) {
            echo '<span role="listitem">' . $token->render() . '</span>';
        }

        echo '</div>';
        echo '<button type="button"
            class="modulr-token-group__counter"
            data-modulr-token-toggle
            aria-label="' . htmlspecialchars($label) . '">
            +' . $hiddenCount . '
        </button>';

   
    }

    echo '</span>';
    return;
}

/**
 * SINGLE TOKEN
 */

$classes = ['modulr-token', 'modulr-token--' . htmlspecialchars($size ?? 'md')];

if (!empty($removable)) {
    $classes[] = 'modulr-token--removable';
}

$attributes = $attributes ?? [];

if (!empty($attributes['class'])) {
    $classes = array_merge($classes, preg_split('/\s+/', trim((string) $attributes['class'])) ?: []);
    unset($attributes['class']);
}

$attr = ' class="' . implode(' ', $classes) . '"';

foreach ($attributes as $k => $v) {
    $attr .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '"';
}

echo '<span' . $attr . '>';

if (!empty($leadingVisual)) {
    echo '<span class="modulr-token__visual">' . $leadingVisual . '</span>';
}

$labelHtml = htmlspecialchars($label);

if (!empty($href)) {
    echo '<a href="' . htmlspecialchars($href) . '" class="modulr-token__label">' . $labelHtml . '</a>';
} else {
    echo '<span class="modulr-token__label">' . $labelHtml . '</span>';
}

if (!empty($removable)) {
    echo '<button type="button"
        class="modulr-token__remove"
        aria-label="' . htmlspecialchars($removeLabel ?? 'Remove token') . '">
        &times;
    </button>';
}

echo '</span>';