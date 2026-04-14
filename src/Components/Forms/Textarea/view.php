<?php

$attributes = $attributes ?? [];
$id = isset($id) ? (string) $id : '';
$value = isset($value) ? (string) $value : '';
$helperText = isset($helperText) ? $helperText : null;
$errorMessage = isset($errorMessage) ? $errorMessage : null;
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

<textarea<?= $renderAttributes($attributes) ?>><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?></textarea>

<?php if (!empty($helperText)): ?>
    <p id="<?= htmlspecialchars($id . '-help', ENT_QUOTES, 'UTF-8') ?>" class="modulr-textarea__help">
        <?= htmlspecialchars((string) $helperText, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <p id="<?= htmlspecialchars($id . '-error', ENT_QUOTES, 'UTF-8') ?>" class="modulr-textarea__error">
        <?= htmlspecialchars((string) $errorMessage, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>
