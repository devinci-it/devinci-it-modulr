<?php

namespace DevinciIT\Modulr\Components\Forms\Select;

use DevinciIT\Modulr\Components\ComponentsBase;

class Select extends ComponentsBase
{
    protected array $props = [
        'id' => null,
        'name' => '',
        'options' => [],
        'selected' => null,
        'multiple' => false,
        'placeholder' => null,
        'disabled' => false,
        'required' => false,
        'invalid' => false,
        'size' => 'md',
        'helperText' => null,
        'errorMessage' => null,
    ];

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        foreach (['id', 'name', 'placeholder', 'helperText', 'errorMessage'] as $key) {
            if (isset($options[$key]) && is_scalar($options[$key])) {
                $method = 'set' . ucfirst($key);
                $this->$method((string) $options[$key]);
            }
        }

        if (isset($options['options']) && is_array($options['options'])) {
            $this->setOptions($options['options']);
        }

        if (isset($options['selected'])) {
            $this->setSelected($options['selected']);
        }

        foreach (['multiple', 'disabled', 'required', 'invalid'] as $key) {
            if (isset($options[$key])) {
                $method = 'set' . ucfirst($key);
                $this->$method((bool) $options[$key]);
            }
        }

        if (isset($options['size']) && is_scalar($options['size'])) {
            $this->setSize((string) $options['size']);
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

    public function setOptions(array $options): static
    {
        $this->props['options'] = $options;
        return $this;
    }

    public function setSelected($value): static
    {
        $this->props['selected'] = $value;
        return $this;
    }

    public function setMultiple(bool $state = true): static
    {
        $this->props['multiple'] = $state;
        return $this;
    }

    public function setPlaceholder(string $placeholder): static
    {
        $placeholder = trim($placeholder);
        $this->props['placeholder'] = $placeholder !== '' ? $placeholder : null;
        return $this;
    }

    public function setDisabled(bool $state = true): static
    {
        $this->props['disabled'] = $state;
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

    public function setSize(string $size): static
    {
        $size = strtolower(trim($size));

        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid select size: %s', $size));
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

    protected function isSelected($candidate): bool
    {
        if ($this->props['multiple']) {
            $selected = is_array($this->props['selected']) ? $this->props['selected'] : [];
            return in_array((string) $candidate, array_map('strval', $selected), true);
        }

        return (string) $candidate === (string) $this->props['selected'];
    }

    public function render(): string
    {
        $id = $this->props['id'];
        if (!$id) {
            $id = 'modulr-select-' . substr(md5(uniqid((string) mt_rand(), true)), 0, 8);
        }

        $describedBy = [];
        if (!empty($this->props['helperText'])) {
            $describedBy[] = $id . '-help';
        }
        if (!empty($this->props['errorMessage'])) {
            $describedBy[] = $id . '-error';
        }

        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-select modulr-select--' . $this->props['size'] . ($this->props['invalid'] ? ' modulr-select--invalid' : ''),
            'id' => $id,
            'name' => $this->props['name'],
            'multiple' => $this->props['multiple'] ? 'multiple' : null,
            'disabled' => $this->props['disabled'] ? 'disabled' : null,
            'required' => $this->props['required'] ? 'required' : null,
            'aria-invalid' => $this->props['invalid'] ? 'true' : 'false',
            'aria-describedby' => !empty($describedBy) ? implode(' ', $describedBy) : null,
        ]);

        return $this->renderComponentView([
            'id' => $id,
            'attributes' => $attributes,
            'options' => $this->props['options'],
            'selected' => $this->props['selected'],
            'placeholder' => $this->props['placeholder'],
            'helperText' => $this->props['helperText'],
            'errorMessage' => $this->props['errorMessage'],
            'multiple' => $this->props['multiple'],
            'size' => $this->props['size'],
        ], __DIR__);
    }
}
