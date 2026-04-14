<?php

namespace DevinciIT\Modulr\Components\Navigation\NavList;

use DevinciIT\Modulr\Components\ComponentsBase;

class NavList extends ComponentsBase
{
    /**
     * @var array<int, array{label: string|null, items: array<int, array<string, mixed>>}>
     */
    protected array $sections = [];

    protected string $ariaLabel = 'Navigation';

    protected ?string $currentPath = null;

    protected string $matchMode = 'exact';

    protected bool $dense = false;

    protected bool $inset = false;

    protected bool $allowHtml = false;

    public function __construct(array $options = [])
    {
        if (isset($options['sections']) && is_array($options['sections'])) {
            $this->setSections($options['sections']);
        } elseif (isset($options['items']) && is_array($options['items'])) {
            $this->setItems($options['items']);
        }

        if (isset($options['ariaLabel']) && is_scalar($options['ariaLabel'])) {
            $this->setAriaLabel((string) $options['ariaLabel']);
        }

        if (isset($options['currentPath']) && is_scalar($options['currentPath'])) {
            $this->setCurrentPath((string) $options['currentPath']);
        }

        if (isset($options['matchMode']) && is_scalar($options['matchMode'])) {
            $this->setMatchMode((string) $options['matchMode']);
        }

        if (isset($options['dense'])) {
            $this->setDense((bool) $options['dense']);
        }

        if (isset($options['inset'])) {
            $this->setInset((bool) $options['inset']);
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
     * @param array<int, array<string, mixed>> $items
     */
    public function setItems(array $items): static
    {
        $this->sections = [
            [
                'label' => null,
                'items' => $items,
            ],
        ];

        return $this;
    }

    /**
     * @param array<int, array{label?: mixed, items?: mixed}> $sections
     */
    public function setSections(array $sections): static
    {
        $normalized = [];

        foreach ($sections as $section) {
            if (!is_array($section)) {
                continue;
            }

            $label = isset($section['label']) && is_scalar($section['label'])
                ? trim((string) $section['label'])
                : null;

            $items = isset($section['items']) && is_array($section['items'])
                ? $section['items']
                : [];

            $normalized[] = [
                'label' => $label !== '' ? $label : null,
                'items' => $items,
            ];
        }

        $this->sections = $normalized;

        return $this;
    }

    /**
     * @param array<int, array<string, mixed>> $items
     */
    public function addSection(string $label, array $items): static
    {
        $label = trim($label);

        $this->sections[] = [
            'label' => $label !== '' ? $label : null,
            'items' => $items,
        ];

        return $this;
    }

    /**
     * @param array<string, mixed> $item
     */
    public function addItem(array $item): static
    {
        if ($this->sections === []) {
            $this->sections[] = [
                'label' => null,
                'items' => [],
            ];
        }

        $lastIndex = array_key_last($this->sections);
        if ($lastIndex !== null) {
            $this->sections[$lastIndex]['items'][] = $item;
        }

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

    public function setCurrentPath(string $currentPath): static
    {
        $currentPath = trim($currentPath);
        $this->currentPath = $currentPath !== '' ? $currentPath : null;

        return $this;
    }

    public function setMatchMode(string $matchMode): static
    {
        $matchMode = strtolower(trim($matchMode));
        if (!in_array($matchMode, ['exact', 'prefix'], true)) {
            throw new \InvalidArgumentException("Invalid nav list match mode: {$matchMode}");
        }

        $this->matchMode = $matchMode;

        return $this;
    }

    public function setDense(bool $dense = true): static
    {
        $this->dense = $dense;

        return $this;
    }

    public function setInset(bool $inset = true): static
    {
        $this->inset = $inset;

        return $this;
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function render(): string
    {
        $normalizedSections = $this->normalizeSections($this->sections);
        $activeKey = $this->resolveActiveKey($normalizedSections);

        if ($activeKey !== null) {
            [$sectionIndex, $itemIndex] = explode(':', $activeKey);
            if (isset($normalizedSections[(int) $sectionIndex]['items'][(int) $itemIndex])) {
                $normalizedSections[(int) $sectionIndex]['items'][(int) $itemIndex]['current'] = true;
            }
        }

        return $this->renderComponentView([
            'sections' => $normalizedSections,
            'ariaLabel' => $this->ariaLabel,
            'allowHtml' => $this->allowHtml,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-nav-list' . ($this->dense ? ' modulr-nav-list--dense' : '') . ($this->inset ? ' modulr-nav-list--inset' : ''),
                'data-component' => 'nav-list',
                'data-match-mode' => $this->matchMode,
            ]),
        ], __DIR__);
    }

    /**
     * @param array<int, array{label: string|null, items: array<int, array<string, mixed>>}> $sections
     * @return array<int, array{label: string|null, items: array<int, array{label: string, href: string, icon: string|null, badge: string|null, disabled: bool, current: bool, target: string|null, rel: string|null, attributes: array<string, string>}>}>
     */
    protected function normalizeSections(array $sections): array
    {
        $normalized = [];

        foreach ($sections as $section) {
            $items = [];

            foreach (($section['items'] ?? []) as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $label = isset($item['label']) && is_scalar($item['label'])
                    ? trim((string) $item['label'])
                    : '';

                if ($label === '') {
                    continue;
                }

                $href = isset($item['href']) && is_scalar($item['href'])
                    ? trim((string) $item['href'])
                    : '#';

                $icon = isset($item['icon']) && is_scalar($item['icon'])
                    ? trim((string) $item['icon'])
                    : null;

                $badge = isset($item['badge']) && is_scalar($item['badge'])
                    ? trim((string) $item['badge'])
                    : null;

                $target = isset($item['target']) && is_scalar($item['target'])
                    ? trim((string) $item['target'])
                    : null;

                $rel = isset($item['rel']) && is_scalar($item['rel'])
                    ? trim((string) $item['rel'])
                    : null;

                $items[] = [
                    'label' => $label,
                    'href' => $href !== '' ? $href : '#',
                    'icon' => $icon !== '' ? $icon : null,
                    'badge' => $badge !== '' ? $badge : null,
                    'disabled' => (bool) ($item['disabled'] ?? false),
                    'current' => (bool) ($item['current'] ?? false),
                    'target' => $target !== '' ? $target : null,
                    'rel' => $rel !== '' ? $rel : null,
                    'attributes' => $this->sanitizeAttributes($item['attributes'] ?? []),
                ];
            }

            if ($items === []) {
                continue;
            }

            $normalized[] = [
                'label' => $section['label'] ?? null,
                'items' => $items,
            ];
        }

        return $normalized;
    }

    /**
     * @param array<int, array{label: string|null, items: array<int, array{label: string, href: string, icon: string|null, badge: string|null, disabled: bool, current: bool, target: string|null, rel: string|null, attributes: array<string, string>}>}> $sections
     */
    protected function resolveActiveKey(array $sections): ?string
    {
        foreach ($sections as $sectionIndex => $section) {
            foreach ($section['items'] as $itemIndex => $item) {
                if ($item['current']) {
                    return $sectionIndex . ':' . $itemIndex;
                }
            }
        }

        $path = $this->currentPath ?? $this->detectCurrentPath();
        if ($path === null || $path === '') {
            return null;
        }

        $bestKey = null;
        $bestScore = -1;

        foreach ($sections as $sectionIndex => $section) {
            foreach ($section['items'] as $itemIndex => $item) {
                if ($item['disabled']) {
                    continue;
                }

                $hrefPath = (string) parse_url($item['href'], PHP_URL_PATH);
                if ($hrefPath === '') {
                    continue;
                }

                $isMatch = $this->matchMode === 'exact'
                    ? $hrefPath === $path
                    : ($hrefPath === '/' ? $path === '/' : str_starts_with($path, rtrim($hrefPath, '/')));

                if (!$isMatch) {
                    continue;
                }

                $score = strlen($hrefPath);
                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestKey = $sectionIndex . ':' . $itemIndex;
                }
            }
        }

        return $bestKey;
    }

    protected function detectCurrentPath(): ?string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? null;
        if (!is_string($uri) || $uri === '') {
            return null;
        }

        $path = (string) parse_url($uri, PHP_URL_PATH);

        return $path !== '' ? $path : '/';
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