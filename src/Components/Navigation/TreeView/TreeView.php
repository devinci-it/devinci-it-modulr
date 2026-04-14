<?php

namespace DevinciIT\Modulr\Components\Navigation\TreeView;

use DevinciIT\Modulr\Components\ComponentsBase;

class TreeView extends ComponentsBase
{
    /**
     * @var array<int, array<string, mixed>>
     */
    protected array $items = [];

    protected string $ariaLabel = 'Tree view';

    protected ?string $currentPath = null;

    protected string $activationMode = 'selection';

    protected string $matchMode = 'exact';

    protected bool $allowHtml = false;

    protected bool $dense = false;

    protected array $expandedPaths = [];

    protected array $expandedByDefault = [];

    public function __construct(array $options = [])
    {
        if (isset($options['items']) && is_array($options['items'])) {
            $this->setItems($options['items']);
        }

        if (isset($options['ariaLabel']) && is_scalar($options['ariaLabel'])) {
            $this->setAriaLabel((string) $options['ariaLabel']);
        }

        if (isset($options['currentPath']) && is_scalar($options['currentPath'])) {
            $this->setCurrentPath((string) $options['currentPath']);
        }

        if (isset($options['activationMode']) && is_string($options['activationMode'])) {
            $this->setActivationMode($options['activationMode']);
        }

        if (isset($options['matchMode']) && is_string($options['matchMode'])) {
            $this->setMatchMode($options['matchMode']);
        }

        if (isset($options['dense'])) {
            $this->setDense((bool) $options['dense']);
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
        $this->items = $items;

        return $this;
    }

    /**
     * @param array<string, mixed> $item
     */
    public function addItem(array $item): static
    {
        $this->items[] = $item;

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

    public function setActivationMode(string $activationMode): static
    {
        $activationMode = strtolower(trim($activationMode));

        if (!in_array($activationMode, ['selection', 'navigation'], true)) {
            throw new \InvalidArgumentException("Invalid tree view activation mode: {$activationMode}");
        }

        $this->activationMode = $activationMode;

        return $this;
    }

    public function setMatchMode(string $matchMode): static
    {
        $matchMode = strtolower(trim($matchMode));

        if (!in_array($matchMode, ['exact', 'prefix'], true)) {
            throw new \InvalidArgumentException("Invalid tree view match mode: {$matchMode}");
        }

        $this->matchMode = $matchMode;

        return $this;
    }

    public function setDense(bool $dense = true): static
    {
        $this->dense = $dense;

        return $this;
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    /**
     * Mark a branch as expanded on first render.
     */
    public function expandPath(string $path): static
    {
        $path = trim($path);

        if ($path !== '' && !in_array($path, $this->expandedPaths, true)) {
            $this->expandedPaths[] = $path;
        }

        return $this;
    }

    /**
     * @param array<int, string> $paths
     */
    public function setExpandedPaths(array $paths): static
    {
        $this->expandedPaths = [];

        foreach ($paths as $path) {
            if (!is_scalar($path)) {
                continue;
            }

            $path = trim((string) $path);
            if ($path !== '') {
                $this->expandedPaths[] = $path;
            }
        }

        return $this;
    }

    public function expandAll(bool $state = true): static
    {
        $this->expandedByDefault = $state ? ['*'] : [];

        return $this;
    }

    public function render(): string
    {
        $normalizedItems = $this->normalizeItems($this->items);
        $activePath = $this->resolveActivePath($normalizedItems);

        return $this->renderComponentView([
            'items' => $normalizedItems,
            'ariaLabel' => $this->ariaLabel,
            'allowHtml' => $this->allowHtml,
            'activationMode' => $this->activationMode,
            'matchMode' => $this->matchMode,
            'activePath' => $activePath,
            'expandedPaths' => $this->expandedPaths,
            'expandedByDefault' => $this->expandedByDefault,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-tree-view' . ($this->dense ? ' modulr-tree-view--dense' : ''),
                'data-component' => 'tree-view',
                'data-activation-mode' => $this->activationMode,
                'data-match-mode' => $this->matchMode,
            ]),
        ], __DIR__);
    }

    /**
     * @param array<int, array<string, mixed>> $items
     * @return array<int, array{label: string, href: string|null, active: bool, expanded: bool, icon: string|null, badge: string|null, children: array<int, array<string, mixed>>, attributes: array<string, string>, id: string}>
     */
    protected function normalizeItems(array $items, string $pathPrefix = ''): array
    {
        $normalized = [];

        foreach ($items as $index => $item) {
            if (!is_array($item)) {
                continue;
            }

            $label = isset($item['label']) && is_scalar($item['label'])
                ? trim((string) $item['label'])
                : '';

            if ($label === '') {
                continue;
            }

            $path = isset($item['path']) && is_scalar($item['path'])
                ? trim((string) $item['path'])
                : null;

            $href = isset($item['href']) && is_scalar($item['href'])
                ? trim((string) $item['href'])
                : null;

            $icon = isset($item['icon']) && is_scalar($item['icon'])
                ? trim((string) $item['icon'])
                : null;

            $badge = isset($item['badge']) && is_scalar($item['badge'])
                ? trim((string) $item['badge'])
                : null;

            $children = isset($item['children']) && is_array($item['children'])
                ? $this->normalizeItems($item['children'], $this->makePath($pathPrefix, (string) $index))
                : [];

            $resolvedPath = $path !== '' ? $path : $href;
            $resolvedPath = is_string($resolvedPath) && $resolvedPath !== '' ? $resolvedPath : null;

            $current = (bool) ($item['current'] ?? false);
            $expanded = (bool) ($item['expanded'] ?? false);

            $nodePath = $this->makePath($pathPrefix, (string) $index);
            if ($expanded || in_array($nodePath, $this->expandedPaths, true) || in_array('*', $this->expandedByDefault, true)) {
                $expanded = true;
            }

            $normalized[] = [
                'label' => $label,
                'href' => $resolvedPath,
                'active' => $current,
                'expanded' => $expanded,
                'icon' => $icon !== '' ? $icon : null,
                'badge' => $badge !== '' ? $badge : null,
                'children' => $children,
                'attributes' => $this->sanitizeAttributes($item['attributes'] ?? []),
                'id' => isset($item['id']) && is_scalar($item['id']) && trim((string) $item['id']) !== ''
                    ? trim((string) $item['id'])
                    : 'modulr-tree-view-' . substr(md5($nodePath . $label), 0, 10),
            ];
        }

        return $normalized;
    }

    /**
     * @param array<int, array<string, mixed>> $items
     */
    protected function resolveActivePath(array $items, string $pathPrefix = ''): ?string
    {
        $currentPath = $this->currentPath ?? $this->detectCurrentPath();
        if ($currentPath === null || $currentPath === '') {
            return null;
        }

        $best = null;
        $bestScore = -1;

        foreach ($items as $index => $item) {
            $nodePath = $this->makePath($pathPrefix, (string) $index);
            $href = $item['href'] ?? null;

            if ($item['active'] === true) {
                return $nodePath;
            }

            if (is_string($href) && $href !== '') {
                $candidatePath = (string) parse_url($href, PHP_URL_PATH);
                if ($candidatePath !== '') {
                    $isMatch = $this->matchMode === 'exact'
                        ? $candidatePath === $currentPath
                        : ($candidatePath === '/' ? $currentPath === '/' : str_starts_with($currentPath, rtrim($candidatePath, '/')));

                    if ($isMatch) {
                        $score = strlen($candidatePath);
                        if ($score > $bestScore) {
                            $bestScore = $score;
                            $best = $nodePath;
                        }
                    }
                }
            }

            if (!empty($item['children'])) {
                $childMatch = $this->resolveActivePath($item['children'], $nodePath);
                if ($childMatch !== null) {
                    return $childMatch;
                }
            }
        }

        return $best;
    }

    protected function makePath(string $prefix, string $suffix): string
    {
        return $prefix === '' ? $suffix : $prefix . '.' . $suffix;
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