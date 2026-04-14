<?php
$items = $items ?? [];
$ariaLabel = isset($ariaLabel) ? (string) $ariaLabel : 'Tree view';
$allowHtml = (bool) ($allowHtml ?? false);
$activationMode = isset($activationMode) ? (string) $activationMode : 'selection';
$activePath = isset($activePath) ? (string) $activePath : null;
$attributes = $attributes ?? [];

$renderAttributes = static function (array $attributes): string {
    $parts = [];

    foreach ($attributes as $key => $value) {
        if (!is_string($key) || $key === '' || !is_scalar($value)) {
            continue;
        }

        $parts[] = sprintf(
            '%s="%s"',
            htmlspecialchars($key, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8')
        );
    }

    return $parts ? ' ' . implode(' ', $parts) : '';
};

$renderValue = static function (?string $value, bool $allowHtml): string {
    if ($value === null) {
        return '';
    }

    return $allowHtml ? $value : htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};

$renderItems = static function (array $items, string $pathPrefix = '') use (&$renderItems, $renderAttributes, $renderValue, $allowHtml, $activationMode, $activePath): string {
    $html = '';

    foreach ($items as $index => $item) {
        $nodePath = $pathPrefix === '' ? (string) $index : $pathPrefix . '.' . $index;
        $label = (string) ($item['label'] ?? 'Item');
        $href = isset($item['href']) && is_string($item['href']) ? $item['href'] : null;
        $icon = isset($item['icon']) && is_string($item['icon']) ? $item['icon'] : null;
        $badge = isset($item['badge']) && is_string($item['badge']) ? $item['badge'] : null;
        $expanded = (bool) ($item['expanded'] ?? false);
        $children = isset($item['children']) && is_array($item['children']) ? $item['children'] : [];
        $attributes = isset($item['attributes']) && is_array($item['attributes']) ? $item['attributes'] : [];
        $isActive = $activePath !== null && $activePath === $nodePath;
        $hasChildren = $children !== [];

        $itemClasses = 'modulr-tree-view__item';
        if ($isActive) {
            $itemClasses .= ' is-active';
        }
        if ($expanded) {
            $itemClasses .= ' is-expanded is-open';
        }

        $attributes['class'] = trim(($attributes['class'] ?? '') . ' ' . $itemClasses);

        $html .= '<li' . $renderAttributes(array_merge($attributes, [
            'data-tree-item' => 'true',
        ])) . '>';
        $html .= '<div class="modulr-tree-view__row">';

        if ($hasChildren) {
            $toggleLabel = $expanded ? 'Collapse' : 'Expand';
            $html .= '<button type="button" class="modulr-tree-view__toggle" aria-expanded="' . ($expanded ? 'true' : 'false') . '" aria-label="' . htmlspecialchars($toggleLabel . ' ' . $label, ENT_QUOTES, 'UTF-8') . '" data-tree-toggle>';
            $html .= '<svg class="modulr-tree-view__chevron" viewBox="0 0 20 20" aria-hidden="true" focusable="false">';
            $html .= '<path d="M7 4.75 12.5 10 7 15.25" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" />';
            $html .= '</svg>';
            $html .= '</button>';
        } else {
            $html .= '<span class="modulr-tree-view__spacer" aria-hidden="true"></span>';
        }

        $contentClass = 'modulr-tree-view__content';
        if ($activationMode === 'navigation' && $href !== null && $href !== '') {
            $contentClass .= ' modulr-tree-view__content--link';
            $html .= '<a class="' . $contentClass . '" href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '"' . ($isActive ? ' aria-current="page"' : '') . '>';
        } else {
            $contentClass .= ' modulr-tree-view__content--button';
            $html .= '<button type="button" class="' . $contentClass . '"' . ($isActive ? ' data-active="true"' : '') . '>';
        }

        if ($icon !== null && $icon !== '') {
            $html .= '<span class="modulr-tree-view__icon" aria-hidden="true">' . $renderValue($icon, $allowHtml) . '</span>';
        }

        $html .= '<span class="modulr-tree-view__label">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</span>';

        if ($badge !== null && trim($badge) !== '') {
            $html .= '<span class="modulr-tree-view__badge">' . htmlspecialchars($badge, ENT_QUOTES, 'UTF-8') . '</span>';
        }

        $html .= $activationMode === 'navigation' && $href !== null && $href !== '' ? '</a>' : '</button>';
        $html .= '</div>';

        if ($hasChildren) {
            $html .= '<ul class="modulr-tree-view__children" data-tree-children style="height: ' . ($expanded ? 'auto' : '0px') . ';">';
            $html .= $renderItems($children, $nodePath);
            $html .= '</ul>';
        }

        $html .= '</li>';
    }

    return $html;
};

$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-tree-view');
?>

<nav<?= $renderAttributes($attributes) ?> aria-label="<?= htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8') ?>">
    <ul class="modulr-tree-view__root">
        <?= $renderItems($items) ?>
    </ul>
</nav>