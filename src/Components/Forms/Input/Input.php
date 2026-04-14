<?php

namespace DevinciIT\Modulr\Components\Forms\Input;

use DevinciIT\Modulr\Components\ComponentsBase;

class Input extends ComponentsBase
{
    protected array $props = [
        'id' => null,
        'name' => '',
        'type' => 'text',
        'value' => '',
        'placeholder' => '',
        'disabled' => false,
        'readonly' => false,
        'required' => false,
        'invalid' => false,
        'errorMessage' => null,
        'helperText' => null,
        'leadingAdornment' => null,
        'trailingAdornment' => null,
        'autocomplete' => null,
        'size' => 'md',
    ];

    protected array $allowedTypes = ['text', 'email', 'password', 'number', 'search', 'url', 'tel'];
    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        if (isset($options['id']) && is_string($options['id'])) {
            $this->setId($options['id']);
        }

        if (isset($options['name']) && is_scalar($options['name'])) {
            $this->setName((string) $options['name']);
        }

        if (isset($options['type']) && is_scalar($options['type'])) {
            $this->setType((string) $options['type']);
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

        if (isset($options['errorMessage']) && is_scalar($options['errorMessage'])) {
            $this->setErrorMessage((string) $options['errorMessage']);
        }

        if (isset($options['helperText']) && is_scalar($options['helperText'])) {
            $this->setHelperText((string) $options['helperText']);
        }

        if (isset($options['leadingAdornment']) && is_scalar($options['leadingAdornment'])) {
            $this->setLeadingAdornment((string) $options['leadingAdornment']);
        }

        if (isset($options['trailingAdornment']) && is_scalar($options['trailingAdornment'])) {
            $this->setTrailingAdornment((string) $options['trailingAdornment']);
        }

        if (isset($options['autocomplete']) && is_scalar($options['autocomplete'])) {
            $this->setAutocomplete((string) $options['autocomplete']);
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

    public function setType(string $type): static
    {
        $type = strtolower(trim($type));
        if (!in_array($type, $this->allowedTypes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid input type: %s', $type));
        }

        $this->props['type'] = $type;
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

    public function setErrorMessage(?string $message): static
    {
        $message = $message !== null ? trim($message) : '';
        $this->props['errorMessage'] = $message !== '' ? $message : null;
        return $this;
    }

    public function setHelperText(?string $message): static
    {
        $message = $message !== null ? trim($message) : '';
        $this->props['helperText'] = $message !== '' ? $message : null;
        return $this;
    }

    public function setLeadingAdornment(?string $html): static
    {
        $this->props['leadingAdornment'] = $html;
        return $this;
    }

    public function setTrailingAdornment(?string $html): static
    {
        $this->props['trailingAdornment'] = $html;
        return $this;
    }

    public function setAutocomplete(?string $autocomplete): static
    {
        $autocomplete = $autocomplete !== null ? trim($autocomplete) : '';
        $this->props['autocomplete'] = $autocomplete !== '' ? $autocomplete : null;
        return $this;
    }

    public function setSize(string $size): static
    {
        $size = strtolower(trim($size));

        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid input size: %s', $size));
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function render(): string
    {
        $id = $this->props['id'];
        if (!$id) {
            $id = 'modulr-input-' . substr(md5(uniqid((string) mt_rand(), true)), 0, 8);
        }

        $describedBy = [];
        if (!empty($this->props['helperText'])) {
            $describedBy[] = $id . '-help';
        }
        if (!empty($this->props['errorMessage'])) {
            $describedBy[] = $id . '-error';
        }

        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-input modulr-input--' . $this->props['size'] . ($this->props['invalid'] ? ' modulr-input--invalid' : ''),
            'id' => $id,
            'name' => $this->props['name'],
            'type' => $this->props['type'],
            'value' => $this->props['value'],
            'placeholder' => $this->props['placeholder'],
            'disabled' => $this->props['disabled'] ? 'disabled' : null,
            'readonly' => $this->props['readonly'] ? 'readonly' : null,
            'required' => $this->props['required'] ? 'required' : null,
            'autocomplete' => $this->props['autocomplete'],
            'aria-invalid' => $this->props['invalid'] ? 'true' : 'false',
            'aria-describedby' => !empty($describedBy) ? implode(' ', $describedBy) : null,
        ]);

        return $this->renderComponentView([
            'id' => $id,
            'attributes' => $attributes,
            'helperText' => $this->props['helperText'],
            'errorMessage' => $this->props['errorMessage'],
            'leadingAdornment' => $this->props['leadingAdornment'],
            'trailingAdornment' => $this->props['trailingAdornment'],
            'size' => $this->props['size'],
        ], __DIR__);
    }
}
