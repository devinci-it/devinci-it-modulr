<?php

$for = isset($for) ? (string) $for : '';
$text = isset($text) ? (string) $text : '';
$required = !empty($required);
$assistiveText = isset($assistiveText) ? $assistiveText : null;
$size = isset($size) ? (string) $size : 'md';

?>

<label<?php if ($for !== ''): ?> for="<?= htmlspecialchars($for, ENT_QUOTES, 'UTF-8') ?>"<?php endif; ?> class="modulr-label modulr-label--<?= htmlspecialchars($size, ENT_QUOTES, 'UTF-8') ?>">
    <span class="modulr-label__text"><?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8') ?></span>
    <?php if ($required): ?>
        <span class="modulr-label__required" aria-hidden="true">*</span>
    <?php endif; ?>
    <?php if (!empty($assistiveText)): ?>
        <span class="modulr-label__assistive"><?= htmlspecialchars((string) $assistiveText, ENT_QUOTES, 'UTF-8') ?></span>
    <?php endif; ?>
</label>
