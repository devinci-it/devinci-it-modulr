<?php

namespace DevinciIT\Modulr\Components\UI\Card;

use DevinciIT\Modulr\Components\ComponentsBase;

class Card extends ComponentsBase
{
    protected ?string $header = null;

    protected string $content = '';

    protected ?string $footer = null;

    protected string $size = 'md';

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    protected bool $glass = false;

    protected bool $allowHtml = false;

    protected ?string $contentView = null;

    protected array $contentViewData = [];

    public function __construct(array $options = [])
    {
        if (isset($options['header']) && is_scalar($options['header'])) {
            $this->setHeader((string) $options['header']);
        }

        if (isset($options['content']) && is_scalar($options['content'])) {
            $this->setContent((string) $options['content']);
        }

        if (isset($options['slot']) && is_scalar($options['slot']) && $this->content === '') {
            $this->setSlot((string) $options['slot']);
        }

        if (isset($options['footer']) && is_scalar($options['footer'])) {
            $this->setFooter((string) $options['footer']);
        }

        if (isset($options['view']) && is_string($options['view'])) {
            $viewData = isset($options['viewData']) && is_array($options['viewData'])
                ? $options['viewData']
                : [];

            $this->setView($options['view'], $viewData);
        }

        if (isset($options['size']) && is_string($options['size'])) {
            $this->setSize($options['size']);
        }

        if (isset($options['glass'])) {
            $this->setGlass((bool) $options['glass']);
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

    public function setHeader(?string $header): static
    {
        $header = $header !== null ? trim($header) : null;
        $this->header = $header !== '' ? $header : null;

        return $this;
    }

    public function setContent(string $content): static
    {
        $this->contentView = null;
        $this->contentViewData = [];
        $this->content = trim($content);

        return $this;
    }

    public function setSlot(string $slot): static
    {
        return $this->setContent($slot);
    }

    public function setFooter(?string $footer): static
    {
        $footer = $footer !== null ? trim($footer) : null;
        $this->footer = $footer !== '' ? $footer : null;

        return $this;
    }

    public function setSize(string $size): static
    {
        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException("Invalid card size: {$size}");
        }

        $this->size = $size;

        return $this;
    }

    public function setGlass(bool $glass = true): static
    {
        $this->glass = $glass;

        return $this;
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function setView(string $viewPath, array $viewData = []): static
    {
        $resolvedPath = realpath($viewPath);

        if ($resolvedPath === false || !is_file($resolvedPath)) {
            throw new \InvalidArgumentException("Invalid card view file: {$viewPath}");
        }

        $this->contentView = $resolvedPath;
        $this->contentViewData = $viewData;

        return $this;
    }

    public function render(): string
    {
        $content = $this->contentView !== null
            ? $this->renderViewFile($this->contentView, $this->contentViewData)
            : $this->content;

        return $this->renderComponentView([
            'header' => $this->header,
            'content' => $content,
            'footer' => $this->footer,
            'size' => $this->size,
            'glass' => $this->glass,
            'allowHtml' => $this->allowHtml,
            'contentAllowHtml' => $this->allowHtml || $this->contentView !== null,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-card',
                'data-component' => 'card',
                'data-size' => $this->size,
                'data-glass' => $this->glass ? 'true' : 'false',
            ]),
        ], __DIR__);
    }

    protected function renderViewFile(string $viewPath, array $viewData): string
    {
        extract($viewData, EXTR_SKIP);

        ob_start();
        include $viewPath;

        return (string) ob_get_clean();
    }
}