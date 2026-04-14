<?php
$modalId = isset($modalId) ? (string) $modalId : '';
$header = isset($header) ? $header : null;
$body = isset($body) ? (string) $body : '';
$footer = isset($footer) ? $footer : null;
$actions = isset($actions) && is_array($actions) ? $actions : [];
$allowHtml = (bool) ($allowHtml ?? false);
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

$hasHeader = is_string($header) && trim($header) !== '';
$hasFooter = (is_string($footer) && trim($footer) !== '') || !empty($actions);

$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-modal');
$attributes['role'] = 'dialog';
$attributes['aria-modal'] = 'true';
$attributes['tabindex'] = '-1';

if ($hasHeader && $modalId !== '') {
    $attributes['aria-labelledby'] = $modalId . '-title';
}
?>

<div<?= $renderAttributes($attributes) ?>>
    <div class="modulr-modal__backdrop" data-modal-close="backdrop"></div>

    <div class="modulr-modal__panel" role="document">
        <?php if ($hasHeader): ?>
            <header class="modulr-modal__header">
                <h2 class="modulr-modal__title"<?= $modalId !== '' ? ' id="' . htmlspecialchars($modalId . '-title', ENT_QUOTES, 'UTF-8') . '"' : '' ?>>
                    <?= $renderValue((string) $header, $allowHtml) ?>
                </h2>

                <button
                    type="button"
                    class="modulr-modal__close"
                    data-modal-close="button"
                    aria-label="Close dialog"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </header>
        <?php endif; ?>

        <div class="modulr-modal__body">
            <?= $renderValue($body, $allowHtml) ?>
        </div>

        <?php if ($hasFooter): ?>
            <footer class="modulr-modal__footer">
                <?php if (is_string($footer) && trim($footer) !== ''): ?>
                    <?= $renderValue($footer, $allowHtml) ?>
                <?php else: ?>
                    <?php foreach ($actions as $action): ?>
                        <?php
                        $actionLabel = isset($action['label']) ? (string) $action['label'] : '';
                        $actionVariant = isset($action['variant']) ? (string) $action['variant'] : 'secondary';
                        $actionName = isset($action['action']) ? (string) $action['action'] : '';
                        $dismiss = (bool) ($action['dismiss'] ?? true);
                        $actionAttributes = isset($action['attributes']) && is_array($action['attributes']) ? $action['attributes'] : [];

                        $actionAttributes['type'] = $actionAttributes['type'] ?? 'button';
                        $actionAttributes['class'] = trim(($actionAttributes['class'] ?? '') . ' modulr-modal__action modulr-modal__action--' . $actionVariant);

                        if ($actionName !== '') {
                            $actionAttributes['data-modal-action'] = $actionName;
                        }

                        if ($dismiss) {
                            $actionAttributes['data-modal-close'] = 'action';
                        }
                        ?>

                        <button<?= $renderAttributes($actionAttributes) ?>>
                            <?= $renderValue($actionLabel, $allowHtml) ?>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </footer>
        <?php endif; ?>
    </div>
</div>
