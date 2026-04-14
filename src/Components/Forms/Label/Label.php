<?php

namespace DevinciIT\Modulr\Components\Forms\Label;

use DevinciIT\Modulr\Components\ComponentsBase;

class Label extends ComponentsBase
{
    protected array $props = [
        'for' => null,
        'text' => '',
        'required' => false,
        'assistiveText' => null,
        'size' => 'md',
    ];

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        if (isset($options['for']) && is_scalar($options['for'])) {
            $this->setFor((string) $options['for']);
        }

        if (isset($options['text']) && is_scalar($options['text'])) {
            $this->setText((string) $options['text']);
        }

        if (isset($options['required'])) {
            $this->setRequired((bool) $options['required']);
        }

        if (isset($options['assistiveText']) && is_scalar($options['assistiveText'])) {
            $this->setAssistiveText((string) $options['assistiveText']);
        }

        if (isset($options['size']) && is_scalar($options['size'])) {
            $this->setSize((string) $options['size']);
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    public function setFor(string $id): static
    {
        $this->props['for'] = trim($id);
        return $this;
    }

    public function setText(string $text): static
    {
        $this->props['text'] = trim($text);
        return $this;
    }

    public function setRequired(bool $state = true): static
    {
        $this->props['required'] = $state;
        return $this;
    }

    public function setAssistiveText(?string $text): static
    {
        $text = $text !== null ? trim($text) : '';
        $this->props['assistiveText'] = $text !== '' ? $text : null;
        return $this;
    }

    public function setSize(string $size): static
    {
        $size = strtolower(trim($size));

        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid label size: %s', $size));
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView([
            'for' => $this->props['for'],
            'text' => $this->props['text'],
            'required' => $this->props['required'],
            'assistiveText' => $this->props['assistiveText'],
            'size' => $this->props['size'],
        ], __DIR__);
    }
}
