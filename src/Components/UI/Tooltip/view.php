<?php

$attrs = $attributes ?? [];

$content   = isset($content) ? (string) $content : 'Tooltip';
$trigger   = isset($trigger) ? (string) $trigger : '?';
$placement = isset($placement) ? (string) $placement : 'top';
$variant   = isset($variant) ? (string) $variant : 'dark';
$size      = isset($size) ? (string) $size : 'md';

$baseClasses = [
    'modulr-tooltip',
    'modulr-tooltip--' . $placement,
    'modulr-tooltip--' . $variant,
    'modulr-tooltip--' . $size,
];

if (!empty($attrs['class'])) {
    $baseClasses[] = (string) $attrs['class'];
}

$attrs['class'] = implode(' ', array_filter($baseClasses));
$attrs['data-open'] = $attrs['data-open'] ?? 'false';

$id = $attrs['id'] ?? ('modulr-tooltip-' . substr(
    md5($content . $trigger . $placement . $variant . $size),
    0,
    10
));

$attrs['id'] = $id;

$buttonId = $id . '-trigger';
$bubbleId = $id . '-bubble';

/**
 * Render attributes safely
 */
$renderAttributes = static function (array $attributes): string {
    $parts = [];

    foreach ($attributes as $key => $value) {
        if (!is_string($key) || $value === null) {
            continue;
        }

        if (is_bool($value)) {
            if ($value === true) {
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

<span<?= $renderAttributes($attrs) ?>>
    <button
        id="<?= htmlspecialchars($buttonId, ENT_QUOTES, 'UTF-8') ?>"
        class="modulr-tooltip__trigger"
        type="button"
        aria-describedby="<?= htmlspecialchars($bubbleId, ENT_QUOTES, 'UTF-8') ?>"
        aria-expanded="false"
        aria-controls="<?= htmlspecialchars($bubbleId, ENT_QUOTES, 'UTF-8') ?>"
    >
        <?= htmlspecialchars($trigger, ENT_QUOTES, 'UTF-8') ?>
    </button>

    <span
        id="<?= htmlspecialchars($bubbleId, ENT_QUOTES, 'UTF-8') ?>"
        class="modulr-tooltip__bubble"
        role="tooltip"
        aria-hidden="true"
    >
        <?= htmlspecialchars($content, ENT_QUOTES, 'UTF-8') ?>
    </span>
</span>