<?php

namespace DevinciIT\Modulr\Components\UI\ActionMenu;

use DevinciIT\Modulr\Components\ComponentsBase;

class ActionMenu extends ComponentsBase
{
    /**
     * @var array<int, array{name: string, path: string, icon: string|null, target: string|null, rel: string|null, attributes: array<string, string>}>
     */
    protected array $actions = [];

    protected string $linkClass = 'modulr-action-menu__link';

    protected string $iconClass = 'modulr-action-menu__icon';

    protected string $size = 'md';

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    public function __construct(array $options = [])
    {
        if (isset($options['actions']) && is_array($options['actions'])) {
            $this->setActions($options['actions']);
        }

        if (isset($options['class']) && is_string($options['class'])) {
            $this->setClass($options['class']);
        }

        if (isset($options['id']) && is_string($options['id'])) {
            $this->setId($options['id']);
        }

        if (isset($options['size']) && is_string($options['size'])) {
            $this->setSize($options['size']);
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    /**
     * @param array<int, array<string, mixed>> $actions
     */
    public function setActions(array $actions): static
    {
        $this->actions = [];

        foreach ($actions as $action) {
            if (!is_array($action)) {
                continue;
            }

            $name = (string) ($action['name'] ?? '');
            $path = (string) ($action['path'] ?? '#');
            $icon = isset($action['icon']) && $action['icon'] !== '' ? (string) $action['icon'] : null;
            $target = isset($action['target']) && $action['target'] !== '' ? (string) $action['target'] : null;
            $rel = isset($action['rel']) && $action['rel'] !== '' ? (string) $action['rel'] : null;

            $attributes = [];
            if (isset($action['attributes']) && is_array($action['attributes'])) {
                foreach ($action['attributes'] as $key => $value) {
                    if (!is_string($key) || $key === '' || !is_scalar($value)) {
                        continue;
                    }

                    $attributes[$key] = (string) $value;
                }
            }

            if ($name === '') {
                continue;
            }

            $this->actions[] = [
                'name' => $name,
                'path' => $path,
                'icon' => $icon,
                'target' => $target,
                'rel' => $rel,
                'attributes' => $attributes,
            ];
        }

        return $this;
    }

    public function addAction(string $name, string $path, ?string $icon = null, array $attributes = []): static
    {
        $this->actions[] = [
            'name' => trim($name),
            'path' => trim($path),
            'icon' => $icon !== null && trim($icon) !== '' ? trim($icon) : null,
            'target' => null,
            'rel' => null,
            'attributes' => $this->sanitizeActionAttributes($attributes),
        ];

        return $this;
    }

    public function setSize(string $size): static
    {
        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException("Invalid action menu size: {$size}");
        }

        $this->size = $size;

        return $this;
    }

    public function render(): string
    {
        return $this->renderComponentView([
            'actions' => $this->actions,
            'linkClass' => $this->linkClass,
            'iconClass' => $this->iconClass,
            'size' => $this->size,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-action-menu',
                'data-component' => 'action-menu',
                'data-size' => $this->size,
            ]),
        ], __DIR__);
    }

    /**
     * @param array<string, mixed> $attributes
     * @return array<string, string>
     */
    protected function sanitizeActionAttributes(array $attributes): array
    {
        $sanitized = [];

        foreach ($attributes as $key => $value) {
            if (!is_string($key) || $key === '' || !is_scalar($value)) {
                continue;
            }

            $sanitized[$key] = (string) $value;
        }

        return $sanitized;
    }
}