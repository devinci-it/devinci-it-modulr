<?php

namespace DevinciIT\Modulr\Components\PageLayout\Sidebar;

use DevinciIT\Modulr\Components\ComponentsBase;

class SidebarItem extends ComponentsBase
{
    protected array $props = [
        'label' => 'Item',
        'href' => '#',
        'icon' => null,
        'active' => false,
        'target' => null,
        'rel' => null,
        'attributes' => [],
    ];

    public function __construct(array $options = [])
    {
        if (isset($options['id']) && is_string($options['id'])) {
            $this->setId($options['id']);
        }

        if (isset($options['label'])) {
            $this->setLabel((string) $options['label']);
        }

        if (isset($options['href'])) {
            $this->setHref((string) $options['href']);
        }

        if (array_key_exists('icon', $options)) {
            $this->setIcon($options['icon'] !== null ? (string) $options['icon'] : null);
        }

        if (isset($options['active'])) {
            $this->setActive((bool) $options['active']);
        }

        if (isset($options['target'])) {
            $this->setTarget((string) $options['target']);
        }

        if (isset($options['rel'])) {
            $this->setRel((string) $options['rel']);
        }

        if (isset($options['attributes']) && is_array($options['attributes'])) {
            $this->setAttributes($options['attributes']);
        }

        if (isset($options['class']) && is_string($options['class'])) {
            $this->setClass($options['class']);
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    public function setLabel(string $label): static
    {
        $label = trim($label);

        if ($label !== '') {
            $this->props['label'] = $label;
        }

        return $this;
    }

    public function setHref(string $href): static
    {
        $href = trim($href);

        if ($href !== '') {
            $this->props['href'] = $href;
        }

        return $this;
    }

    public function setIcon(?string $icon): static
    {
        $icon = $icon !== null ? trim($icon) : null;
        $this->props['icon'] = $icon === '' ? null : $icon;

        return $this;
    }

    public function setActive(bool $active): static
    {
        $this->props['active'] = $active;

        return $this;
    }

    public function setTarget(string $target): static
    {
        $target = trim($target);

        if ($target !== '') {
            $this->props['target'] = $target;
        }

        return $this;
    }

    public function setRel(string $rel): static
    {
        $rel = trim($rel);

        if ($rel !== '') {
            $this->props['rel'] = $rel;
        }

        return $this;
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function setAttributes(array $attributes): static
    {
        $sanitized = [];

        foreach ($attributes as $key => $value) {
            if (!is_string($key) || $key === '' || !is_scalar($value)) {
                continue;
            }

            $sanitized[$key] = (string) $value;
        }

        $this->props['attributes'] = $sanitized;

        return $this;
    }

    public function render(): string
    {
        $label = (string) $this->props['label'];
        $href = (string) $this->props['href'];
        $icon = $this->props['icon'];
        $active = (bool) $this->props['active'];
        $target = $this->props['target'];
        $rel = $this->props['rel'];
        $attributes = $this->mergeBaseAttributes($this->props['attributes']);

        $liClasses = ['modulr-sidebar__item'];
        if ($active) {
            $liClasses[] = 'is-active';
        }

        $attributes['class'] = trim(($attributes['class'] ?? '') . ' ' . implode(' ', $liClasses));

        $linkAttributes = [
            'class' => trim('modulr-sidebar__item-link' . ($active ? ' is-active' : '')),
            'href' => $href,
            'data-sidebar-item' => $label,
        ];

        if ($active) {
            $linkAttributes['aria-current'] = 'page';
        }

        if ($target !== null) {
            $linkAttributes['target'] = $target;
        }

        if ($rel !== null) {
            $linkAttributes['rel'] = $rel;
        }

        return '<li' . $this->renderAttributes($attributes) . '>'
            . '<a' . $this->renderAttributes($linkAttributes) . '>'
            . $this->renderIcon($icon)
            . '<span class="modulr-sidebar__label">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</span>'
            . '</a>'
            . '</li>';
    }

    /**
     * @return array{label: string, href: string, icon: string|null, active: bool, target: string|null, rel: string|null, attributes: array<string, string>, id: string|null}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->componentId,
            'label' => (string) $this->props['label'],
            'href' => (string) $this->props['href'],
            'icon' => $this->props['icon'],
            'active' => (bool) $this->props['active'],
            'target' => $this->props['target'],
            'rel' => $this->props['rel'],
            'attributes' => $this->props['attributes'],
        ];
    }

    protected function renderIcon(mixed $icon): string
    {
        if ($icon === null || $icon === '') {
            return '';
        }

        $icon = (string) $icon;

        if (preg_match('/\.(svg|png|jpe?g|webp|gif)$/i', $icon)) {
            return '<span class="modulr-sidebar__icon" aria-hidden="true"><img src="' . htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') . '" alt=""></span>';
        }

        return '<span class="modulr-sidebar__icon" aria-hidden="true">' . htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') . '</span>';
    }

    /**
     * @param array<string, string> $attributes
     */
    protected function renderAttributes(array $attributes): string
    {
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
    }
}