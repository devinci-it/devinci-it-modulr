<?php
$attributes = $attributes ?? [];
$brand = $brand ?? null;
$slot = (string) ($slot ?? '');
$actions = $actions ?? null;
$behavior = (string) ($behavior ?? 'sticky');
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
    . ' modulr-navbar'
    . ' modulr-navbar--' . $behavior
);
?>

<header<?= $renderAttributes($attributes) ?>>
    <div class="modulr-navbar__inner">
        <?php if (is_string($brand) && trim($brand) !== ''): ?>
            <div class="modulr-navbar__brand"><?= $renderValue($brand, $allowHtml) ?></div>
        <?php endif; ?>

        <div class="modulr-navbar__slot"><?= $renderValue($slot, $allowHtml) ?></div>

        <?php if (is_string($actions) && trim($actions) !== ''): ?>
            <div class="modulr-navbar__actions"><?= $renderValue($actions, $allowHtml) ?></div>
        <?php endif; ?>
    </div>
</header>