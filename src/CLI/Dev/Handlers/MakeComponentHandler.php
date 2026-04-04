<?php

namespace DevinciIT\Modulr\CLI\Dev\Handlers;

class MakeComponentHandler
{
    public function handle(array $argv): void
    {
        if (count($argv) < 4) {
            $this->usage();
            return;
        }

        $category = $argv[2];
        $name = $argv[3];

        $basePath = __DIR__ . "/../../../../src/Components/$category/$name";

        if (file_exists($basePath)) {
            echo "❌ Component already exists!\n";
            return;
        }

        mkdir($basePath, 0777, true);

        $this->createClass($category, $name, $basePath);
        $this->createView($name, $basePath);
        $this->createStyle($name, $basePath);
        $this->createScript($name, $basePath);
        $this->createDemo($category, $name, $basePath);

        echo "✅ Component '$name' created successfully.\n";
    }

    protected function createClass(string $category, string $name, string $basePath): void
    {
        $content = <<<PHP
<?php

namespace DevinciIT\\Modulr\\Components\\$category\\$name;

use DevinciIT\\Modulr\\Components\\ComponentsBase;

class $name extends ComponentsBase
{
    public function __construct(array \$options = [])
    {
    }

    public function render(): string
    {
        return \$this->renderComponentView([
        ], __DIR__);
    }
}
PHP;

        file_put_contents("$basePath/$name.php", $content);
    }

    protected function createView(string $name, string $basePath): void
    {
        file_put_contents(
            "$basePath/view.php",
            <<<PHP
<?php ?>

<div class="modulr-$name">
    <!-- $name component -->
</div>
PHP
        );
    }

    protected function createStyle(string $name, string $basePath): void
    {
        file_put_contents(
            "$basePath/style.css",
            ".modulr-$name {}\n"
        );
    }

    protected function createScript(string $name, string $basePath): void
    {
        file_put_contents(
            "$basePath/script.js",
            "// $name JS\n"
        );
    }

    protected function createDemo(string $category, string $name, string $basePath): void
    {
        file_put_contents(
            "$basePath/demo.php",
            <<<PHP
<?php

use DevinciIT\\Modulr\\Components\\$category\\$name\\$name;

\$component = new $name([]);

echo \$component->render();
PHP
        );
    }

    protected function usage(): void
    {
        echo "Usage: php modulr-dev.php make:component {Category} {Name}\n";
    }
}