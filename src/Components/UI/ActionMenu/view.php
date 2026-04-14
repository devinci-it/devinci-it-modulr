<?php
$attributes = $attributes ?? [];
$actions = $actions ?? [];
$linkClass = $linkClass ?? 'modulr-action-menu__link';
$iconClass = $iconClass ?? 'modulr-action-menu__icon';
$size = $size ?? 'md';

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

$menuId = $attributes['id'] ?? ('modulr-action-menu-' . substr(md5(json_encode($actions) ?: ''), 0, 10));
$attributes['id'] = $menuId;
$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-action-menu modulr-action-menu--' . $size);
?>

<div<?= $renderAttributes($attributes) ?>>
    <?php foreach ($actions as $action): ?>
        <?php
        $name = (string) ($action['name'] ?? 'Action');
        $path = (string) ($action['path'] ?? '#');
        $icon = isset($action['icon']) && $action['icon'] !== '' ? (string) $action['icon'] : null;
        $target = isset($action['target']) && $action['target'] !== '' ? (string) $action['target'] : null;
        $rel = isset($action['rel']) && $action['rel'] !== '' ? (string) $action['rel'] : null;
        $actionAttributes = isset($action['attributes']) && is_array($action['attributes']) ? $action['attributes'] : [];

        $href = $path;
        $queryGlue = str_contains($href, '?') ? '&' : '?';
        $href .= $queryGlue . 'action=' . urlencode($name);

        $classes = trim($linkClass . ' ' . ($actionAttributes['class'] ?? ''));
        $actionAttributes['class'] = $classes;
        $actionAttributes['href'] = $href;

        if ($target !== null) {
            $actionAttributes['target'] = $target;
        }

        if ($rel !== null) {
            $actionAttributes['rel'] = $rel;
        }

        $actionAttributes['data-action-name'] = $name;
        ?>

        <a<?= $renderAttributes($actionAttributes) ?>>
            <?php if ($icon !== null): ?>
                <?php if (preg_match('/\.(svg|png|jpe?g|webp|gif)$/i', $icon)): ?>
                    <img class="<?= htmlspecialchars($iconClass, ENT_QUOTES, 'UTF-8') ?>" src="<?= htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') ?>" alt="" aria-hidden="true">
                <?php else: ?>
                    <span class="<?= htmlspecialchars($iconClass, ENT_QUOTES, 'UTF-8') ?>" aria-hidden="true"><?= $icon ?></span>
                <?php endif; ?>
            <?php endif; ?>
            <span class="modulr-action-menu__label"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></span>
        </a>
    <?php endforeach; ?>
</div>