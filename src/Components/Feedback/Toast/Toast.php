<?php

namespace DevinciIT\Modulr\Components\Feedback\Toast;

use DevinciIT\Modulr\Components\ComponentsBase;

class Toast extends ComponentsBase
{
    protected string $tone = 'neutral';

    protected string $size = 'md';

    protected ?string $title = null;

    protected string $message = '';

    protected bool $open = true;

    protected bool $dismissible = true;

    protected int $autoHideMs = 0;

    protected bool $allowHtml = false;

    protected string $position = 'top-right';

    protected ?string $actionLabel = null;

    protected ?string $actionHref = null;

    protected ?string $actionTarget = null;

    protected ?string $actionRel = null;

    /**
     * @var array<int, string>
     */
    protected array $allowedTones = ['neutral', 'info', 'warning', 'error', 'success', 'debug', 'alert', 'default'];

    /**
     * @var array<int, string>
     */
    protected array $allowedSizes = ['sm', 'md', 'lg'];

    /**
     * @var array<int, string>
     */
    protected array $allowedPositions = ['top-right', 'top-left', 'bottom-right', 'bottom-left'];

    public function __construct(array $options = [])
    {
        if (isset($options['tone']) && is_scalar($options['tone'])) {
            $this->setTone((string) $options['tone']);
        }

        if (isset($options['size']) && is_scalar($options['size'])) {
            $this->setSize((string) $options['size']);
        }

        if (isset($options['title']) && is_scalar($options['title'])) {
            $this->setTitle((string) $options['title']);
        }

        if (isset($options['message']) && is_scalar($options['message'])) {
            $this->setMessage((string) $options['message']);
        }

        if (isset($options['open'])) {
            $this->setOpen((bool) $options['open']);
        }

        if (isset($options['dismissible'])) {
            $this->setDismissible((bool) $options['dismissible']);
        }

        if (isset($options['autoHideMs'])) {
            $this->setAutoHideMs((int) $options['autoHideMs']);
        }

        if (isset($options['autoCloseMs'])) {
            $this->setAutoCloseMs((int) $options['autoCloseMs']);
        }

        if (isset($options['allowHtml'])) {
            $this->allowHtml((bool) $options['allowHtml']);
        }

        if (isset($options['position']) && is_scalar($options['position'])) {
            $this->setPosition((string) $options['position']);
        }

        if (isset($options['actionLabel']) && is_scalar($options['actionLabel'])) {
            $this->setActionLabel((string) $options['actionLabel']);
        }

        if (isset($options['actionHref']) && is_scalar($options['actionHref'])) {
            $this->setActionHref((string) $options['actionHref']);
        }

        if (isset($options['actionTarget']) && is_scalar($options['actionTarget'])) {
            $this->setActionTarget((string) $options['actionTarget']);
        }

        if (isset($options['actionRel']) && is_scalar($options['actionRel'])) {
            $this->setActionRel((string) $options['actionRel']);
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
            throw new \InvalidArgumentException(sprintf('Invalid toast tone: %s', $tone));
        }

        $this->tone = $tone;

        return $this;
    }

    public function setSize(string $size): static
    {
        $size = strtolower(trim($size));

        if (!in_array($size, $this->allowedSizes, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid toast size: %s', $size));
        }

        $this->size = $size;

        return $this;
    }

    public function setTitle(?string $title): static
    {
        $title = $title !== null ? trim($title) : '';
        $this->title = $title !== '' ? $title : null;

        return $this;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function setOpen(bool $open = true): static
    {
        $this->open = $open;

        return $this;
    }

    public function setDismissible(bool $dismissible = true): static
    {
        $this->dismissible = $dismissible;

        return $this;
    }

    public function setAutoHideMs(int $autoHideMs): static
    {
        $this->autoHideMs = max(0, $autoHideMs);

        return $this;
    }

    public function setAutoCloseMs(int $autoCloseMs): static
    {
        return $this->setAutoHideMs($autoCloseMs);
    }

    public function allowHtml(bool $allowHtml = true): static
    {
        $this->allowHtml = $allowHtml;

        return $this;
    }

    public function setPosition(string $position): static
    {
        $position = strtolower(trim($position));

        if (!in_array($position, $this->allowedPositions, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid toast position: %s', $position));
        }

        $this->position = $position;

        return $this;
    }

    public function setActionLabel(?string $actionLabel): static
    {
        $actionLabel = $actionLabel !== null ? trim($actionLabel) : '';
        $this->actionLabel = $actionLabel !== '' ? $actionLabel : null;

        return $this;
    }

    public function setActionHref(?string $actionHref): static
    {
        $actionHref = $actionHref !== null ? trim($actionHref) : '';
        $this->actionHref = $actionHref !== '' ? $actionHref : null;

        return $this;
    }

    public function setActionTarget(?string $actionTarget): static
    {
        $actionTarget = $actionTarget !== null ? trim($actionTarget) : '';
        $this->actionTarget = $actionTarget !== '' ? $actionTarget : null;

        return $this;
    }

    public function setActionRel(?string $actionRel): static
    {
        $actionRel = $actionRel !== null ? trim($actionRel) : '';
        $this->actionRel = $actionRel !== '' ? $actionRel : null;

        return $this;
    }

    public function render(): string
    {
        $toastId = $this->componentId !== null && $this->componentId !== ''
            ? $this->componentId
            : 'modulr-toast-' . substr(md5(uniqid((string) mt_rand(), true)), 0, 8);

        return $this->renderComponentView([
            'toastId' => $toastId,
            'title' => $this->title,
            'message' => $this->message,
            'dismissible' => $this->dismissible,
            'allowHtml' => $this->allowHtml,
            'actionLabel' => $this->actionLabel,
            'actionHref' => $this->actionHref,
            'actionTarget' => $this->actionTarget,
            'actionRel' => $this->actionRel,
            'attributes' => $this->mergeBaseAttributes([
                'id' => $toastId,
                'class' => 'modulr-toast modulr-toast--' . $this->tone . ' modulr-toast--' . $this->size . ' modulr-toast--' . $this->position . ($this->open ? ' is-open' : ''),
                'data-component' => 'toast',
                'data-auto-hide' => (string) $this->autoHideMs,
                'data-auto-close-ms' => (string) $this->autoHideMs,
                'data-toast-position' => $this->position,
                'role' => $this->tone === 'error' || $this->tone === 'alert' ? 'alert' : 'status',
                'aria-live' => $this->tone === 'error' || $this->tone === 'alert' ? 'assertive' : 'polite',
                'aria-hidden' => $this->open ? 'false' : 'true',
            ]),
        ], __DIR__);
    }
}