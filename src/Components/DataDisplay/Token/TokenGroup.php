<?php
namespace DevinciIT\Modulr\Components\DataDisplay\Token;

use DevinciIT\Modulr\Components\ComponentsBase;

class TokenGroup extends ComponentsBase
{
    public function __construct(
        protected array $tokens,
        protected int $maxVisible = 5,
        protected string $counterLabel = '%d more tokens'
    ) {}

    public static function make(
        array $tokens,
        int $maxVisible = 5,
        string $counterLabel = '%d more tokens'
    ): static {
        return new static($tokens, $maxVisible, $counterLabel);
    }

    public function render(): string
    {
        return $this->renderComponentView([
            'tokens' => $this->tokens,
            'maxVisible' => $this->maxVisible,
            'counterLabel' => $this->counterLabel,
        ], __DIR__);
    }
}