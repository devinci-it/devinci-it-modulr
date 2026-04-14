<?php

namespace DevinciIT\Modulr\Components\Forms\Checkbox;

use DevinciIT\Modulr\Components\ComponentsBase;

class Checkbox extends ComponentsBase
{
    protected array $props = [
        'id' => null,
        'name' => '',
        'value' => '1',
        'checked' => false,
        'disabled' => false,
        'required' => false,
        'invalid' => false,
        'size' => 'md',
        'label' => '',
        'helperText' => null,
    ];

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        foreach (['id', 'name', 'value', 'label', 'helperText'] as $key) {
            if (isset($options[$key]) && is_scalar($options[$key])) {
                $method = 'set' . ucfirst($key);
                $this->$method((string) $options[$key]);
            }
        }

        foreach (['checked', 'disabled', 'required', 'invalid'] as $key) {
            if (isset($options[$key])) {
                $method = 'set' . ucfirst($key);
                $this->$method((bool) $options[$key]);
            }
        }

        if (isset($options['size']) && is_scalar($options['size'])) {
            $this->setSize((string) $options['size']);
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

    public function setValue(string $value): static
    {
        $this->props['value'] = $value;
        return $this;
    }

    public function setChecked(bool $state = true): static
    {
        $this->props['checked'] = $state;
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
            throw new \InvalidArgumentException(sprintf('Invalid checkbox size: %s', $size));
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function setLabel(string $label): static
    {
        $this->props['label'] = trim($label);
        return $this;
    }

    public function setHelperText(?string $text): static
    {
        $text = $text !== null ? trim($text) : '';
        $this->props['helperText'] = $text !== '' ? $text : null;
        return $this;
    }

    public function render(): string
    {
        $id = $this->props['id'];
        if (!$id) {
            $id = 'modulr-checkbox-' . substr(md5(uniqid((string) mt_rand(), true)), 0, 8);
        }

        $describedBy = [];
        if (!empty($this->props['helperText'])) {
            $describedBy[] = $id . '-help';
        }

        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-checkbox__input modulr-checkbox__input--' . $this->props['size'],
            'id' => $id,
            'name' => $this->props['name'],
            'type' => 'checkbox',
            'value' => $this->props['value'],
            'checked' => $this->props['checked'] ? 'checked' : null,
            'disabled' => $this->props['disabled'] ? 'disabled' : null,
            'required' => $this->props['required'] ? 'required' : null,
            'aria-invalid' => $this->props['invalid'] ? 'true' : 'false',
            'aria-describedby' => !empty($describedBy) ? implode(' ', $describedBy) : null,
        ]);

        return $this->renderComponentView([
            'id' => $id,
            'attributes' => $attributes,
            'label' => $this->props['label'],
            'helperText' => $this->props['helperText'],
            'invalid' => $this->props['invalid'],
            'size' => $this->props['size'],
        ], __DIR__);
    }
}
