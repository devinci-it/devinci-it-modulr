<?php

namespace DevinciIT\Modulr\Components\PageLayout\Sidebar;

use DevinciIT\Modulr\Components\ComponentsBase;

class Sidebar extends ComponentsBase
{
    /**
     * @var array<int, array{label: string, items: array<int, array{label: string, href: string, icon: string|null, active: bool, attributes: array<string, string>}>, attributes: array<string, string>}>
     */
    protected array $menus = [];

    protected bool $expanded = true;

    protected bool $collapsible = false;

    protected string $variant = 'panel';

    protected string $toggleExpandedLabel = 'Hide menu';

    protected string $toggleCollapsedLabel = 'Show menu';

    public function __construct(array $options = [])
    {
        if (isset($options['menus']) && is_array($options['menus'])) {
            $this->setMenus($options['menus']);
        }

        if (isset($options['expanded'])) {
            $this->setExpanded((bool) $options['expanded']);
        }

        if (isset($options['collapsible'])) {
            $this->setCollapsible((bool) $options['collapsible']);
        }

        if (isset($options['variant'])) {
            $this->setVariant((string) $options['variant']);
        }

        if (isset($options['toggleLabel'])) {
            $this->setToggleExpandedLabel((string) $options['toggleLabel']);
        }

        if (isset($options['toggleExpandedLabel'])) {
            $this->setToggleExpandedLabel((string) $options['toggleExpandedLabel']);
        }

        if (isset($options['toggleCollapsedLabel'])) {
            $this->setToggleCollapsedLabel((string) $options['toggleCollapsedLabel']);
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
     * @param array<int, array<string, mixed>> $menus
     */
    public function setMenus(array $menus): static
    {
        $this->menus = [];

        foreach ($menus as $menu) {
            if (!is_array($menu)) {
                continue;
            }

            $this->menus[] = $this->normalizeMenu($menu);
        }

        return $this;
    }

    /**
     * @param array<string, mixed> $menu
     * @return array{label: string, items: array<int, array{label: string, href: string, icon: string|null, active: bool, attributes: array<string, string>}>, attributes: array<string, string>}
     */
    protected function normalizeMenu(array $menu): array
    {
        $label = trim((string) ($menu['label'] ?? 'Menu'));
        $attributes = $this->sanitizeAttributes($menu['attributes'] ?? []);
        $items = [];

        foreach (($menu['items'] ?? []) as $item) {
            if ($item instanceof SidebarItem) {
                $item = $item->toArray();
            }

            if (!is_array($item)) {
                continue;
            }

            $itemLabel = trim((string) ($item['label'] ?? ''));
            $href = trim((string) ($item['href'] ?? '#'));
            $icon = isset($item['icon']) && $item['icon'] !== '' ? (string) $item['icon'] : null;
            $active = (bool) ($item['active'] ?? false);
            $id = isset($item['id']) && is_string($item['id']) ? trim($item['id']) : null;
            $target = isset($item['target']) && is_string($item['target']) ? trim($item['target']) : null;
            $rel = isset($item['rel']) && is_string($item['rel']) ? trim($item['rel']) : null;

            if ($itemLabel === '') {
                continue;
            }

            $items[] = [
                'id' => $id !== '' ? $id : null,
                'label' => $itemLabel,
                'href' => $href,
                'icon' => $icon,
                'active' => $active,
                'target' => $target !== '' ? $target : null,
                'rel' => $rel !== '' ? $rel : null,
                'attributes' => $this->sanitizeAttributes($item['attributes'] ?? []),
            ];
        }

        return [
            'label' => $label !== '' ? $label : 'Menu',
            'items' => $items,
            'attributes' => $attributes,
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $items
     */
    public function addMenu(string $label, array $items, array $attributes = []): static
    {
        $this->menus[] = $this->normalizeMenu([
            'label' => $label,
            'items' => $items,
            'attributes' => $attributes,
        ]);

        return $this;
    }

    public function setExpanded(bool $expanded): static
    {
        $this->expanded = $expanded;

        return $this;
    }

    public function setCollapsible(bool $collapsible): static
    {
        $this->collapsible = $collapsible;

        return $this;
    }

    public function setVariant(string $variant): static
    {
        $variant = trim($variant);
        if ($variant !== '') {
            $this->variant = $variant;
        }

        if ($this->variant === 'compact') {
            $this->collapsible = true;
        }

        return $this;
    }

    public function setToggleLabel(string $label): static
    {
        return $this->setToggleExpandedLabel($label);
    }

    public function setToggleExpandedLabel(string $label): static
    {
        $label = trim($label);
        if ($label !== '') {
            $this->toggleExpandedLabel = $label;
        }

        return $this;
    }

    public function setToggleCollapsedLabel(string $label): static
    {
        $label = trim($label);
        if ($label !== '') {
            $this->toggleCollapsedLabel = $label;
        }

        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView([
            'menus' => $this->menus,
            'expanded' => $this->expanded,
            'collapsible' => $this->collapsible,
            'variant' => $this->variant,
            'toggleExpandedLabel' => $this->toggleExpandedLabel,
            'toggleCollapsedLabel' => $this->toggleCollapsedLabel,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-sidebar',
                'data-component' => 'sidebar',
                'data-expanded' => $this->expanded ? 'true' : 'false',
                'data-collapsible' => $this->collapsible ? 'true' : 'false',
                'data-variant' => $this->variant,
                'data-expanded-label' => $this->toggleExpandedLabel,
                'data-collapsed-label' => $this->toggleCollapsedLabel,
            ]),
        ], __DIR__);
    }

    /**
     * @param array<string, mixed> $attributes
     * @return array<string, string>
     */
    protected function sanitizeAttributes(array $attributes): array
    {
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