<?php

$rootClasses = [
    'modulr-page-header',
    'modulr-page-header--' . htmlspecialchars($size ?? 'md'),
    'modulr-page-header--' . htmlspecialchars($variant ?? 'default'),
];

$hasContext = !empty($context) || !empty($parentLink) || !empty($contextActions);
$hasDescription = !empty($description);
$hasRight = !empty($trailingVisual) || !empty($leadingAction) || !empty($trailingAction);
?>

<header class="<?= implode(' ', $rootClasses) ?>">
    <?php if ($hasContext): ?>
        <div class="modulr-page-header__context">
            <div class="modulr-page-header__context-left">
                <?= $parentLink ?? '' ?>
                <?= $context ?? '' ?>
            </div>
            <?php if (!empty($contextActions)): ?>
                <div class="modulr-page-header__context-actions">
                    <?= $contextActions ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="modulr-page-header__main">
        <div class="modulr-page-header__left">
            <?php if (!empty($leadingVisual)): ?>
                <div class="modulr-page-header__leading-visual"><?= $leadingVisual ?></div>
            <?php endif; ?>

            <div class="modulr-page-header__content">
                <h1 class="modulr-page-header__title"><?= htmlspecialchars($title) ?></h1>

                <?php if ($hasDescription): ?>
                    <p class="modulr-page-header__description"><?= htmlspecialchars($description) ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($trailingVisual)): ?>
                <div class="modulr-page-header__trailing-visual"><?= $trailingVisual ?></div>
            <?php endif; ?>
        </div>

        <?php if ($hasRight): ?>
            <div class="modulr-page-header__right">
                <?= $leadingAction ?? '' ?>
                <?= $trailingAction ?? '' ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($navigation)): ?>
        <div class="modulr-page-header__nav">
            <?= $navigation ?>
        </div>
    <?php endif; ?>
</header>