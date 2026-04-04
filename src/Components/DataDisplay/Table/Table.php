<?php
/**
 * Class Table
 *
 * Component for displaying tabular data.
 */
namespace DevinciIT\Modulr\Components\DataDisplay\Table;

use DevinciIT\Modulr\Components\ComponentsBase;

class Table extends ComponentsBase
{
    /**
     * @var array
     */
    protected array $headers = [];

    /**
     * @var array
     */
    protected array $rows = [];

    /**
     * @var string|null Custom style path
     */
    protected ?string $stylePath = null;

    /**
     * @var string|null Custom script path
     */
    protected ?string $scriptPath = null;

    /**
     * @var string|null Custom config path
     */
    protected ?string $configPath = null;

    /**
     * Table constructor.
     *
     * @param array $headers
     * @param array $rows
     * @param string|null $stylePath
     * @param string|null $scriptPath
     * @param string|null $configPath
     */
    public function __construct(
        array $headers = [],
        array $rows = [],
        ?string $stylePath = null,
        ?string $scriptPath = null,
        ?string $configPath = null
    ) {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->stylePath = $stylePath;
        $this->scriptPath = $scriptPath;
        $this->configPath = $configPath;
    }

    public static function make(
        array $headers = [],
        array $rows = [],
        ?string $stylePath = null,
        ?string $scriptPath = null,
        ?string $configPath = null
    ): static {
        return new static($headers, $rows, $stylePath, $scriptPath, $configPath);
    }

    /**
     * Render the table component.
     *
     * @return string
     */
    public function render(): string
    {
        $defaultDir = __DIR__;
        $assets = [
            'css' => $this->stylePath ?? null,
            'js'  => $this->scriptPath ?? null,
        ];
        return $this->renderComponentView([
            'headers' => $this->headers,
            'rows' => $this->rows,
            '_assets' => $assets,
        ], $defaultDir);
    }
}
