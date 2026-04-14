<?php

namespace DevinciIT\Modulr\Components\Forms\FormGroup;

use DevinciIT\Modulr\Components\ComponentsBase;

class FormGroup extends ComponentsBase
{
    protected array $props = [
        'label' => '',
        'labelFor' => null,
        'control' => '',
        'helpText' => null,
        'errorText' => null,
        'required' => false,
        'invalid' => false,
        'size' => 'md',
    ];

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        foreach (['label', 'labelFor', 'control', 'helpText', 'errorText'] as $key) {
            if (isset($options[$key]) && is_scalar($options[$key])) {
                $method = 'set' . ucfirst($key);
                $this->$method((string) $options[$key]);
            }
        }

        foreach (['required', 'invalid'] as $key) {
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

    public function setLabel(string $label): static
    {
        $this->props['label'] = trim($label);
        return $this;
    }

    public function setLabelFor(string $id): static
    {
        $this->props['labelFor'] = trim($id);
        return $this;
    }

    public function setControl(string $html): static
    {
        $this->props['control'] = $html;
        return $this;
    }

    public function setHelpText(?string $text): static
    {
        $text = $text !== null ? trim($text) : '';
        $this->props['helpText'] = $text !== '' ? $text : null;
        return $this;
    }

    public function setErrorText(?string $text): static
    {
        $text = $text !== null ? trim($text) : '';
        $this->props['errorText'] = $text !== '' ? $text : null;
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
            throw new \InvalidArgumentException(sprintf('Invalid form group size: %s', $size));
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView([
            'label' => $this->props['label'],
            'labelFor' => $this->props['labelFor'],
            'control' => $this->props['control'],
            'helpText' => $this->props['helpText'],
            'errorText' => $this->props['errorText'],
            'required' => $this->props['required'],
            'invalid' => $this->props['invalid'],
            'size' => $this->props['size'],
        ], __DIR__);
    }
}
