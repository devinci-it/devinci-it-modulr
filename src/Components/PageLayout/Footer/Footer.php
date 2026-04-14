<?php

namespace DevinciIT\Modulr\Components\PageLayout\Footer;

use DevinciIT\Modulr\Components\ComponentsBase;

class Footer extends ComponentsBase
{
    protected ?string $left = null;

    protected string $slot = '';

    protected ?string $right = null;

    protected bool $allowHtml = false;

    public function __construct(array $options = [])
    {
        if (isset($options['left']) && is_scalar($options['left'])) {
            $this->setLeft((string) $options['left']);
        }

        if (isset($options['content']) && is_scalar($options['content'])) {
            $this->setContent((string) $options['content']);
        }

        if (isset($options['slot']) && is_scalar($options['slot']) && $this->slot === '') {
            $this->setSlot((string) $options['slot']);
        }

        if (isset($options['right']) && is_scalar($options['right'])) {
            $this->setRight((string) $options['right']);
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

    public function setLeft(?string $left): static
    {
        $left = $left !== null ? trim($left) : null;
        $this->left = $left !== '' ? $left : null;

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

    public function setRight(?string $right): static
    {
        $right = $right !== null ? trim($right) : null;
        $this->right = $right !== '' ? $right : null;

        return $this;
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView([
            'left' => $this->left,
            'slot' => $this->slot,
            'right' => $this->right,
            'allowHtml' => $this->allowHtml,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-footer',
                'data-component' => 'footer',
            ]),
        ], __DIR__);
    }
}