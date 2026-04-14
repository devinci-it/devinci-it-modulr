<?php
$sections = $sections ?? [];
$ariaLabel = isset($ariaLabel) ? (string) $ariaLabel : 'Navigation';
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

$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-nav-list');
?>

<nav<?= $renderAttributes($attributes) ?> aria-label="<?= htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8') ?>">
    <?php foreach ($sections as $section): ?>
        <?php
        $sectionLabel = isset($section['label']) && is_string($section['label']) ? trim($section['label']) : '';
        $items = isset($section['items']) && is_array($section['items']) ? $section['items'] : [];
        ?>

        <div class="modulr-nav-list__section">
            <?php if ($sectionLabel !== ''): ?>
                <h3 class="modulr-nav-list__section-label"><?= htmlspecialchars($sectionLabel, ENT_QUOTES, 'UTF-8') ?></h3>
            <?php endif; ?>

            <ul class="modulr-nav-list__list">
                <?php foreach ($items as $item): ?>
                    <?php
                    $label = isset($item['label']) ? (string) $item['label'] : '';
                    $href = isset($item['href']) ? (string) $item['href'] : '#';
                    $icon = isset($item['icon']) && is_string($item['icon']) ? $item['icon'] : null;
                    $badge = isset($item['badge']) && is_string($item['badge']) ? $item['badge'] : null;
                    $disabled = (bool) ($item['disabled'] ?? false);
                    $current = (bool) ($item['current'] ?? false);
                    $target = isset($item['target']) && is_string($item['target']) ? $item['target'] : null;
                    $rel = isset($item['rel']) && is_string($item['rel']) ? $item['rel'] : null;
                    $itemAttributes = isset($item['attributes']) && is_array($item['attributes']) ? $item['attributes'] : [];

                    $itemClasses = 'modulr-nav-list__item';
                    if ($current) {
                        $itemClasses .= ' is-current';
                    }
                    if ($disabled) {
                        $itemClasses .= ' is-disabled';
                    }

                    $itemAttributes['class'] = trim(($itemAttributes['class'] ?? '') . ' ' . $itemClasses);
                    ?>

                    <li class="modulr-nav-list__list-item">
                        <?php if (!$disabled): ?>
                            <?php
                            $itemAttributes['href'] = $href;
                            if ($current) {
                                $itemAttributes['aria-current'] = 'page';
                            }
                            if ($target !== null) {
                                $itemAttributes['target'] = $target;
                            }
                            if ($rel !== null) {
                                $itemAttributes['rel'] = $rel;
                            }
                            ?>
                            <a<?= $renderAttributes($itemAttributes) ?>>
                                <?php if ($icon !== null && $icon !== ''): ?>
                                    <span class="modulr-nav-list__icon" aria-hidden="true"><?= $renderValue($icon, $allowHtml) ?></span>
                                <?php endif; ?>

                                <span class="modulr-nav-list__label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>

                                <?php if ($badge !== null && trim($badge) !== ''): ?>
                                    <span class="modulr-nav-list__badge"><?= htmlspecialchars($badge, ENT_QUOTES, 'UTF-8') ?></span>
                                <?php endif; ?>
                            </a>
                        <?php else: ?>
                            <?php $itemAttributes['aria-disabled'] = 'true'; ?>
                            <span<?= $renderAttributes($itemAttributes) ?>>
                                <?php if ($icon !== null && $icon !== ''): ?>
                                    <span class="modulr-nav-list__icon" aria-hidden="true"><?= $renderValue($icon, $allowHtml) ?></span>
                                <?php endif; ?>

                                <span class="modulr-nav-list__label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>

                                <?php if ($badge !== null && trim($badge) !== ''): ?>
                                    <span class="modulr-nav-list__badge"><?= htmlspecialchars($badge, ENT_QUOTES, 'UTF-8') ?></span>
                                <?php endif; ?>
                            </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</nav>