<?php

$attributes = $attributes ?? [];
$layout = isset($layout) ? (string) $layout : 'stacked';
$content = isset($content) ? (string) $content : '';
$submitArea = isset($submitArea) ? (string) $submitArea : '';

$renderAttributes = static function (array $attributes): string {
    $parts = [];

    foreach ($attributes as $key => $value) {
        if (!is_string($key) || $value === null) {
            continue;
        }

        if (is_bool($value)) {
            if ($value) {
                $parts[] = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');
            }
            continue;
        }

        if (!is_scalar($value)) {
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

?>

<form<?= $renderAttributes($attributes) ?>>
    <div class="modulr-form__body modulr-form__body--<?= htmlspecialchars($layout, ENT_QUOTES, 'UTF-8') ?>">
        <?= $content ?>
    </div>

    <?php if ($submitArea !== ''): ?>
        <div class="modulr-form__submit-area">
            <?= $submitArea ?>
        </div>
    <?php endif; ?>
</form>
