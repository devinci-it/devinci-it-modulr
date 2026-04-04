<?php

namespace DevinciIT\Modulr\Components\UI\Button;

use DevinciIT\Modulr\Components\ComponentsBase;


class Button extends ComponentsBase
{
    protected array $props = [
        'id' => null,
        'label' => '',
        'variant' => 'primary',
        'size' => 'md',
        'rounded' => false,
        'disabled' => false,
        'loading' => false,
        'href' => null,
        'iconLeft' => null,
        'iconRight' => null,
    ];

    protected array $allowedVariants = ['primary', 'secondary', 'outline'];
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

    public function setId(string $id): static
    {
        parent::setId($id);
        $this->props['id'] = $id;
        return $this;
    }

    public function setLabel(string $label) { $this->props['label'] = $label; return $this; }

    public function setVariant(string $variant)
    {
        if (!in_array($variant, $this->allowedVariants)) {
            throw new \InvalidArgumentException("Invalid button variant: $variant");
        }

        $this->props['variant'] = $variant;
        return $this;
    }

    public function setSize(string $size)
    {
        if (!in_array($size, $this->allowedSizes)) {
            throw new \InvalidArgumentException("Invalid button size: $size");
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function setRounded(bool $state = true)
    {
        $this->props['rounded'] = $state;
        return $this;
    }

    public function setDisabled(bool $state = true)
    {
        $this->props['disabled'] = $state;
        return $this;
    }

    public function setLoading(bool $state = true)
    {
        $this->props['loading'] = $state;
        return $this;
    }

    public function setHref(string $href)
    {
        $this->props['href'] = $href;
        return $this;
    }

    public function setIcon(string $html, string $position = 'left')
    {
        $this->props[$position === 'right' ? 'iconRight' : 'iconLeft'] = $html;
        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView($this->props, __DIR__);
    }
}