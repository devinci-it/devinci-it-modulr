<?php

namespace DevinciIT\Modulr\Components\DataDisplay\Token;

use DevinciIT\Modulr\Components\ComponentsBase;

class Token extends ComponentsBase
{
    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(
        protected string $label,
        protected array $options = []
    ) {}

    public static function make(string $label, array $options = []): static
    {
        return new static($label, $options);
    }

    public function setSize(string $size): static
    {
        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException("Invalid token size: {$size}");
        }

        $this->options['size'] = $size;
        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView([
            'label' => $this->label,
            'size' => $this->options['size'] ?? 'md',
            'leadingVisual' => $this->options['leadingVisual'] ?? null,
            'removable' => $this->options['removable'] ?? false,
            'removeLabel' => $this->options['removeLabel'] ?? 'Remove token',
            'href' => $this->options['href'] ?? null,
            'attributes' => $this->mergeBaseAttributes($this->options['attributes'] ?? []),
        ], __DIR__);
    }

}