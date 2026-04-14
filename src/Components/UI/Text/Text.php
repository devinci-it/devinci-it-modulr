<?php

namespace DevinciIT\Modulr\Components\UI\Text;

use DevinciIT\Modulr\Components\ComponentsBase;

class Text extends ComponentsBase
{
    protected array $props = [
        'text' => '',
        'variant' => 'body-medium',
        'tag' => 'p',
        'weight' => null,
    ];

    protected array $allowedVariants = [
        'display',
        'body-large',
        'code-block',
        'title-large',
        'title-medium',
        'title-small',
        'subtitle',
        'body-medium',
        'body-small',
        'caption',
        'code-inline',
    ];

    protected array $allowedTags = ['p', 'span', 'div', 'label', 'small', 'strong', 'em', 'code', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'];
    protected array $allowedWeights = ['light', 'normal', 'medium', 'semibold'];

    public function __construct(array $options = [])
    {
        if (isset($options['text']) && is_scalar($options['text'])) {
            $this->setText((string) $options['text']);
        }

        if (isset($options['variant']) && is_scalar($options['variant'])) {
            $this->setVariant((string) $options['variant']);
        }

        if (isset($options['tag']) && is_scalar($options['tag'])) {
            $this->setTag((string) $options['tag']);
        }

        if (isset($options['weight']) && is_scalar($options['weight'])) {
            $this->setWeight((string) $options['weight']);
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

    public function setText(string $text): static
    {
        $this->props['text'] = $text;
        return $this;
    }

    public function setVariant(string $variant): static
    {
        $normalized = strtolower(trim($variant));

        if (!in_array($normalized, $this->allowedVariants, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid text variant: %s', $variant));
        }

        $this->props['variant'] = $normalized;
        return $this;
    }

    public function setTag(string $tag): static
    {
        $normalized = strtolower(trim($tag));

        if (!in_array($normalized, $this->allowedTags, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid text tag: %s', $tag));
        }

        $this->props['tag'] = $normalized;
        return $this;
    }

    public function setWeight(?string $weight): static
    {
        if ($weight === null) {
            $this->props['weight'] = null;
            return $this;
        }

        $normalized = strtolower(trim($weight));

        if (!in_array($normalized, $this->allowedWeights, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid text weight: %s', $weight));
        }

        $this->props['weight'] = $normalized;
        return $this;
    }

    public function render(): string
    {
        $attributes = $this->mergeBaseAttributes([
            'class' => 'modulr-text modulr-text--' . $this->props['variant'] . ($this->props['weight'] ? ' modulr-text--weight-' . $this->props['weight'] : ''),
        ]);

        return $this->renderComponentView([
            'text' => $this->props['text'],
            'tag' => $this->props['tag'],
            'attributes' => $attributes,
        ], __DIR__);
    }
}
