<?php

namespace DevinciIT\Modulr\Components\Feedback\Modal;

use DevinciIT\Modulr\Components\ComponentsBase;

class Modal extends ComponentsBase
{
    protected string $tone = 'info';

    /**
     * Interaction mode:
     * - alert: dismiss-only action
     * - confirm: single confirm action
     * - confirm-cancel: confirm + cancel actions
     */
    protected string $mode = 'alert';

    protected ?string $header = null;

    protected string $body = '';

    protected ?string $footer = null;

    protected bool $open = false;

    protected bool $allowHtml = false;

    protected bool $dismissOnBackdrop = true;

    protected bool $dismissOnEsc = true;

    protected string $closeLabel = 'Close';

    protected string $confirmLabel = 'Confirm';

    protected string $cancelLabel = 'Cancel';

    /**
     * @var array<int, array<string, mixed>>
     */
    protected array $actions = [];

    /**
     * @var array<int, string>
     */
    protected array $allowedTones = ['default', 'alert', 'error', 'info', 'warning', 'success'];

    /**
     * @var array<int, string>
     */
    protected array $allowedModes = ['alert', 'confirm', 'confirm-cancel'];

    public function __construct(array $options = [])
    {
        if (isset($options['tone']) && is_scalar($options['tone'])) {
            $this->setTone((string) $options['tone']);
        }

        if (isset($options['mode']) && is_scalar($options['mode'])) {
            $this->setMode((string) $options['mode']);
        }

        if (isset($options['header']) && is_scalar($options['header'])) {
            $this->setHeader((string) $options['header']);
        }

        if (isset($options['body']) && is_scalar($options['body'])) {
            $this->setBody((string) $options['body']);
        }

        if (isset($options['footer']) && is_scalar($options['footer'])) {
            $this->setFooter((string) $options['footer']);
        }

        if (isset($options['open'])) {
            $this->setOpen((bool) $options['open']);
        }

        if (isset($options['allowHtml'])) {
            $this->allowHtml((bool) $options['allowHtml']);
        }

        if (isset($options['dismissOnBackdrop'])) {
            $this->setDismissOnBackdrop((bool) $options['dismissOnBackdrop']);
        }

        if (isset($options['dismissOnEsc'])) {
            $this->setDismissOnEsc((bool) $options['dismissOnEsc']);
        }

        if (isset($options['closeLabel']) && is_scalar($options['closeLabel'])) {
            $this->setCloseLabel((string) $options['closeLabel']);
        }

        if (isset($options['confirmLabel']) && is_scalar($options['confirmLabel'])) {
            $this->setConfirmLabel((string) $options['confirmLabel']);
        }

        if (isset($options['cancelLabel']) && is_scalar($options['cancelLabel'])) {
            $this->setCancelLabel((string) $options['cancelLabel']);
        }

        if (isset($options['actions']) && is_array($options['actions'])) {
            $this->setActions($options['actions']);
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

    public function setTone(string $tone): static
    {
        $tone = strtolower(trim($tone));

        if (!in_array($tone, $this->allowedTones, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid modal tone: %s', $tone));
        }

        $this->tone = $tone;

        return $this;
    }

    public function setMode(string $mode): static
    {
        $mode = strtolower(trim($mode));

        if (!in_array($mode, $this->allowedModes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid modal mode: %s', $mode));
        }

        $this->mode = $mode;

        return $this;
    }

    public function setHeader(?string $header): static
    {
        $header = $header !== null ? trim($header) : '';
        $this->header = $header !== '' ? $header : null;

        return $this;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function setFooter(?string $footer): static
    {
        $footer = $footer !== null ? trim($footer) : '';
        $this->footer = $footer !== '' ? $footer : null;

        return $this;
    }

    public function setOpen(bool $open = true): static
    {
        $this->open = $open;

        return $this;
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function setDismissOnBackdrop(bool $dismissOnBackdrop = true): static
    {
        $this->dismissOnBackdrop = $dismissOnBackdrop;

        return $this;
    }

    public function setDismissOnEsc(bool $dismissOnEsc = true): static
    {
        $this->dismissOnEsc = $dismissOnEsc;

        return $this;
    }

    public function setCloseLabel(string $closeLabel): static
    {
        $closeLabel = trim($closeLabel);

        if ($closeLabel !== '') {
            $this->closeLabel = $closeLabel;
        }

        return $this;
    }

    public function setConfirmLabel(string $confirmLabel): static
    {
        $confirmLabel = trim($confirmLabel);

        if ($confirmLabel !== '') {
            $this->confirmLabel = $confirmLabel;
        }

        return $this;
    }

    public function setCancelLabel(string $cancelLabel): static
    {
        $cancelLabel = trim($cancelLabel);

        if ($cancelLabel !== '') {
            $this->cancelLabel = $cancelLabel;
        }

        return $this;
    }

    /**
     * @param array<int, array<string, mixed>> $actions
     */
    public function setActions(array $actions): static
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * @param array<string, mixed> $action
     */
    public function addAction(array $action): static
    {
        $this->actions[] = $action;

        return $this;
    }

    public function render(): string
    {
        $modalId = $this->componentId !== null && $this->componentId !== ''
            ? $this->componentId
            : 'modulr-modal-' . substr(md5(uniqid((string) mt_rand(), true)), 0, 8);

        $actions = $this->resolveActions();

        return $this->renderComponentView([
            'modalId' => $modalId,
            'header' => $this->header,
            'body' => $this->body,
            'footer' => $this->footer,
            'actions' => $actions,
            'allowHtml' => $this->allowHtml,
            'attributes' => $this->mergeBaseAttributes([
                'id' => $modalId,
                'class' => 'modulr-modal modulr-modal--' . $this->tone . ($this->open ? ' is-open' : ''),
                'data-component' => 'modal',
                'data-dismiss-backdrop' => $this->dismissOnBackdrop ? 'true' : 'false',
                'data-dismiss-esc' => $this->dismissOnEsc ? 'true' : 'false',
                'aria-hidden' => $this->open ? 'false' : 'true',
            ]),
        ], __DIR__);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function resolveActions(): array
    {
        if (!empty($this->actions)) {
            return $this->normalizeActions($this->actions);
        }

        if ($this->mode === 'confirm') {
            return $this->normalizeActions([
                ['label' => $this->confirmLabel, 'variant' => 'primary', 'action' => 'confirm', 'dismiss' => true],
            ]);
        }

        if ($this->mode === 'confirm-cancel') {
            return $this->normalizeActions([
                ['label' => $this->cancelLabel, 'variant' => 'secondary', 'action' => 'cancel', 'dismiss' => true],
                ['label' => $this->confirmLabel, 'variant' => 'primary', 'action' => 'confirm', 'dismiss' => true],
            ]);
        }

        return $this->normalizeActions([
            ['label' => $this->closeLabel, 'variant' => 'primary', 'action' => 'close', 'dismiss' => true],
        ]);
    }

    /**
     * @param array<int, array<string, mixed>> $actions
     * @return array<int, array<string, mixed>>
     */
    protected function normalizeActions(array $actions): array
    {
        $normalized = [];

        foreach ($actions as $action) {
            if (!is_array($action)) {
                continue;
            }

            $label = isset($action['label']) && is_scalar($action['label'])
                ? trim((string) $action['label'])
                : '';

            if ($label === '') {
                continue;
            }

            $variant = isset($action['variant']) && is_scalar($action['variant'])
                ? strtolower(trim((string) $action['variant']))
                : 'secondary';

            if ($variant === '') {
                $variant = 'secondary';
            }

            $normalized[] = [
                'label' => $label,
                'variant' => preg_replace('/[^a-z0-9_-]/i', '', $variant) ?: 'secondary',
                'action' => isset($action['action']) && is_scalar($action['action'])
                    ? (string) $action['action']
                    : '',
                'dismiss' => (bool) ($action['dismiss'] ?? true),
                'attributes' => $this->sanitizeAttributes($action['attributes'] ?? []),
            ];
        }

        return $normalized;
    }

    /**
     * @param mixed $attributes
     * @return array<string, string>
     */
    protected function sanitizeAttributes($attributes): array
    {
        if (!is_array($attributes)) {
            return [];
        }

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
