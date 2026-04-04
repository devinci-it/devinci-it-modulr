<?php

$tag = !empty($href) ? 'a' : 'button';

$classes = [
    'modulr-button',
    'modulr-button--' . $variant,
    'modulr-button--' . $size,
];

if (!empty($disabled)) {
    $classes[] = 'modulr-button--disabled';
}

if (!empty($loading)) {
    $classes[] = 'modulr-button--loading';
}

if (!empty($rounded)) {
    $classes[] = 'modulr-button--rounded';
}

$attrs = [];

if (!empty($id)) {
    $attrs[] = 'id="' . htmlspecialchars($id, ENT_QUOTES) . '"';
}

if ($tag === 'a') {
    $attrs[] = 'href="' . htmlspecialchars($href, ENT_QUOTES) . '"';
} else {
    $attrs[] = 'type="button"';
}

if (!empty($disabled) || !empty($loading)) {
    $attrs[] = 'aria-disabled="true"';
    $attrs[] = 'tabindex="-1"';
}

?>

<<?= $tag ?> class="<?= implode(' ', $classes) ?>" <?= implode(' ', $attrs) ?>>

    <?php if (!empty($loading)): ?>
        <span class="modulr-button__spinner" aria-hidden="true"></span>
    <?php endif; ?>

    <?php if (!empty($iconLeft)): ?>
        <span class="modulr-button__icon modulr-button__icon--left">
            <?= $iconLeft ?>
        </span>
    <?php endif; ?>

    <span class="modulr-button__label">
        <?= htmlspecialchars($label) ?>
    </span>

    <?php if (!empty($iconRight)): ?>
        <span class="modulr-button__icon modulr-button__icon--right">
            <?= $iconRight ?>
        </span>
    <?php endif; ?>

</<?= $tag ?>>