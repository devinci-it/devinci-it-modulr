<?php
namespace DevinciIT\Modulr\Components\UI\Icon;

use DevinciIT\Modulr\Components\ComponentsBase;

class Icon extends ComponentsBase
{
    protected array $props = [
        'name' => '',
        'svg' => '',
        'svgPath' => '',
        'size' => 'md',
        'color' => '',
        'label' => null,
        'decorative' => true,
    ];

    protected array $allowedSizes = ['xs', 'sm', 'md', 'lg', 'xl'];

    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            if (array_key_exists($key, $this->props)) {
                $this->props[$key] = $value;
            }
        }
    }

    /**
     * @param array|string $options
     */
    public static function make($options = []): static
    {
        if (is_string($options)) {
            $trimmed = trim($options);

            if ($trimmed !== '' && str_starts_with($trimmed, '<')) {
                return (new static())->setSvg($options);
            }

            if ($trimmed !== '' && preg_match('/\.svg(\?.*)?$/i', $trimmed)) {
                return (new static())->setSvgPath($options);
            }

            return (new static())->setName($options);
        }

        return new static($options);
    }

    public function setName(string $name): static
    {
        $this->props['name'] = $name;
        return $this;
    }

    public function setSvg(string $svg): static
    {
        $this->props['svg'] = $svg;
        $this->props['svgPath'] = '';
        return $this;
    }

    public function setSvgPath(string $path): static
    {
        $this->props['svgPath'] = $path;
        $this->props['svg'] = '';
        return $this;
    }

    public function setSize(string $size): static
    {
        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException("Invalid icon size: {$size}");
        }

        $this->props['size'] = $size;
        return $this;
    }

    public function setColor(string $color): static
    {
        $this->props['color'] = $color;
        return $this;
    }

    public function setLabel(?string $label): static
    {
        $this->props['label'] = $label;
        return $this;
    }

    public function setDecorative(bool $state = true): static
    {
        $this->props['decorative'] = $state;
        return $this;
    }

    public function render(): string
    {
        $props = $this->props;

        if (empty($props['svg']) && !empty($props['svgPath'])) {
            $content = @file_get_contents($props['svgPath']);
            if ($content !== false) {
                $props['svg'] = $content;
            }
        }

        return $this->renderComponentView($props, __DIR__);
    }
}