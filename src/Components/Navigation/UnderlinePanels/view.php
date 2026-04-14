<?php
$tabs = $tabs ?? [];
$ariaLabel = isset($ariaLabel) ? (string) $ariaLabel : 'Tabs';
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

$attributes['class'] = trim(($attributes['class'] ?? '') . ' modulr-underline-panels');
?>

<section<?= $renderAttributes($attributes) ?>>
    <div class="modulr-underline-panels__tablist" role="tablist" aria-label="<?= htmlspecialchars($ariaLabel, ENT_QUOTES, 'UTF-8') ?>">
        <?php foreach ($tabs as $tab): ?>
            <?php
            $label = isset($tab['label']) ? (string) $tab['label'] : 'Tab';
            $tabId = isset($tab['tabId']) ? (string) $tab['tabId'] : '';
            $panelId = isset($tab['panelId']) ? (string) $tab['panelId'] : '';
            $active = (bool) ($tab['active'] ?? false);
            $disabled = (bool) ($tab['disabled'] ?? false);
            $tabAttributes = isset($tab['attributes']) && is_array($tab['attributes']) ? $tab['attributes'] : [];

            $buttonClass = 'modulr-underline-panels__tab';
            if ($active) {
                $buttonClass .= ' is-active';
            }

            $tabAttributes['class'] = trim(($tabAttributes['class'] ?? '') . ' ' . $buttonClass);
            $tabAttributes['id'] = $tabId;
            $tabAttributes['role'] = 'tab';
            $tabAttributes['aria-selected'] = $active ? 'true' : 'false';
            $tabAttributes['aria-controls'] = $panelId;
            $tabAttributes['tabindex'] = $active ? '0' : '-1';
            $tabAttributes['data-panel-target'] = $panelId;

            if ($disabled) {
                $tabAttributes['disabled'] = 'disabled';
                $tabAttributes['aria-disabled'] = 'true';
            }
            ?>
            <button type="button"<?= $renderAttributes($tabAttributes) ?>>
                <?= $renderValue($label, $allowHtml) ?>
            </button>
        <?php endforeach; ?>
    </div>

    <?php foreach ($tabs as $tab): ?>
        <?php
        $panelId = isset($tab['panelId']) ? (string) $tab['panelId'] : '';
        $tabId = isset($tab['tabId']) ? (string) $tab['tabId'] : '';
        $panel = isset($tab['panel']) ? (string) $tab['panel'] : '';
        $active = (bool) ($tab['active'] ?? false);
        ?>
        <section
            class="modulr-underline-panels__panel<?= $active ? ' is-active' : '' ?>"
            id="<?= htmlspecialchars($panelId, ENT_QUOTES, 'UTF-8') ?>"
            role="tabpanel"
            tabindex="0"
            aria-labelledby="<?= htmlspecialchars($tabId, ENT_QUOTES, 'UTF-8') ?>"
            <?= $active ? '' : 'hidden' ?>
        >
            <?= $renderValue($panel, $allowHtml) ?>
        </section>
    <?php endforeach; ?>
</section>
