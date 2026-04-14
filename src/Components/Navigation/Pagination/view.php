<?php
$items = $items ?? [];
$ariaLabel = isset($ariaLabel) ? (string) $ariaLabel : 'Pagination';
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

$renderClasses = static function (array $classes): string {
    $filtered = [];

    foreach ($classes as $className) {
        if (!is_string($className)) {
            continue;
        }

        $className = trim($className);
        if ($className === '') {
            continue;
        }

        $filtered[] = $className;
    }

    if ($filtered === []) {
        return '';
    }

    return implode(' ', array_values(array_unique($filtered)));
};

$existingClassNames = preg_split('/\s+/', (string) ($attributes['class'] ?? ''), -1, PREG_SPLIT_NO_EMPTY) ?: [];
$attributes['class'] = $renderClasses(array_merge($existingClassNames, ['modulr-pagination']));
?>

<nav<?= $renderAttributes($attributes) ?> aria-label="<?= htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8') ?>">
    <ol class="modulr-pagination__list">
        <?php foreach ($items as $item): ?>
            <?php
            $type = isset($item['type']) ? (string) $item['type'] : 'link';

            if ($type === 'ellipsis'):
            ?>
                <li class="modulr-pagination__item is-ellipsis" aria-hidden="true">...</li>
                <?php continue; ?>
            <?php endif; ?>

            <?php
            $label = isset($item['label']) ? (string) $item['label'] : '';
            $href = isset($item['href']) ? (string) $item['href'] : '#';
            $page = isset($item['page']) ? (int) $item['page'] : null;
            $current = (bool) ($item['current'] ?? false);
            $disabled = (bool) ($item['disabled'] ?? false);
            $kind = isset($item['kind']) ? (string) $item['kind'] : 'page';
            $kindClass = preg_replace('/[^a-z0-9_-]/i', '', $kind) ?? 'page';
            if ($kindClass === '') {
                $kindClass = 'page';
            }
            $target = isset($item['target']) && is_string($item['target']) ? trim($item['target']) : '';
            $rel = isset($item['rel']) && is_string($item['rel']) ? trim($item['rel']) : '';

            $itemClasses = $renderClasses([
                'modulr-pagination__item',
                $kindClass !== 'page' ? 'is-' . $kindClass : '',
            ]);

            $linkClasses = $renderClasses([
                'modulr-pagination__link',
                $current ? 'is-current' : '',
                $disabled ? 'is-disabled' : '',
                $kindClass !== 'page' ? 'is-' . $kindClass : '',
            ]);
            ?>

            <li class="<?= htmlspecialchars($itemClasses, ENT_QUOTES, 'UTF-8') ?>">
                <?php if ($disabled): ?>
                    <span class="<?= htmlspecialchars($linkClasses, ENT_QUOTES, 'UTF-8') ?>" aria-disabled="true"><?= $renderValue($label, $allowHtml) ?></span>
                <?php else: ?>
                    <a
                        class="<?= htmlspecialchars($linkClasses, ENT_QUOTES, 'UTF-8') ?>"
                        href="<?= htmlspecialchars($href, ENT_QUOTES, 'UTF-8') ?>"
                        <?= $page !== null ? 'data-page="' . htmlspecialchars((string) $page, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
                        <?= $current ? 'aria-current="page"' : '' ?>
                        <?= $target !== '' ? 'target="' . htmlspecialchars($target, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
                        <?= $rel !== '' ? 'rel="' . htmlspecialchars($rel, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
                    >
                        <?= $renderValue($label, $allowHtml) ?>
                    </a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>
</nav>
