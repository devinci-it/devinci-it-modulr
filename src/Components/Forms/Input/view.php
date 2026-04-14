<?php

$attributes = $attributes ?? [];
$id = isset($id) ? (string) $id : '';
$helperText = isset($helperText) ? $helperText : null;
$errorMessage = isset($errorMessage) ? $errorMessage : null;
$leadingAdornment = isset($leadingAdornment) ? $leadingAdornment : null;
$trailingAdornment = isset($trailingAdornment) ? $trailingAdornment : null;
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

<div class="modulr-input__wrapper modulr-input__wrapper--<?= htmlspecialchars($size, ENT_QUOTES, 'UTF-8') ?><?php echo !empty($leadingAdornment) || !empty($trailingAdornment) ? ' modulr-input__wrapper--adorned' : ''; ?>">
    <?php if (!empty($leadingAdornment)): ?>
        <span class="modulr-input__adornment modulr-input__adornment--leading"><?php echo $leadingAdornment; ?></span>
    <?php endif; ?>

    <input<?= $renderAttributes($attributes) ?>>

    <?php if (!empty($trailingAdornment)): ?>
        <span class="modulr-input__adornment modulr-input__adornment--trailing"><?php echo $trailingAdornment; ?></span>
    <?php endif; ?>
</div>

<?php if (!empty($helperText)): ?>
    <p id="<?= htmlspecialchars($id . '-help', ENT_QUOTES, 'UTF-8') ?>" class="modulr-input__help">
        <?= htmlspecialchars((string) $helperText, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <p id="<?= htmlspecialchars($id . '-error', ENT_QUOTES, 'UTF-8') ?>" class="modulr-input__error">
        <?= htmlspecialchars((string) $errorMessage, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>
