<?php

namespace DevinciIT\Modulr\Components\PageLayout\FloatingSidebar;

use DevinciIT\Modulr\Components\ComponentsBase;

class FloatingSidebar extends ComponentsBase
{
    protected ?string $title = null;

    protected string $slot = '';

    protected string $side = 'right';

    protected int $topOffset = 96;

    protected string $width = '280px';

    protected bool $allowHtml = false;

    public function __construct(array $options = [])
    {
        if (isset($options['title']) && is_scalar($options['title'])) {
            $this->setTitle((string) $options['title']);
        }

        if (isset($options['content']) && is_scalar($options['content'])) {
            $this->setContent((string) $options['content']);
        }

        if (isset($options['slot']) && is_scalar($options['slot']) && $this->slot === '') {
            $this->setSlot((string) $options['slot']);
        }

        if (isset($options['side']) && is_string($options['side'])) {
            $this->setSide($options['side']);
        }

        if (isset($options['topOffset'])) {
            $this->setTopOffset((int) $options['topOffset']);
        }

        if (isset($options['width']) && is_string($options['width'])) {
            $this->setWidth($options['width']);
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

    public function setTitle(?string $title): static
    {
        $title = $title !== null ? trim($title) : null;
        $this->title = $title !== '' ? $title : null;

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

    public function setSide(string $side): static
    {
        $side = strtolower(trim($side));

        if (!in_array($side, ['left', 'right'], true)) {
            throw new \InvalidArgumentException("Invalid floating sidebar side: {$side}");
        }

        $this->side = $side;

        return $this;
    }

    public function setTopOffset(int $topOffset): static
    {
        $this->topOffset = max(0, $topOffset);

        return $this;
    }

    public function setWidth(string $width): static
    {
        $width = trim($width);
        if ($width !== '') {
            $this->width = $width;
        }

        return $this;
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function render(): string
    {
        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-floating-sidebar',
            'data-component' => 'floating-sidebar',
            'data-side' => $this->side,
            'style' => '--modulr-floating-sidebar-top:' . $this->topOffset . 'px; --modulr-floating-sidebar-width:' . $this->width . ';',
        ]);

        return $this->renderComponentView([
            'title' => $this->title,
            'slot' => $this->slot,
            'side' => $this->side,
            'allowHtml' => $this->allowHtml,
            'attributes' => $attributes,
        ], __DIR__);
    }
}