<?php

namespace DevinciIT\Modulr\Layouts\Page;

class Page
{
    protected const LAYOUT_CLASS_MAP = [
        '2-column' => 'two-column',
        'two-column' => 'two-column',
        'split-screen' => 'split',
        'split' => 'split',
        'stacked' => '',
        'grid' => 'grid',
    ];

    /**
     * Slot content keyed by section name.
     *
     * @var array<string, string>
     */
    protected array $slots = [];

    /**
     * Optional section metadata (tag + attributes) keyed by section name.
     *
     * @var array<string, array{tag: string, attributes: array<string, string>}>
     */
    protected array $sections = [];

    /**
     * Rendering order for declared sections.
     *
     * @var string[]
     */
    protected array $sectionOrder = [];

    protected string $layoutType = 'stacked';

    protected ?string $viewFile = null;

    protected array $viewData = [];

    public function __construct(string $layoutType = 'stacked')
    {
        $this->setLayoutType($layoutType);
    }

    public static function make(string $layoutType = 'stacked'): static
    {
        return new static($layoutType);
    }

    public function view(string $filePath, array $data = []): static
    {
        $this->viewFile = $filePath;
        $this->viewData = $data;

        return $this;
    }

    public function viewPath(string $filePath, array $data = []): static
    {
        return $this->view($filePath, $data);
    }

    public function setViewFile(string $filePath, array $data = []): static
    {
        return $this->view($filePath, $data);
    }

    public function clearView(): static
    {
        $this->viewFile = null;
        $this->viewData = [];

        return $this;
    }

    public function setLayoutType(string $layoutType): static
    {
        $normalized = strtolower(trim($layoutType));

        if (!array_key_exists($normalized, self::LAYOUT_CLASS_MAP)) {
            $normalized = 'stacked';
        }

        $this->layoutType = $normalized;

        return $this;
    }

    public function slot(string $name, string $content): static
    {
        $this->slots[$name] = $content;

        return $this;
    }

    /**
     * @param array<string, string> $slots
     */
    public function setSlots(array $slots): static
    {
        foreach ($slots as $name => $content) {
            $this->slot((string) $name, (string) $content);
        }

        return $this;
    }

    public function defineSection(string $name, string $tag = 'section', array $attributes = []): static
    {
        if (!in_array($name, $this->sectionOrder, true)) {
            $this->sectionOrder[] = $name;
        }

        $this->sections[$name] = [
            'tag' => $this->sanitizeTag($tag),
            'attributes' => $this->sanitizeAttributes($attributes),
        ];

        return $this;
    }

    public function render(array $attributes = []): string
    {
        return app(PageRenderer::class)->render($this, $attributes);
    }

    /**
     * @param array<string, mixed> $attributes
     * @return array<string, string>
     */
    protected function sanitizeAttributes(array $attributes): array
    {
        $sanitized = [];

        foreach ($attributes as $key => $value) {
            if (!is_string($key) || $key === '') {
                continue;
            }

            if (!is_scalar($value)) {
                continue;
            }

            $sanitized[$key] = (string) $value;
        }

        return $sanitized;
    }

    protected function sanitizeTag(string $tag): string
    {
        $tag = strtolower(trim($tag));

        if ($tag === '' || !preg_match('/^[a-z][a-z0-9-]*$/', $tag)) {
            return 'section';
        }

        return $tag;
    }

    public function getLayoutType(): string
    {
        return $this->layoutType;
    }

    /**
     * @return array<string, string>
     */
    public function getSlots(): array
    {
        return $this->slots;
    }

    /**
     * @return array<string, array{tag: string, attributes: array<string, string>}>
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @return string[]
     */
    public function getSectionOrder(): array
    {
        return $this->sectionOrder;
    }

    public function getViewFile(): ?string
    {
        return $this->viewFile;
    }

    /**
     * @return array<string, mixed>
     */
    public function getViewData(): array
    {
        return $this->viewData;
    }

    public function getLayoutClass(): string
    {
        return self::LAYOUT_CLASS_MAP[$this->layoutType] ?? '';
    }

    public function getPageClass(): string
    {
        $layoutClass = $this->getLayoutClass();

        return trim('modulr-page' . ($layoutClass !== '' ? ' modulr-page--' . $layoutClass : ''));
    }
}
