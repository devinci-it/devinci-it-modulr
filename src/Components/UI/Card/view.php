<?php
$attributes = $attributes ?? [];
$header = $header ?? null;
$content = $content ?? '';
$footer = $footer ?? null;
$size = $size ?? 'md';
$glass = (bool) ($glass ?? false);
$allowHtml = (bool) ($allowHtml ?? false);
$contentAllowHtml = (bool) ($contentAllowHtml ?? $allowHtml);

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

$sectionValue = static function (?string $value, bool $allowHtml): string {
    if ($value === null) {
        return '';
    }

    return $allowHtml ? $value : htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};

$attributes['class'] = trim(
    ($attributes['class'] ?? '')
    . ' modulr-card'
    . ' modulr-card--' . $size
    . ($glass ? ' modulr-card--glass' : '')
);
?>

<article<?= $renderAttributes($attributes) ?>>
    <?php if (is_string($header) && trim($header) !== ''): ?>
        <header class="modulr-card__header"><?= $sectionValue($header, $allowHtml) ?></header>
    <?php endif; ?>

    <div class="modulr-card__content"><?= $sectionValue((string) $content, $contentAllowHtml) ?></div>

    <?php if (is_string($footer) && trim($footer) !== ''): ?>
        <footer class="modulr-card__footer"><?= $sectionValue($footer, $allowHtml) ?></footer>
    <?php endif; ?>
</article>