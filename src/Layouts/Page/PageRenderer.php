<?php

namespace DevinciIT\Modulr\Layouts\Page;

use DevinciIT\Modulr\Assets\AssetManager;

class PageRenderer
{
    protected ?string $layoutCss = null;

    public function __construct(protected AssetManager $assets)
    {
    }

    public function render(Page $page, array $attributes = []): string
    {
        $this->registerAssets();

        if ($page->getViewFile() !== null) {
            return $this->renderViewFile($page, $attributes);
        }

        return $this->renderSlots($page, $attributes);
    }

    protected function registerAssets(): void
    {
        $css = $this->loadLayoutCss();

        if ($css === '') {
            return;
        }

        if (method_exists($this->assets, 'addInlineStyleOnce')) {
            $this->assets->addInlineStyleOnce('layouts/page/style.css', $css);
            return;
        }

        $this->assets->addInlineStyle($css);
    }

    protected function loadLayoutCss(): string
    {
        if ($this->layoutCss !== null) {
            return $this->layoutCss;
        }

        $file = __DIR__ . '/style.css';
        if (!is_file($file)) {
            $this->layoutCss = '';
            return $this->layoutCss;
        }

        $css = file_get_contents($file);
        $this->layoutCss = is_string($css) ? $css : '';

        return $this->layoutCss;
    }

    protected function renderSlots(Page $page, array $attributes = []): string
    {
        $slots = $page->getSlots();
        $sections = $page->getSections();
        $attributes['class'] = trim(($attributes['class'] ?? '') . ' ' . $page->getPageClass());

        $html = '<main' . $this->renderAttributes($this->sanitizeAttributes($attributes)) . '>';

        foreach ($this->buildRenderOrder($page) as $name) {
            if (!array_key_exists($name, $slots)) {
                continue;
            }

            $section = $sections[$name] ?? ['tag' => 'section', 'attributes' => []];
            $slotClass = 'modulr-page-slot modulr-page-slot--' . $this->slug($name);
            $sectionAttributes = $section['attributes'];
            $sectionAttributes['class'] = trim(($sectionAttributes['class'] ?? '') . ' ' . $slotClass);

            $html .= '<' . $section['tag'] . $this->renderAttributes($sectionAttributes) . '>';
            $html .= $slots[$name];
            $html .= '</' . $section['tag'] . '>';
        }

        $html .= '</main>';

        return $html;
    }

    protected function renderViewFile(Page $page, array $attributes = []): string
    {
        $attributes['class'] = trim(($attributes['class'] ?? '') . ' ' . $page->getPageClass());

        $viewFile = $page->getViewFile();
        if ($viewFile === null || !is_file($viewFile)) {
            return $this->renderSlots($page, $attributes);
        }

        $slots = $page->getSlots();
        $sections = $page->getSections();
        $sectionOrder = $page->getSectionOrder();
        $layoutType = $page->getLayoutType();

        extract($page->getViewData(), EXTR_SKIP);
        extract([
            'page' => $page,
            'slots' => $slots,
            'sections' => $sections,
            'sectionOrder' => $sectionOrder,
            'layoutType' => $layoutType,
            'attributes' => $attributes,
        ], EXTR_SKIP);

        ob_start();
        include $viewFile;

        return (string) ob_get_clean();
    }

    /**
     * @return string[]
     */
    protected function buildRenderOrder(Page $page): array
    {
        $order = $page->getSectionOrder();

        foreach (array_keys($page->getSlots()) as $slotName) {
            if (!in_array($slotName, $order, true)) {
                $order[] = $slotName;
            }
        }

        return $order;
    }

    /**
     * @param array<string, string> $attributes
     */
    protected function renderAttributes(array $attributes): string
    {
        if ($attributes === []) {
            return '';
        }

        $pairs = [];
        foreach ($attributes as $key => $value) {
            $pairs[] = sprintf(
                '%s="%s"',
                htmlspecialchars($key, ENT_QUOTES),
                htmlspecialchars($value, ENT_QUOTES)
            );
        }

        return ' ' . implode(' ', $pairs);
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

    protected function slug(string $name): string
    {
        $name = strtolower(trim($name));
        $name = preg_replace('/[^a-z0-9]+/', '-', $name) ?? '';

        return trim($name, '-') ?: 'section';
    }
}