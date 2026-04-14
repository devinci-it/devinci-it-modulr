<?php

namespace DevinciIT\Modulr\Components\PageLayout\Navbar;

use DevinciIT\Modulr\Components\ComponentsBase;

class Navbar extends ComponentsBase
{
    protected ?string $brand = null;

    protected string $slot = '';

    protected ?string $actions = null;

    protected string $behavior = 'sticky';

    protected bool $allowHtml = false;

    protected array $allowedBehaviors = ['static', 'sticky', 'hide-on-scroll'];

    public function __construct(array $options = [])
    {
        if (isset($options['brand']) && is_scalar($options['brand'])) {
            $this->setBrand((string) $options['brand']);
        }

        if (isset($options['content']) && is_scalar($options['content'])) {
            $this->setContent((string) $options['content']);
        }

        if (isset($options['slot']) && is_scalar($options['slot']) && $this->slot === '') {
            $this->setSlot((string) $options['slot']);
        }

        if (isset($options['actions']) && is_scalar($options['actions'])) {
            $this->setActions((string) $options['actions']);
        }

        if (isset($options['behavior']) && is_string($options['behavior'])) {
            $this->setBehavior($options['behavior']);
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

    public function setBrand(?string $brand): static
    {
        $brand = $brand !== null ? trim($brand) : null;
        $this->brand = $brand !== '' ? $brand : null;

        return $this;
    }

    public function setContent(string $content): static
    {
        $this->slot = trim($content);

        return $this;
    }

    public function setSlot(string $slot): static
    {
        return $this->setContent($slot);
    }

    public function setActions(?string $actions): static
    {
        $actions = $actions !== null ? trim($actions) : null;
        $this->actions = $actions !== '' ? $actions : null;

        return $this;
    }

    public function setBehavior(string $behavior): static
    {
        $behavior = strtolower(trim($behavior));

        if ($behavior === 'hide' || $behavior === 'hide-on-scroll') {
            $behavior = 'hide-on-scroll';
        }

        if (!in_array($behavior, $this->allowedBehaviors, true)) {
            throw new \InvalidArgumentException("Invalid navbar behavior: {$behavior}");
        }

        $this->behavior = $behavior;

        return $this;
    }

    public function setStatic(): static
    {
        return $this->setBehavior('static');
    }

    public function setSticky(): static
    {
        return $this->setBehavior('sticky');
    }

    public function setHideOnScroll(): static
    {
        return $this->setBehavior('hide-on-scroll');
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView([
            'brand' => $this->brand,
            'slot' => $this->slot,
            'actions' => $this->actions,
            'behavior' => $this->behavior,
            'allowHtml' => $this->allowHtml,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-navbar',
                'data-component' => 'navbar',
                'data-behavior' => $this->behavior,
            ]),
        ], __DIR__);
    }
}