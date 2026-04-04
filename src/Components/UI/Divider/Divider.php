<?php

namespace DevinciIT\Modulr\Components\UI\Divider;

use DevinciIT\Modulr\Components\ComponentsBase;

class Divider extends ComponentsBase
{
    protected array $props = [
        'orientation' => 'horizontal', // horizontal | vertical
        'size' => 'md', // sm | md | lg
        'style' => 'solid', // solid | dashed | dotted
        'color' => 'default', // default | muted | strong
    ];

    protected array $allowedOrientations = ['horizontal', 'vertical'];
    protected array $allowedSizes = ['sm', 'md', 'lg'];
    protected array $allowedStyles = ['solid', 'dashed', 'dotted'];
    protected array $allowedColors = ['default', 'muted', 'strong'];

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

    public function setOrientation(string $orientation): static
    {
        if (!in_array($orientation, $this->allowedOrientations, true)) {
            throw new \InvalidArgumentException("Invalid divider orientation: {$orientation}");
        }
        $this->props['orientation'] = $orientation;
        return $this;
    }

    public function setSize(string $size): static
    {
        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException("Invalid divider size: {$size}");
        }
        $this->props['size'] = $size;
        return $this;
    }

    public function setStyle(string $style): static
    {
        if (!in_array($style, $this->allowedStyles, true)) {
            throw new \InvalidArgumentException("Invalid divider style: {$style}");
        }
        $this->props['style'] = $style;
        return $this;
    }

    public function setColor(string $color): static
    {
        if (!in_array($color, $this->allowedColors, true)) {
            throw new \InvalidArgumentException("Invalid divider color: {$color}");
        }
        $this->props['color'] = $color;
        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView($this->props, __DIR__);
    }
}