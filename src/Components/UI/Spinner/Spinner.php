<?php

namespace DevinciIT\Modulr\Components\UI\Spinner;

use DevinciIT\Modulr\Components\ComponentsBase;

class Spinner extends ComponentsBase
{
    protected array $props = [
        'text' => null,
        'size' => 'md',
        'variant' => 'ring',
        'label' => 'Loading',
        'animateText' => false,
    ];

    protected array $allowedSizes = ['sm', 'md', 'lg'];
    protected array $allowedVariants = ['ring', 'dots', 'pulse'];

    public function __construct(array $options = [])
    {
        if (isset($options['text'])) {
            $this->setText($options['text'] !== null ? (string) $options['text'] : null);
        }

        if (isset($options['size'])) {
            $this->setSize((string) $options['size']);
        }

        if (isset($options['variant'])) {
            $this->setVariant((string) $options['variant']);
        }

        if (isset($options['label'])) {
            $this->setLabel((string) $options['label']);
        }

        if (isset($options['animateText'])) {
            $this->setAnimateText((bool) $options['animateText']);
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    public function setText(?string $text): static
    {
        $text = $text !== null ? trim($text) : null;
        $this->props['text'] = $text === '' ? null : $text;
        return $this;
    }

    public function setSize(string $size): static
    {
        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException("Invalid spinner size: {$size}");
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function setVariant(string $variant): static
    {
        if (!in_array($variant, $this->allowedVariants, true)) {
            throw new \InvalidArgumentException("Invalid spinner variant: {$variant}");
        }

        $this->props['variant'] = $variant;
        return $this;
    }

    public function setLabel(string $label): static
    {
        $label = trim($label);
        if ($label !== '') {
            $this->props['label'] = $label;
        }

        return $this;
    }

    public function setAnimateText(bool $animate): static
    {
        $this->props['animateText'] = $animate;
        return $this;
    }

    public function render(): string
    {
        $attributes = $this->mergeBaseAttributes([
            'data-component' => 'spinner',
            'data-variant' => (string) $this->props['variant'],
            'data-size' => (string) $this->props['size'],
            'data-animate-text' => $this->props['animateText'] ? 'true' : 'false',
            'role' => 'status',
            'aria-live' => 'polite',
            'aria-label' => (string) $this->props['label'],
        ]);

        return $this->renderComponentView([
            'text' => $this->props['text'],
            'size' => $this->props['size'],
            'variant' => $this->props['variant'],
            'label' => $this->props['label'],
            'animateText' => $this->props['animateText'],
            'attributes' => $attributes,
        ], __DIR__);
    }
}