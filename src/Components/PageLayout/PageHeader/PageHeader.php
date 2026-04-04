<?php

namespace DevinciIT\Modulr\Components\PageLayout\PageHeader;

use DevinciIT\Modulr\Components\ComponentsBase;

class PageHeader extends ComponentsBase
{
    protected array $props = [
        'size' => 'md', // sm | md | lg

        // Context bar
        'context' => null,
        'parentLink' => null,
        'contextActions' => null,

        // Title bar
        'title' => '',
        'variant' => 'default', // default | large | subtitle
        'description' => null,

        // Visuals
        'leadingVisual' => null,
        'trailingVisual' => null,

        // Actions
        'leadingAction' => null,
        'trailingAction' => null,

        // Extra
        'navigation' => null,
    ];

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (array_key_exists($key, $this->props)) {
                $this->props[$key] = $value;
            }
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    public function setTitle(string $title): static
    {
        $this->props['title'] = $title;
        return $this;
    }

    public function setSize(string $size): static
    {
        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException("Invalid page header size: {$size}");
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function setVariant(string $variant): static
    {
        $this->props['variant'] = $variant;
        return $this;
    }

    public function setDescription(string $desc): static
    {
        $this->props['description'] = $desc;
        return $this;
    }

    public function setContext(string $html): static
    {
        $this->props['context'] = $html;
        return $this;
    }

    public function setParentLink(string $html): static
    {
        $this->props['parentLink'] = $html;
        return $this;
    }

    public function setContextActions(string $html): static
    {
        $this->props['contextActions'] = $html;
        return $this;
    }

    public function setLeadingVisual(string $html): static
    {
        $this->props['leadingVisual'] = $html;
        return $this;
    }

    public function setTrailingVisual(string $html): static
    {
        $this->props['trailingVisual'] = $html;
        return $this;
    }

    public function setLeadingAction(string $html): static
    {
        $this->props['leadingAction'] = $html;
        return $this;
    }

    public function setTrailingAction(string $html): static
    {
        $this->props['trailingAction'] = $html;
        return $this;
    }

    public function setNavigation(string $html): static
    {
        $this->props['navigation'] = $html;
        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView($this->props, __DIR__);
    }
}