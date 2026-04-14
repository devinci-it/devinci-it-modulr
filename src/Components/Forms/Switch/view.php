<?php

$attributes = $attributes ?? [];
$id = isset($id) ? (string) $id : '';
$label = isset($label) ? (string) $label : '';
$description = isset($description) ? $description : null;
$size = isset($size) ? (string) $size : 'md';

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

<label class="modulr-switch modulr-switch--<?= htmlspecialchars($size, ENT_QUOTES, 'UTF-8') ?>" for="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
    <span class="modulr-switch__track" aria-hidden="true">
        <input<?= $renderAttributes($attributes) ?>>
        <span class="modulr-switch__thumb"></span>
    </span>

    <span class="modulr-switch__content">
        <span class="modulr-switch__label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
        <?php if (!empty($description)): ?>
            <span id="<?= htmlspecialchars($id . '-description', ENT_QUOTES, 'UTF-8') ?>" class="modulr-switch__description">
                <?= htmlspecialchars((string) $description, ENT_QUOTES, 'UTF-8') ?>
            </span>
        <?php endif; ?>
    </span>
</label>
