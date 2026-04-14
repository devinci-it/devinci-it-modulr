<?php

$label = isset($label) ? (string) $label : '';
$labelFor = isset($labelFor) ? (string) $labelFor : '';
$control = isset($control) ? (string) $control : '';
$helpText = isset($helpText) ? $helpText : null;
$errorText = isset($errorText) ? $errorText : null;
$required = !empty($required);
$invalid = !empty($invalid);
$size = isset($size) ? (string) $size : 'md';

?>

<div class="modulr-form-group modulr-form-group--<?= htmlspecialchars($size, ENT_QUOTES, 'UTF-8') ?><?= $invalid ? ' modulr-form-group--invalid' : '' ?>">
    <?php if ($label !== ''): ?>
        <label class="modulr-form-group__label"<?php if ($labelFor !== ''): ?> for="<?= htmlspecialchars($labelFor, ENT_QUOTES, 'UTF-8') ?>"<?php endif; ?>>
            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
            <?php if ($required): ?>
                <span class="modulr-form-group__required" aria-hidden="true">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <div class="modulr-form-group__control">
        <?= $control ?>
    </div>

    <?php if (!empty($helpText)): ?>
        <p class="modulr-form-group__help">
            <?= htmlspecialchars((string) $helpText, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if (!empty($errorText)): ?>
        <p class="modulr-form-group__error">
            <?= htmlspecialchars((string) $errorText, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>
</div>
