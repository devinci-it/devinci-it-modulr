<?php

$attributes = $attributes ?? [];
$id = isset($id) ? (string) $id : '';
$label = isset($label) ? (string) $label : '';
$helperText = isset($helperText) ? $helperText : null;
$invalid = !empty($invalid);
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

<label class="modulr-checkbox modulr-checkbox--<?= htmlspecialchars($size, ENT_QUOTES, 'UTF-8') ?><?= $invalid ? ' modulr-checkbox--invalid' : '' ?>" for="<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>">
    <input<?= $renderAttributes($attributes) ?>>
    <span class="modulr-checkbox__label"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></span>
</label>

<?php if (!empty($helperText)): ?>
    <p id="<?= htmlspecialchars($id . '-help', ENT_QUOTES, 'UTF-8') ?>" class="modulr-checkbox__help">
        <?= htmlspecialchars((string) $helperText, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>
