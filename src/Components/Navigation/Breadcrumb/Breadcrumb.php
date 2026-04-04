<?php

namespace DevinciIT\Modulr\Components\Navigation\Breadcrumb;

use DevinciIT\Modulr\Components\ComponentsBase;

class Breadcrumb extends ComponentsBase
{
    protected array $items = [];
    protected string $separator = '/';

    protected bool $truncated = false;
    protected int $maxVisible = 4;
    protected string $truncateMode = 'middle';
    protected string $ellipsisLabel = '...';

    public function __construct(array $items = [], array $options = [])
    {
        $this->items = $items;

        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public static function make(array $items = [], array $options = []): static
    {
        return new static($items, $options);
    }

    public function setItems(array $items): static
    {
        $this->items = $items;
        return $this;
    }

    public function addItem(array $item): static
    {
        $this->items[] = $item;
        return $this;
    }

    public function setSeparator(string $separator): static
    {
        $this->separator = $separator;
        return $this;
    }

    public function setTruncated(bool $state = true): static
    {
        $this->truncated = $state;
        return $this;
    }

    public function setMaxVisible(int $maxVisible): static
    {
        $this->maxVisible = $maxVisible;
        return $this;
    }

    public function setTruncateMode(string $mode): static
    {
        $this->truncateMode = $mode;
        return $this;
    }

    public function setEllipsisLabel(string $label): static
    {
        $this->ellipsisLabel = $label;
        return $this;
    }

    public function render(): string
    {
        $items = $this->normalizeItems($this->items);

        if ($this->truncated && count($items) > $this->maxVisible) {
            $items = $this->applyTruncation($items);
        }

        return $this->renderComponentView([
            'items' => $items,
            'separator' => $this->separator,
            'ellipsisLabel' => $this->ellipsisLabel,
        ], __DIR__);
    }

    protected function normalizeItems(array $items): array
    {
        $normalized = [];

        foreach ($items as $item) {
            if (empty($item['label'])) {
                continue;
            }

            $normalized[] = array_merge([
                'href' => null,
                'disabled' => false,
                'current' => false,
                'title' => null,
                'icon' => null,
                'attributes' => [],
            ], $item);
        }

        // ensure single current (last wins)
        foreach (array_reverse($normalized) as $item) {
            if (!empty($item['current'])) {
                foreach ($normalized as &$i) {
                    $i['current'] = false;
                }
                $item['current'] = true;
                break;
            }
        }

        return $normalized;
    }
protected function applyTruncation(array $items): array
{
    $count = count($items);

    if ($this->truncateMode === 'start') {
        $visible = array_slice($items, $count - ($this->maxVisible - 1));

        return array_merge(
            [
                $items[0],
                [
                    'label' => $this->ellipsisLabel,
                    'ellipsis' => true,
                    'toggle' => true
                ]
            ],
            array_map(function ($item) {
                $item['hidden'] = true;
                return $item;
            }, $visible)
        );
    }

    // middle
    $first = $items[0];
    $last = $items[$count - 1];

    $middle = array_slice($items, 1, $count - 2);

    $hiddenMiddle = array_map(function ($item) {
        $item['hidden'] = true;
        return $item;
    }, $middle);

    return [
        $first,
        [
            'label' => $this->ellipsisLabel,
            'ellipsis' => true,
            'toggle' => true
        ],
        ...$hiddenMiddle,
        $last
    ];
}
}