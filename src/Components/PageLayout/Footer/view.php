<?php
$attributes = $attributes ?? [];
$left = $left ?? null;
$slot = (string) ($slot ?? '');
$right = $right ?? null;
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

$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-footer');
?>

<footer<?= $renderAttributes($attributes) ?>>
    <div class="modulr-footer__inner">
        <?php if (is_string($left) && trim($left) !== ''): ?>
            <div class="modulr-footer__left"><?= $renderValue($left, $allowHtml) ?></div>
        <?php endif; ?>

        <div class="modulr-footer__slot"><?= $renderValue($slot, $allowHtml) ?></div>

        <?php if (is_string($right) && trim($right) !== ''): ?>
            <div class="modulr-footer__right"><?= $renderValue($right, $allowHtml) ?></div>
        <?php endif; ?>
    </div>
</footer>