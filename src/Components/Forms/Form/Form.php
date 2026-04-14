<?php

namespace DevinciIT\Modulr\Components\Forms\Form;

use DevinciIT\Modulr\Components\ComponentsBase;

class Form extends ComponentsBase
{
    protected array $props = [
        'action' => '',
        'method' => 'post',
        'noValidate' => false,
        'autocomplete' => 'on',
        'layout' => 'stacked',
        'content' => '',
        'submitArea' => '',
    ];

    protected array $allowedLayouts = ['stacked', 'inline', 'grid'];

    public function __construct(array $options = [])
    {
        if (isset($options['action']) && is_scalar($options['action'])) {
            $this->setAction((string) $options['action']);
        }

        if (isset($options['method']) && is_scalar($options['method'])) {
            $this->setMethod((string) $options['method']);
        }

        if (isset($options['noValidate'])) {
            $this->setNoValidate((bool) $options['noValidate']);
        }

        if (isset($options['autocomplete']) && is_scalar($options['autocomplete'])) {
            $this->setAutocomplete((string) $options['autocomplete']);
        }

        if (isset($options['layout']) && is_scalar($options['layout'])) {
            $this->setLayout((string) $options['layout']);
        }

        if (isset($options['content']) && is_scalar($options['content'])) {
            $this->setContent((string) $options['content']);
        }

        if (isset($options['submitArea']) && is_scalar($options['submitArea'])) {
            $this->setSubmitArea((string) $options['submitArea']);
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

    public function setAction(string $action): static
    {
        $this->props['action'] = trim($action);
        return $this;
    }

    public function setMethod(string $method): static
    {
        $method = strtolower(trim($method));
        $this->props['method'] = $method !== '' ? $method : 'post';
        return $this;
    }

    public function setNoValidate(bool $state = true): static
    {
        $this->props['noValidate'] = $state;
        return $this;
    }

    public function setAutocomplete(string $mode): static
    {
        $this->props['autocomplete'] = trim($mode) !== '' ? trim($mode) : 'on';
        return $this;
    }

    public function setLayout(string $layout): static
    {
        $layout = strtolower(trim($layout));

        if (!in_array($layout, $this->allowedLayouts, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid form layout: %s', $layout));
        }

        $this->props['layout'] = $layout;
        return $this;
    }

    public function setContent(string $content): static
    {
        $this->props['content'] = $content;
        return $this;
    }

    public function setSubmitArea(string $submitArea): static
    {
        $this->props['submitArea'] = $submitArea;
        return $this;
    }

    public function render(): string
    {
        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-form modulr-form--' . $this->props['layout'],
            'action' => $this->props['action'],
            'method' => $this->props['method'],
            'autocomplete' => $this->props['autocomplete'],
            'novalidate' => $this->props['noValidate'] ? 'novalidate' : null,
        ]);

        return $this->renderComponentView([
            'attributes' => $attributes,
            'layout' => $this->props['layout'],
            'content' => $this->props['content'],
            'submitArea' => $this->props['submitArea'],
        ], __DIR__);
    }
}
