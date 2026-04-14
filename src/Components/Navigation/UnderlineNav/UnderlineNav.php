<?php

namespace DevinciIT\Modulr\Components\Navigation\UnderlineNav;

use DevinciIT\Modulr\Components\ComponentsBase;

class UnderlineNav extends ComponentsBase
{
    /**
     * @var array<int, array<string, mixed>>
     */
    protected array $tabs = [];

    protected string $ariaLabel = 'Sections';

    protected ?string $currentUrl = null;

    protected string $matchMode = 'exact';

    protected bool $allowHtml = false;

    public function __construct(array $options = [])
    {
        if (isset($options['tabs']) && is_array($options['tabs'])) {
            $this->setTabs($options['tabs']);
        }

        if (isset($options['ariaLabel']) && is_scalar($options['ariaLabel'])) {
            $this->setAriaLabel((string) $options['ariaLabel']);
        }

        if (isset($options['currentUrl']) && is_scalar($options['currentUrl'])) {
            $this->setCurrentUrl((string) $options['currentUrl']);
        }

        if (isset($options['matchMode']) && is_scalar($options['matchMode'])) {
            $this->setMatchMode((string) $options['matchMode']);
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

    public function setCurrentUrl(string $currentUrl): static
    {
        $currentUrl = trim($currentUrl);
        $this->currentUrl = $currentUrl !== '' ? $currentUrl : null;

        return $this;
    }

    public function setMatchMode(string $matchMode): static
    {
        $matchMode = strtolower(trim($matchMode));

        if (!in_array($matchMode, ['exact', 'prefix'], true)) {
            throw new \InvalidArgumentException("Invalid underline nav match mode: {$matchMode}");
        }

        $this->matchMode = $matchMode;

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
        $activeIndex = $this->resolveActiveIndex($tabs);

        if ($activeIndex !== null && isset($tabs[$activeIndex])) {
            $tabs[$activeIndex]['current'] = true;
        }

        return $this->renderComponentView([
            'tabs' => $tabs,
            'ariaLabel' => $this->ariaLabel,
            'allowHtml' => $this->allowHtml,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-underline-nav',
                'data-component' => 'underline-nav',
                'data-match-mode' => $this->matchMode,
            ]),
        ], __DIR__);
    }

    /**
     * @param array<int, array<string, mixed>> $tabs
     * @return array<int, array{label: string, href: string, current: bool, target: string|null, rel: string|null, disabled: bool, attributes: array<string, string>}>
     */
    protected function normalizeTabs(array $tabs): array
    {
        $normalized = [];

        foreach ($tabs as $tab) {
            if (!is_array($tab)) {
                continue;
            }

            if (isset($tab['panel']) || isset($tab['panelId']) || isset($tab['content'])) {
                throw new \InvalidArgumentException('UnderlineNav tabs only support URL navigation. Use UnderlinePanels for same-page tab panels.');
            }

            $label = isset($tab['label']) && is_scalar($tab['label'])
                ? trim((string) $tab['label'])
                : '';

            $href = isset($tab['href']) && is_scalar($tab['href'])
                ? trim((string) $tab['href'])
                : '';

            if ($label === '') {
                continue;
            }

            if ($href === '') {
                throw new \InvalidArgumentException('UnderlineNav tabs require an href. URL-changing tabs belong to UnderlineNav.');
            }

            $normalized[] = [
                'label' => $label,
                'href' => $href,
                'current' => (bool) ($tab['current'] ?? false),
                'target' => isset($tab['target']) && is_scalar($tab['target']) ? trim((string) $tab['target']) : null,
                'rel' => isset($tab['rel']) && is_scalar($tab['rel']) ? trim((string) $tab['rel']) : null,
                'disabled' => (bool) ($tab['disabled'] ?? false),
                'attributes' => $this->sanitizeAttributes($tab['attributes'] ?? []),
            ];
        }

        return $normalized;
    }

    /**
     * @param array<int, array<string, mixed>> $tabs
     */
    protected function resolveActiveIndex(array $tabs): ?int
    {
        $manual = null;

        foreach ($tabs as $index => $tab) {
            if (!empty($tab['current'])) {
                $manual = $index;
            }
        }

        if ($this->currentUrl === null || $this->currentUrl === '') {
            return $manual;
        }

        foreach ($tabs as $index => $tab) {
            $href = (string) ($tab['href'] ?? '');
            if ($href === '') {
                continue;
            }

            if ($this->matchMode === 'exact' && $href === $this->currentUrl) {
                return $index;
            }

            if ($this->matchMode === 'prefix' && strpos($this->currentUrl, $href) === 0) {
                return $index;
            }
        }

        return $manual;
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
