<?php

namespace DevinciIT\Modulr\Components\UI\Tooltip;

use DevinciIT\Modulr\Components\ComponentsBase;

class Tooltip extends ComponentsBase
{
    protected array $props = [
        'content' => 'Tooltip',
        'trigger' => '?',
        'placement' => 'top',
        'variant' => 'dark',
        'size' => 'md',
    ];

    protected array $allowedPlacements = ['top', 'right', 'bottom', 'left'];
    protected array $allowedVariants = ['dark', 'light', 'brand'];
    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        if (isset($options['content'])) {
            $this->setContent((string) $options['content']);
        }

        if (isset($options['trigger'])) {
            $this->setTrigger((string) $options['trigger']);
        }

        if (isset($options['placement'])) {
            $this->setPlacement((string) $options['placement']);
        }

        if (isset($options['variant'])) {
            $this->setVariant((string) $options['variant']);
        }

        if (isset($options['size'])) {
            $this->setSize((string) $options['size']);
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    public function setContent(string $content): static
    {
        $content = trim($content);
        if ($content !== '') {
            $this->props['content'] = $content;
        }

        return $this;
    }

    public function setTrigger(string $trigger): static
    {
        $trigger = trim($trigger);
        if ($trigger !== '') {
            $this->props['trigger'] = $trigger;
        }

        return $this;
    }

    public function setPlacement(string $placement): static
    {
        if (!in_array($placement, $this->allowedPlacements, true)) {
            throw new \InvalidArgumentException("Invalid tooltip placement: {$placement}");
        }

        $this->props['placement'] = $placement;
        return $this;
    }

    public function setVariant(string $variant): static
    {
        if (!in_array($variant, $this->allowedVariants, true)) {
            throw new \InvalidArgumentException("Invalid tooltip variant: {$variant}");
        }

        $this->props['variant'] = $variant;
        return $this;
    }

    public function setSize(string $size): static
    {
        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException("Invalid tooltip size: {$size}");
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function render(): string
    {
        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-tooltip',
            'data-component' => 'tooltip',
            'data-placement' => (string) $this->props['placement'],
            'data-variant' => (string) $this->props['variant'],
            'data-size' => (string) $this->props['size'],
        ]);

        return $this->renderComponentView([
            'content' => $this->props['content'],
            'trigger' => $this->props['trigger'],
            'placement' => $this->props['placement'],
            'variant' => $this->props['variant'],
            'size' => $this->props['size'],
            'attributes' => $attributes,
        ], __DIR__);
    }
}