<?php

$classes = [
    'modulr-divider',
    'modulr-divider--' . htmlspecialchars($orientation ?? 'horizontal'),
    'modulr-divider--' . htmlspecialchars($size ?? 'md'),
    'modulr-divider--' . htmlspecialchars($style ?? 'solid'),
    'modulr-divider--' . htmlspecialchars($color ?? 'default'),
];

$element = ($orientation ?? 'horizontal') === 'vertical' ? 'span' : 'div';

$classAttr = htmlspecialchars(implode(' ', $classes), ENT_QUOTES, 'UTF-8');

echo "<{$element} class=\"{$classAttr}\"></{$element}>";