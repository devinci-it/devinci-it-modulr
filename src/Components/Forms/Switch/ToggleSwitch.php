<?php

namespace DevinciIT\Modulr\Components\Forms\Switch;

use DevinciIT\Modulr\Components\ComponentsBase;

class ToggleSwitch extends ComponentsBase
{
    protected array $props = [
        'id' => null,
        'name' => '',
        'checked' => false,
        'disabled' => false,
        'size' => 'md',
        'label' => '',
        'description' => null,
    ];

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        foreach (['id', 'name', 'label', 'description'] as $key) {
            if (isset($options[$key]) && is_scalar($options[$key])) {
                $method = 'set' . ucfirst($key);
                $this->$method((string) $options[$key]);
            }
        }

        foreach (['checked', 'disabled'] as $key) {
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

    public function setSize(string $size): static
    {
        $size = strtolower(trim($size));

        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid switch size: %s', $size));
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function setLabel(string $label): static
    {
        $this->props['label'] = trim($label);
        return $this;
    }

    public function setDescription(?string $description): static
    {
        $description = $description !== null ? trim($description) : '';
        $this->props['description'] = $description !== '' ? $description : null;
        return $this;
    }

    public function render(): string
    {
        $id = $this->props['id'];
        if (!$id) {
            $id = 'modulr-switch-' . substr(md5(uniqid((string) mt_rand(), true)), 0, 8);
        }

        $describedBy = [];
        if (!empty($this->props['description'])) {
            $describedBy[] = $id . '-description';
        }

        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-switch__input modulr-switch__input--' . $this->props['size'],
            'id' => $id,
            'name' => $this->props['name'],
            'type' => 'checkbox',
            'checked' => $this->props['checked'] ? 'checked' : null,
            'disabled' => $this->props['disabled'] ? 'disabled' : null,
            'role' => 'switch',
            'aria-checked' => $this->props['checked'] ? 'true' : 'false',
            'aria-describedby' => !empty($describedBy) ? implode(' ', $describedBy) : null,
        ]);

        return $this->renderComponentView([
            'id' => $id,
            'attributes' => $attributes,
            'label' => $this->props['label'],
            'description' => $this->props['description'],
            'size' => $this->props['size'],
        ], __DIR__);
    }
}
