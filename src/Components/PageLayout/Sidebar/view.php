<?php
$attributes = $attributes ?? [];
$menus = $menus ?? [];
$expanded = (bool) ($expanded ?? true);
$collapsible = (bool) ($collapsible ?? true);
$variant = (string) ($variant ?? 'panel');
$toggleExpandedLabel = (string) ($toggleExpandedLabel ?? 'Hide menu');
$toggleCollapsedLabel = (string) ($toggleCollapsedLabel ?? 'Show menu');

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

$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-sidebar modulr-sidebar--' . $variant);
$attributes['data-expanded'] = $expanded ? 'true' : 'false';
$attributes['data-collapsible'] = $collapsible ? 'true' : 'false';
?>

<aside<?= $renderAttributes($attributes) ?>>
    <?php if ($collapsible): ?>
        <button
            type="button"
            class="modulr-sidebar__toggle"
            aria-expanded="<?= $expanded ? 'true' : 'false' ?>"
            aria-label="<?= htmlspecialchars($expanded ? $toggleExpandedLabel : $toggleCollapsedLabel, ENT_QUOTES, 'UTF-8') ?>"
            data-sidebar-toggle
        >
            <span class="modulr-sidebar__toggle-icon" data-sidebar-toggle-icon aria-hidden="true"><?= $expanded ? '×' : '☰' ?></span>
        </button>
    <?php endif; ?>

    <div class="modulr-sidebar__panel" data-sidebar-panel>
        <?php foreach ($menus as $menu): ?>
            <?php
            $menuLabel = (string) ($menu['label'] ?? 'Menu');
            $menuAttributes = isset($menu['attributes']) && is_array($menu['attributes']) ? $menu['attributes'] : [];
            $items = isset($menu['items']) && is_array($menu['items']) ? $menu['items'] : [];
            ?>

            <section class="modulr-sidebar__menu"<?= $renderAttributes($menuAttributes) ?>>
                <h2 class="modulr-sidebar__menu-title"><?= htmlspecialchars($menuLabel, ENT_QUOTES, 'UTF-8') ?></h2>

                <ul class="modulr-sidebar__list">
                    <?php foreach ($items as $item): ?>
                        <?= \DevinciIT\Modulr\Components\PageLayout\Sidebar\SidebarItem::make($item)->render() ?>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endforeach; ?>
    </div>
</aside>