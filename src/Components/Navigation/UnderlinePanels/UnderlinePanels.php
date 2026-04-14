<?php

namespace DevinciIT\Modulr\Components\Navigation\UnderlinePanels;

use DevinciIT\Modulr\Components\ComponentsBase;

class UnderlinePanels extends ComponentsBase
{
    /**
     * @var array<int, array<string, mixed>>
     */
    protected array $tabs = [];

    protected string $ariaLabel = 'Tabs';

    protected ?string $activeTab = null;

    protected bool $allowHtml = false;

    public function __construct(array $options = [])
    {
        if (isset($options['tabs']) && is_array($options['tabs'])) {
            $this->setTabs($options['tabs']);
        }

        if (isset($options['ariaLabel']) && is_scalar($options['ariaLabel'])) {
            $this->setAriaLabel((string) $options['ariaLabel']);
        }

        if (isset($options['activeTab']) && is_scalar($options['activeTab'])) {
            $this->setActiveTab((string) $options['activeTab']);
        }

        if (isset($options['allowHtml'])) {
            $this->allowHtml((bool) $options['allowHtml']);
        }

        if (isset($options['class']) && is_string($options['class'])) {
            $this->setClass($options['class']);
        }

        if (isset($options['id']) && is_string($options['id'])) {
            $this->setId($options['id']);
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    /**
     * @param array<int, array<string, mixed>> $tabs
     */
    public function setTabs(array $tabs): static
    {
        $this->tabs = $tabs;

        return $this;
    }

    /**
     * @param array<string, mixed> $tab
     */
    public function addTab(array $tab): static
    {
        $this->tabs[] = $tab;

        return $this;
    }

    public function setAriaLabel(string $ariaLabel): static
    {
        $ariaLabel = trim($ariaLabel);

        if ($ariaLabel !== '') {
            $this->ariaLabel = $ariaLabel;
        }

        return $this;
    }

    public function setActiveTab(string $tabId): static
    {
        $tabId = trim($tabId);
        $this->activeTab = $tabId !== '' ? $tabId : null;

        return $this;
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function render(): string
    {
        $tabs = $this->normalizeTabs($this->tabs);

        if ($tabs === []) {
            return '';
        }

        $activeIndex = $this->resolveActiveIndex($tabs);

        foreach ($tabs as $index => &$tab) {
            $tab['active'] = $index === $activeIndex;
        }
        unset($tab);

        return $this->renderComponentView([
            'tabs' => $tabs,
            'ariaLabel' => $this->ariaLabel,
            'allowHtml' => $this->allowHtml,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-underline-panels',
                'data-component' => 'underline-panels',
            ]),
        ], __DIR__);
    }

    /**
     * @param array<int, array<string, mixed>> $tabs
     * @return array<int, array{tabId: string, panelId: string, label: string, panel: string, active: bool, disabled: bool, attributes: array<string, string>}>
     */
    protected function normalizeTabs(array $tabs): array
    {
        $normalized = [];

        foreach ($tabs as $index => $tab) {
            if (!is_array($tab)) {
                continue;
            }

            if (isset($tab['href']) || isset($tab['target']) || isset($tab['rel'])) {
                throw new \InvalidArgumentException('UnderlinePanels does not support href/target/rel. Use UnderlineNav when tab activation changes URL.');
            }

            $label = isset($tab['label']) && is_scalar($tab['label'])
                ? trim((string) $tab['label'])
                : '';

            $inlinePanel = isset($tab['panel']) && is_scalar($tab['panel'])
                ? (string) $tab['panel']
                : '';

            $panelView = isset($tab['panelView']) && is_string($tab['panelView'])
                ? trim($tab['panelView'])
                : '';

            $hasInlinePanel = $inlinePanel !== '';
            $hasPanelView = $panelView !== '';

            if ($label === '') {
                continue;
            }

            if ($hasInlinePanel && $hasPanelView) {
                throw new \InvalidArgumentException('UnderlinePanels tab cannot define both panel and panelView. Choose one.');
            }

            if (!$hasInlinePanel && !$hasPanelView) {
                throw new \InvalidArgumentException('UnderlinePanels tabs require panel content via panel or panelView.');
            }

            $panel = $hasPanelView
                ? $this->renderViewFile($panelView, isset($tab['panelData']) && is_array($tab['panelData']) ? $tab['panelData'] : [])
                : $inlinePanel;

            $rawTabId = isset($tab['id']) && is_scalar($tab['id'])
                ? trim((string) $tab['id'])
                : 'tab-' . ($index + 1);

            if ($rawTabId === '') {
                $rawTabId = 'tab-' . ($index + 1);
            }

            $safeTabId = $this->normalizeDomId($rawTabId, 'tab-' . ($index + 1));
            $panelId = 'panel-' . $safeTabId;

            $normalized[] = [
                'tabId' => $safeTabId,
                'panelId' => $panelId,
                'label' => $label,
                'panel' => $panel,
                'active' => (bool) ($tab['active'] ?? false),
                'disabled' => (bool) ($tab['disabled'] ?? false),
                'attributes' => $this->sanitizeAttributes($tab['attributes'] ?? []),
            ];
        }

        return $normalized;
    }

    protected function renderViewFile(string $viewPath, array $viewData = []): string
    {
        $resolvedPath = realpath($viewPath);

        if ($resolvedPath === false || !is_file($resolvedPath)) {
            throw new \InvalidArgumentException("Invalid underline panels view file: {$viewPath}");
        }

        extract($viewData, EXTR_SKIP);

        ob_start();
        include $resolvedPath;

        return (string) ob_get_clean();
    }

    /**
     * @param array<int, array<string, mixed>> $tabs
     */
    protected function resolveActiveIndex(array $tabs): int
    {
        foreach ($tabs as $index => $tab) {
            if ($this->activeTab !== null && $tab['tabId'] === $this->activeTab && empty($tab['disabled'])) {
                return $index;
            }
        }

        foreach ($tabs as $index => $tab) {
            if (!empty($tab['active']) && empty($tab['disabled'])) {
                return $index;
            }
        }

        foreach ($tabs as $index => $tab) {
            if (empty($tab['disabled'])) {
                return $index;
            }
        }

        return 0;
    }

    protected function normalizeDomId(string $value, string $fallback): string
    {
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9\-_]+/', '-', $value) ?? $value;
        $value = trim($value, '-_');

        return $value !== '' ? $value : $fallback;
    }

    /**
     * @param mixed $attributes
     * @return array<string, string>
     */
    protected function sanitizeAttributes($attributes): array
    {
        if (!is_array($attributes)) {
            return [];
        }

        $sanitized = [];

        foreach ($attributes as $key => $value) {
            if (!is_string($key) || $key === '' || !is_scalar($value)) {
                continue;
            }

            $sanitized[$key] = (string) $value;
        }

        return $sanitized;
    }
}
