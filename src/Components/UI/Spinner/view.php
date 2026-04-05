<?php
$attrs = $attributes ?? [];
$variant = $variant ?? 'ring';
$size = $size ?? 'md';
$text = $text ?? null;

$classes = [
    'modulr-spinner',
    'modulr-spinner--' . htmlspecialchars((string) $variant, ENT_QUOTES, 'UTF-8'),
    'modulr-spinner--' . htmlspecialchars((string) $size, ENT_QUOTES, 'UTF-8'),
];

if (!empty($attrs['class'])) {
    $classes[] = (string) $attrs['class'];
}

$attrs['class'] = implode(' ', array_filter($classes));

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

$textValue = is_string($text) ? trim($text) : '';
?>

<div<?= $renderAttributes($attrs) ?>>
    <span class="modulr-spinner__visual" aria-hidden="true">
        <?php if ($variant === 'dots'): ?>
            <span class="modulr-spinner__dot"></span>
            <span class="modulr-spinner__dot"></span>
            <span class="modulr-spinner__dot"></span>
        <?php elseif ($variant === 'pulse'): ?>
            <svg class="modulr-spinner__svg modulr-spinner__svg--pulse" viewBox="0 0 48 48" role="presentation" focusable="false">
                <circle class="modulr-spinner__pulse-circle" cx="24" cy="24" r="14"></circle>
            </svg>
        <?php else: ?>
            <svg class="modulr-spinner__svg modulr-spinner__svg--ring" viewBox="0 0 48 48" role="presentation" focusable="false">
                <circle class="modulr-spinner__circle-track" cx="24" cy="24" r="18"></circle>
                <circle class="modulr-spinner__circle-arc" cx="24" cy="24" r="18"></circle>
            </svg>
        <?php endif; ?>
    </span>

    <?php if ($textValue !== ''): ?>
        <span class="modulr-spinner__text" data-base-text="<?= htmlspecialchars($textValue, ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars($textValue, ENT_QUOTES, 'UTF-8') ?>
        </span>
    <?php endif; ?>
</div>