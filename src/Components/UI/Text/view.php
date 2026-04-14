<?php

$text = isset($text) ? (string) $text : '';
$tag = isset($tag) ? (string) $tag : 'p';
$attributes = isset($attributes) && is_array($attributes) ? $attributes : [];

$attrParts = [];
foreach ($attributes as $key => $value) {
    if ($value === null || $value === '') {
        continue;
    }

    if (is_bool($value)) {
        if ($value) {
            $attrParts[] = htmlspecialchars((string) $key, ENT_QUOTES, 'UTF-8');
        }
        continue;
    }

    $attrParts[] = htmlspecialchars((string) $key, ENT_QUOTES, 'UTF-8') . '="' . htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') . '"';
}

echo '<' . htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') . ' ' . implode(' ', $attrParts) . '>';
echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
echo '</' . htmlspecialchars($tag, ENT_QUOTES, 'UTF-8') . '>';
