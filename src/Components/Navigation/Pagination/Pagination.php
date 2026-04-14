<?php

namespace DevinciIT\Modulr\Components\Navigation\Pagination;

use DevinciIT\Modulr\Components\ComponentsBase;

class Pagination extends ComponentsBase
{
    protected string $size = 'md';

    protected array $allowedSizes = ['sm', 'md', 'lg'];

    protected string $variant = 'default';

    protected array $allowedVariants = ['default', 'ghost'];

    protected int $currentPage = 1;

    protected int $totalPages = 1;

    protected int $window = 1;

    protected string $baseUrl = '/';

    protected string $pageParam = 'page';

    protected string $ariaLabel = 'Pagination';

    protected bool $showFirstLast = true;

    protected bool $showPrevNext = true;

    protected ?string $target = null;

    protected ?string $rel = null;

    protected bool $allowHtml = false;

    public function __construct(array $options = [])
    {
        if (isset($options['currentPage'])) {
            $this->setCurrentPage((int) $options['currentPage']);
        }

        if (isset($options['totalPages'])) {
            $this->setTotalPages((int) $options['totalPages']);
        }

        if (isset($options['window'])) {
            $this->setWindow((int) $options['window']);
        }

        if (isset($options['size']) && is_scalar($options['size'])) {
            $this->setSize((string) $options['size']);
        }

        if (isset($options['variant']) && is_scalar($options['variant'])) {
            $this->setVariant((string) $options['variant']);
        }

        if (isset($options['baseUrl']) && is_scalar($options['baseUrl'])) {
            $this->setBaseUrl((string) $options['baseUrl']);
        }

        if (isset($options['pageParam']) && is_scalar($options['pageParam'])) {
            $this->setPageParam((string) $options['pageParam']);
        }

        if (isset($options['ariaLabel']) && is_scalar($options['ariaLabel'])) {
            $this->setAriaLabel((string) $options['ariaLabel']);
        }

        if (isset($options['showFirstLast'])) {
            $this->setShowFirstLast((bool) $options['showFirstLast']);
        }

        if (isset($options['showPrevNext'])) {
            $this->setShowPrevNext((bool) $options['showPrevNext']);
        }

        if (isset($options['target']) && is_scalar($options['target'])) {
            $this->setTarget((string) $options['target']);
        }

        if (isset($options['rel']) && is_scalar($options['rel'])) {
            $this->setRel((string) $options['rel']);
        }

        if (isset($options['allowHtml'])) {
            $this->allowHtml((bool) $options['allowHtml']);
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

    public function setCurrentPage(int $currentPage): static
    {
        $this->currentPage = max(1, $currentPage);

        return $this;
    }

    public function setTotalPages(int $totalPages): static
    {
        $this->totalPages = max(1, $totalPages);

        return $this;
    }

    public function setWindow(int $window): static
    {
        $this->window = max(0, $window);

        return $this;
    }

    public function setSize(string $size): static
    {
        $size = trim($size);

        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid pagination size: %s', $size));
        }

        $this->size = $size;

        return $this;
    }

    public function setVariant(string $variant): static
    {
        $variant = trim($variant);

        if (!in_array($variant, $this->allowedVariants, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid pagination variant: %s', $variant));
        }

        $this->variant = $variant;

        return $this;
    }

    public function setBaseUrl(string $baseUrl): static
    {
        $baseUrl = trim($baseUrl);
        $this->baseUrl = $baseUrl !== '' ? $baseUrl : '/';

        return $this;
    }

    public function setPageParam(string $pageParam): static
    {
        $pageParam = trim($pageParam);

        if ($pageParam === '') {
            throw new \InvalidArgumentException('Pagination page parameter cannot be empty.');
        }

        $this->pageParam = $pageParam;

        return $this;
    }

    public function setAriaLabel(string $ariaLabel): static
    {
        $ariaLabel = trim($ariaLabel);

        if ($ariaLabel !== '') {
            $this->ariaLabel = $ariaLabel;
        }

        return $this;
    }

    public function setShowFirstLast(bool $show = true): static
    {
        $this->showFirstLast = $show;

        return $this;
    }

    public function setShowPrevNext(bool $show = true): static
    {
        $this->showPrevNext = $show;

        return $this;
    }

    public function setTarget(?string $target): static
    {
        $target = $target !== null ? trim($target) : '';
        $this->target = $target !== '' ? $target : null;

        return $this;
    }

    public function setRel(?string $rel): static
    {
        $rel = $rel !== null ? trim($rel) : '';
        $this->rel = $rel !== '' ? $rel : null;

        return $this;
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function render(): string
    {
        $totalPages = max(1, $this->totalPages);
        $currentPage = max(1, min($this->currentPage, $totalPages));

        $items = $this->buildItems($currentPage, $totalPages);

        return $this->renderComponentView([
            'items' => $items,
            'ariaLabel' => $this->ariaLabel,
            'allowHtml' => $this->allowHtml,
            'attributes' => $this->mergeBaseAttributes([
                'class' => 'modulr-pagination modulr-pagination--' . $this->size . ' modulr-pagination--' . $this->variant,
                'data-component' => 'pagination',
                'data-current-page' => (string) $currentPage,
            ]),
        ], __DIR__);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function buildItems(int $currentPage, int $totalPages): array
    {
        $items = [];

        if ($this->showFirstLast) {
            $items[] = $this->makeLinkItem('First', 1, $currentPage <= 1, false, 'first');
        }

        if ($this->showPrevNext) {
            $items[] = $this->makeLinkItem('Previous', max(1, $currentPage - 1), $currentPage <= 1, false, 'previous');
        }

        $totalPages = max(1, $totalPages);

        // Desired number of visible pages (including current)
        $visible = ($this->window * 2) + 1;

        // Default centered window
        $start = $currentPage - $this->window;
        $end = $currentPage + $this->window;

        // Shift right if near start
        if ($start < 1) {
            $end += (1 - $start);
            $start = 1;
        }

        // Shift left if near end
        if ($end > $totalPages) {
            $start -= ($end - $totalPages);
            $end = $totalPages;
        }

        // Expand to the requested visible count when the collection allows it.
        $currentVisible = $end - $start + 1;
        if ($currentVisible < $visible) {
            $missing = $visible - $currentVisible;

            $roomOnLeft = $start - 1;
            $shiftLeft = min($roomOnLeft, (int) ceil($missing / 2));
            $start -= $shiftLeft;
            $missing -= $shiftLeft;

            $roomOnRight = $totalPages - $end;
            $shiftRight = min($roomOnRight, $missing);
            $end += $shiftRight;
            $missing -= $shiftRight;

            if ($missing > 0 && $start > 1) {
                $extraLeft = min($start - 1, $missing);
                $start -= $extraLeft;
                $missing -= $extraLeft;
            }

            if ($missing > 0 && $end < $totalPages) {
                $extraRight = min($totalPages - $end, $missing);
                $end += $extraRight;
            }
        }

        // Clamp again
        $start = max(1, $start);
        $end = min($totalPages, $end);

        if ($start > 1) {
            $items[] = $this->makeLinkItem('1', 1, false, $currentPage === 1, 'page');

            if ($start > 2) {
                $items[] = [
                    'type' => 'ellipsis',
                    'label' => '...',
                ];
            }
        }

        for ($page = $start; $page <= $end; $page++) {
            $items[] = $this->makeLinkItem((string) $page, $page, false, $page === $currentPage, 'page');
        }

        if ($totalPages > 1 && $end < $totalPages) {
            if ($end < $totalPages - 1) {
                $items[] = [
                    'type' => 'ellipsis',
                    'label' => '...',
                ];
            }

            $items[] = $this->makeLinkItem((string) $totalPages, $totalPages, false, $currentPage === $totalPages, 'page');
        }

        if ($totalPages === 1 && $start === 1 && $end === 1) {
            $items[] = $this->makeLinkItem('1', 1, false, true, 'page');
        }

        if ($this->showPrevNext) {
            $items[] = $this->makeLinkItem('Next', min($totalPages, $currentPage + 1), $currentPage >= $totalPages, false, 'next');
        }

        if ($this->showFirstLast) {
            $items[] = $this->makeLinkItem('Last', $totalPages, $currentPage >= $totalPages, false, 'last');
        }

        return $items;
    }

    /**
     * @return array<string, mixed>
     */
    protected function makeLinkItem(string $label, int $page, bool $disabled, bool $current, string $kind): array
    {
        return [
            'type' => 'link',
            'kind' => $kind,
            'label' => $label,
            'page' => $page,
            'href' => $this->buildPageUrl($page),
            'current' => $current,
            'disabled' => $disabled,
            'target' => $this->target,
            'rel' => $this->rel,
        ];
    }

    protected function buildPageUrl(int $page): string
    {
        $base = $this->baseUrl;
        $fragment = '';

        $hashPos = strpos($base, '#');
        if ($hashPos !== false) {
            $fragment = substr($base, $hashPos);
            $base = substr($base, 0, $hashPos);
        }

        $separator = strpos($base, '?') === false ? '?' : '&';

        return $base
            . $separator
            . rawurlencode($this->pageParam)
            . '='
            . rawurlencode((string) $page)
            . $fragment;
    }
}
