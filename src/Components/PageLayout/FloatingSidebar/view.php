<?php
$attributes = $attributes ?? [];
$title = $title ?? null;
$slot = (string) ($slot ?? '');
$allowHtml = (bool) ($allowHtml ?? false);

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

$attributes['class'] = trim(
    ($attributes['class'] ?? '')
    . ' modulr-floating-sidebar'
);
?>

<aside<?= $renderAttributes($attributes) ?>>
    <div class="modulr-floating-sidebar__panel">
        <?php if (is_string($title) && trim($title) !== ''): ?>
            <h3 class="modulr-floating-sidebar__title"><?= $renderValue($title, $allowHtml) ?></h3>
        <?php endif; ?>

        <div class="modulr-floating-sidebar__slot"><?= $renderValue($slot, $allowHtml) ?></div>
    </div>
</aside>