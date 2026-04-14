<?php
$tabs = $tabs ?? [];
$ariaLabel = isset($ariaLabel) ? (string) $ariaLabel : 'Sections';
$allowHtml = (bool) ($allowHtml ?? false);
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

$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-underline-nav');
?>

<nav<?= $renderAttributes($attributes) ?> aria-label="<?= htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8') ?>">
    <ul class="modulr-underline-nav__list" role="list">
        <?php foreach ($tabs as $tab): ?>
            <?php
            $label = isset($tab['label']) ? (string) $tab['label'] : '';
            $href = isset($tab['href']) ? (string) $tab['href'] : '#';
            $current = (bool) ($tab['current'] ?? false);
            $disabled = (bool) ($tab['disabled'] ?? false);
            $target = isset($tab['target']) && is_string($tab['target']) ? trim($tab['target']) : '';
            $rel = isset($tab['rel']) && is_string($tab['rel']) ? trim($tab['rel']) : '';
            $tabAttributes = isset($tab['attributes']) && is_array($tab['attributes']) ? $tab['attributes'] : [];

            $linkClass = 'modulr-underline-nav__link';
            if ($current) {
                $linkClass .= ' is-current';
            }
            if ($disabled) {
                $linkClass .= ' is-disabled';
            }

            $tabAttributes['class'] = trim(($tabAttributes['class'] ?? '') . ' ' . $linkClass);
            $tabAttributes['href'] = $href;

            if ($current) {
                $tabAttributes['aria-current'] = 'page';
            }

            if ($target !== '') {
                $tabAttributes['target'] = $target;
            }

            if ($rel !== '') {
                $tabAttributes['rel'] = $rel;
            }

            if ($disabled) {
                $tabAttributes['tabindex'] = '-1';
                $tabAttributes['aria-disabled'] = 'true';
            }
            ?>
            <li class="modulr-underline-nav__item">
                <a<?= $renderAttributes($tabAttributes) ?>><?= $renderValue($label, $allowHtml) ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
