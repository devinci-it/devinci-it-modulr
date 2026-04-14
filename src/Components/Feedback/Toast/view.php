<?php
$toastId = isset($toastId) ? (string) $toastId : '';
$title = isset($title) ? $title : null;
$message = isset($message) ? (string) $message : '';
$dismissible = (bool) ($dismissible ?? true);
$allowHtml = (bool) ($allowHtml ?? false);
$actionLabel = isset($actionLabel) ? $actionLabel : null;
$actionHref = isset($actionHref) ? $actionHref : null;
$actionTarget = isset($actionTarget) ? $actionTarget : null;
$actionRel = isset($actionRel) ? $actionRel : null;
$attributes = $attributes ?? [];

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

$renderValue = static function (?string $value, bool $allowHtml): string {
    if ($value === null) {
        return '';
    }

    return $allowHtml ? $value : htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};

$hasTitle = is_string($title) && trim($title) !== '';
$hasAction = is_string($actionLabel) && trim($actionLabel) !== '' && is_string($actionHref) && trim($actionHref) !== '';

$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-toast');
?>

<div<?= $renderAttributes($attributes) ?>>
    <div class="modulr-toast__content">
        <?php if ($hasTitle): ?>
            <h4 class="modulr-toast__title"<?= $toastId !== '' ? ' id="' . htmlspecialchars($toastId . '-title', ENT_QUOTES, 'UTF-8') . '"' : '' ?>>
                <?= $renderValue((string) $title, $allowHtml) ?>
            </h4>
        <?php endif; ?>

        <div class="modulr-toast__message">
            <?= $renderValue($message, $allowHtml) ?>
        </div>

        <?php if ($hasAction): ?>
            <a
                class="modulr-toast__action"
                href="<?= htmlspecialchars((string) $actionHref, ENT_QUOTES, 'UTF-8') ?>"
                <?= is_string($actionTarget) && trim($actionTarget) !== '' ? 'target="' . htmlspecialchars((string) $actionTarget, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
                <?= is_string($actionRel) && trim($actionRel) !== '' ? 'rel="' . htmlspecialchars((string) $actionRel, ENT_QUOTES, 'UTF-8') . '"' : '' ?>
            >
                <?= $renderValue((string) $actionLabel, $allowHtml) ?>
            </a>
        <?php endif; ?>
    </div>

    <?php if ($dismissible): ?>
        <button type="button" class="modulr-toast__close" data-toast-close="button" aria-label="Dismiss notification">
            <span aria-hidden="true">×</span>
        </button>
    <?php endif; ?>
</div>