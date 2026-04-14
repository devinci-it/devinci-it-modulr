<?php

namespace DevinciIT\Modulr\Components\Forms\Textarea;

use DevinciIT\Modulr\Components\ComponentsBase;

class Textarea extends ComponentsBase
{
    protected array $props = [
        'id' => null,
        'name' => '',
        'rows' => 4,
        'value' => '',
        'placeholder' => '',
        'disabled' => false,
        'readonly' => false,
        'required' => false,
        'invalid' => false,
        'resize' => 'vertical',
        'size' => 'md',
        'helperText' => null,
        'errorMessage' => null,
    ];

    protected array $allowedResize = ['none', 'vertical', 'horizontal', 'both'];
    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        if (isset($options['id']) && is_string($options['id'])) {
            $this->setId($options['id']);
        }

        if (isset($options['name']) && is_scalar($options['name'])) {
            $this->setName((string) $options['name']);
        }

        if (isset($options['rows'])) {
            $this->setRows((int) $options['rows']);
        }

        if (isset($options['value']) && is_scalar($options['value'])) {
            $this->setValue((string) $options['value']);
        }

        if (isset($options['placeholder']) && is_scalar($options['placeholder'])) {
            $this->setPlaceholder((string) $options['placeholder']);
        }

        if (isset($options['disabled'])) {
            $this->setDisabled((bool) $options['disabled']);
        }

        if (isset($options['readonly'])) {
            $this->setReadonly((bool) $options['readonly']);
        }

        if (isset($options['required'])) {
            $this->setRequired((bool) $options['required']);
        }

        if (isset($options['invalid'])) {
            $this->setInvalid((bool) $options['invalid']);
        }

        if (isset($options['resize']) && is_scalar($options['resize'])) {
            $this->setResize((string) $options['resize']);
        }

        if (isset($options['size']) && is_scalar($options['size'])) {
            $this->setSize((string) $options['size']);
        }

        if (isset($options['helperText']) && is_scalar($options['helperText'])) {
            $this->setHelperText((string) $options['helperText']);
        }

        if (isset($options['errorMessage']) && is_scalar($options['errorMessage'])) {
            $this->setErrorMessage((string) $options['errorMessage']);
        }

        if (isset($options['class']) && is_string($options['class'])) {
            $this->setClass($options['class']);
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    public function setId(string $id): static
    {
        parent::setId($id);
        $this->props['id'] = trim($id);
        return $this;
    }

    public function setName(string $name): static
    {
        $this->props['name'] = trim($name);
        return $this;
    }

    public function setRows(int $rows): static
    {
        $this->props['rows'] = max(1, $rows);
        return $this;
    }

    public function setValue(string $value): static
    {
        $this->props['value'] = $value;
        return $this;
    }

    public function setPlaceholder(string $placeholder): static
    {
        $this->props['placeholder'] = $placeholder;
        return $this;
    }

    public function setDisabled(bool $state = true): static
    {
        $this->props['disabled'] = $state;
        return $this;
    }

    public function setReadonly(bool $state = true): static
    {
        $this->props['readonly'] = $state;
        return $this;
    }

    public function setRequired(bool $state = true): static
    {
        $this->props['required'] = $state;
        return $this;
    }

    public function setInvalid(bool $state = true): static
    {
        $this->props['invalid'] = $state;
        return $this;
    }

    public function setResize(string $mode): static
    {
        $mode = strtolower(trim($mode));

        if (!in_array($mode, $this->allowedResize, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid textarea resize mode: %s', $mode));
        }

        $this->props['resize'] = $mode;
        return $this;
    }

    public function setSize(string $size): static
    {
        $size = strtolower(trim($size));

        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid textarea size: %s', $size));
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function setHelperText(?string $text): static
    {
        $text = $text !== null ? trim($text) : '';
        $this->props['helperText'] = $text !== '' ? $text : null;
        return $this;
    }

    public function setErrorMessage(?string $text): static
    {
        $text = $text !== null ? trim($text) : '';
        $this->props['errorMessage'] = $text !== '' ? $text : null;
        return $this;
    }

    public function render(): string
    {
        $id = $this->props['id'];
        if (!$id) {
            $id = 'modulr-textarea-' . substr(md5(uniqid((string) mt_rand(), true)), 0, 8);
        }

        $describedBy = [];
        if (!empty($this->props['helperText'])) {
            $describedBy[] = $id . '-help';
        }
        if (!empty($this->props['errorMessage'])) {
            $describedBy[] = $id . '-error';
        }

        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-textarea modulr-textarea--' . $this->props['resize'] . ' modulr-textarea--' . $this->props['size'] . ($this->props['invalid'] ? ' modulr-textarea--invalid' : ''),
            'id' => $id,
            'name' => $this->props['name'],
            'rows' => $this->props['rows'],
            'placeholder' => $this->props['placeholder'],
            'disabled' => $this->props['disabled'] ? 'disabled' : null,
            'readonly' => $this->props['readonly'] ? 'readonly' : null,
            'required' => $this->props['required'] ? 'required' : null,
            'aria-invalid' => $this->props['invalid'] ? 'true' : 'false',
            'aria-describedby' => !empty($describedBy) ? implode(' ', $describedBy) : null,
        ]);

        return $this->renderComponentView([
            'id' => $id,
            'attributes' => $attributes,
            'value' => $this->props['value'],
            'helperText' => $this->props['helperText'],
            'errorMessage' => $this->props['errorMessage'],
            'size' => $this->props['size'],
        ], __DIR__);
    }
}
