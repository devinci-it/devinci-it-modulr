<?php

$attributes = $attributes ?? [];
$id = isset($id) ? (string) $id : '';
$options = isset($options) && is_array($options) ? $options : [];
$selected = $selected ?? null;
$placeholder = isset($placeholder) ? $placeholder : null;
$helperText = isset($helperText) ? $helperText : null;
$errorMessage = isset($errorMessage) ? $errorMessage : null;
$multiple = !empty($multiple);
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

$renderOption = static function ($value, $label, $selected): string {
    $selectedState = false;
    if (is_array($selected)) {
        $selectedState = in_array((string) $value, array_map('strval', $selected), true);
    } else {
        $selectedState = (string) $value === (string) $selected;
    }

    return sprintf(
        '<option value="%s"%s>%s</option>',
        htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8'),
        $selectedState ? ' selected' : '',
        htmlspecialchars((string) $label, ENT_QUOTES, 'UTF-8')
    );
};

$renderOptions = static function (array $options, $selected) use (&$renderOptions, $renderOption): string {
    $html = '';

    foreach ($options as $key => $option) {
        if (is_array($option) && isset($option['options']) && is_array($option['options'])) {
            $label = isset($option['label']) ? (string) $option['label'] : (string) $key;
            $html .= '<optgroup label="' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '">';
            $html .= $renderOptions($option['options'], $selected);
            $html .= '</optgroup>';
            continue;
        }

        if (is_array($option) && array_key_exists('value', $option)) {
            $value = $option['value'];
            $label = $option['label'] ?? $option['text'] ?? $value;
            $html .= $renderOption($value, $label, $selected);
            continue;
        }

        if (is_string($key) || is_int($key)) {
            $html .= $renderOption($key, $option, $selected);
        }
    }

    return $html;
};

?>

<select<?= $renderAttributes($attributes) ?>>
    <?php if ($placeholder !== null && !$multiple): ?>
        <option value=""><?= htmlspecialchars((string) $placeholder, ENT_QUOTES, 'UTF-8') ?></option>
    <?php endif; ?>
    <?= $renderOptions($options, $selected) ?>
</select>

<?php if (!empty($helperText)): ?>
    <p id="<?= htmlspecialchars($id . '-help', ENT_QUOTES, 'UTF-8') ?>" class="modulr-select__help">
        <?= htmlspecialchars((string) $helperText, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <p id="<?= htmlspecialchars($id . '-error', ENT_QUOTES, 'UTF-8') ?>" class="modulr-select__error">
        <?= htmlspecialchars((string) $errorMessage, ENT_QUOTES, 'UTF-8') ?>
    </p>
<?php endif; ?>
