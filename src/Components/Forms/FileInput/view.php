<?php

$attrs = $attributes ?? [];

$id = isset($id) ? (string) $id : '';
$name = isset($name) ? (string) $name : 'file';
$label = isset($label) ? (string) $label : 'Upload file';
$required = !empty($required);
$disabled = !empty($disabled);
$multiple = !empty($multiple);
$accept = isset($accept) ? (string) $accept : '';
$acceptVariant = isset($acceptVariant) ? (string) $acceptVariant : 'any';
$helperText = isset($helperText) && $helperText !== null ? (string) $helperText : '';
$dynamicInputAddition = !empty($dynamicInputAddition);
$addButtonLabel = isset($addButtonLabel) ? (string) $addButtonLabel : 'Add File';
$removeButtonLabel = isset($removeButtonLabel) ? (string) $removeButtonLabel : 'Remove';
$showPreview = !empty($showPreview);
$previewPlaceholder = isset($previewPlaceholder) ? (string) $previewPlaceholder : 'No file selected';
$showSelectedFiles = !empty($showSelectedFiles);
$selectedFilesTitle = isset($selectedFilesTitle) ? (string) $selectedFilesTitle : 'Selected files';
$enableDropzone = !empty($enableDropzone);
$dropzoneText = isset($dropzoneText) ? (string) $dropzoneText : 'Drop files here or click to browse';

$classes = ['modulr-file-input', 'modulr-file-input--' . $acceptVariant];
if (!empty($attrs['class'])) {
    $classes[] = (string) $attrs['class'];
}
$attrs['class'] = implode(' ', array_filter($classes));

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

$inputAttributes = [
    'id' => $id . '-input',
    'name' => $name,
    'type' => 'file',
    'class' => 'modulr-file-input__control',
    'data-file-input-control' => 'true',
    'accept' => $accept !== '' ? $accept : null,
    'multiple' => $multiple,
    'required' => $required,
    'disabled' => $disabled,
    'aria-describedby' => ($helperText !== '' || $accept !== '') ? $id . '-help' : null,
];

?>

<div<?= $renderAttributes($attrs) ?>>
    <?php if ($label !== ''): ?>
        <label class="modulr-file-input__label" for="<?= htmlspecialchars($id . '-input', ENT_QUOTES, 'UTF-8') ?>">
            <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
            <?php if ($required): ?>
                <span class="modulr-file-input__required" aria-hidden="true">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>

    <div class="modulr-file-input__list" data-file-input-list="true">
        <div class="modulr-file-input__row" data-file-input-row="true">
            <?php if ($enableDropzone): ?>
                <div class="modulr-file-input__dropzone" data-file-input-dropzone="true" tabindex="0" role="button">
                    <span class="modulr-file-input__dropzone-text"><?= htmlspecialchars($dropzoneText, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            <?php endif; ?>
            <input<?= $renderAttributes($inputAttributes) ?>>
            <?php if ($showPreview): ?>
                <div class="modulr-file-input__preview" data-file-input-preview="true">
                    <img class="modulr-file-input__preview-image" data-file-input-preview-image="true" alt="Selected file preview" hidden>
                    <span class="modulr-file-input__preview-text" data-file-input-preview-text="true"><?= htmlspecialchars($previewPlaceholder, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            <?php endif; ?>
            <?php if ($showSelectedFiles): ?>
                <div class="modulr-file-input__selected" data-file-input-selected="true">
                    <p class="modulr-file-input__selected-title"><?= htmlspecialchars($selectedFilesTitle, ENT_QUOTES, 'UTF-8') ?></p>
                    <ul class="modulr-file-input__selected-list" data-file-input-selected-list="true"></ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($dynamicInputAddition): ?>
        <button
            type="button"
            class="modulr-file-input__add"
            data-file-input-add="true"
            <?= $disabled ? 'disabled' : '' ?>
        >
            <?= htmlspecialchars($addButtonLabel, ENT_QUOTES, 'UTF-8') ?>
        </button>
    <?php endif; ?>

    <?php if ($helperText !== ''): ?>
        <p id="<?= htmlspecialchars($id . '-help', ENT_QUOTES, 'UTF-8') ?>" class="modulr-file-input__help">
            <?= htmlspecialchars($helperText, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php elseif ($accept !== ''): ?>
        <p id="<?= htmlspecialchars($id . '-help', ENT_QUOTES, 'UTF-8') ?>" class="modulr-file-input__help">
            Allowed: <?= htmlspecialchars($accept, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <template data-file-input-template="true">
        <div class="modulr-file-input__row" data-file-input-row="true">
            <?php if ($enableDropzone): ?>
                <div class="modulr-file-input__dropzone" data-file-input-dropzone="true" tabindex="0" role="button">
                    <span class="modulr-file-input__dropzone-text"><?= htmlspecialchars($dropzoneText, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            <?php endif; ?>
            <input
                type="file"
                class="modulr-file-input__control"
                data-file-input-control="true"
                name="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>"
                <?= $multiple ? 'multiple' : '' ?>
                <?= $disabled ? 'disabled' : '' ?>
                <?= $accept !== '' ? 'accept="' . htmlspecialchars($accept, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
            >
            <?php if ($showPreview): ?>
                <div class="modulr-file-input__preview" data-file-input-preview="true">
                    <img class="modulr-file-input__preview-image" data-file-input-preview-image="true" alt="Selected file preview" hidden>
                    <span class="modulr-file-input__preview-text" data-file-input-preview-text="true"><?= htmlspecialchars($previewPlaceholder, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            <?php endif; ?>
            <?php if ($showSelectedFiles): ?>
                <div class="modulr-file-input__selected" data-file-input-selected="true">
                    <p class="modulr-file-input__selected-title"><?= htmlspecialchars($selectedFilesTitle, ENT_QUOTES, 'UTF-8') ?></p>
                    <ul class="modulr-file-input__selected-list" data-file-input-selected-list="true"></ul>
                </div>
            <?php endif; ?>
            <button type="button" class="modulr-file-input__remove" data-file-input-remove="true">
                <?= htmlspecialchars($removeButtonLabel, ENT_QUOTES, 'UTF-8') ?>
            </button>
        </div>
    </template>
</div>