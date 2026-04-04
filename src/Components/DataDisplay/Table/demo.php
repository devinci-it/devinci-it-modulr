<?php

use DevinciIT\Modulr\Components\DataDisplay\Table\Table;

// Demo data
$headers = ['Name', 'Email', 'Role'];
$rows = [
    ['Alice', 'alice@example.com', 'Admin'],
    ['Bob', 'bob@example.com', 'User'],
    ['Charlie', 'charlie@example.com', 'Editor'],
];

showDemo(
    'Table Component Demo',
    'Render a basic data table with optional component-scoped CSS and JS.',
    <<<'CODE'
use DevinciIT\Modulr\Components\DataDisplay\Table\Table;

$headers = ['Name', 'Email', 'Role'];
$rows = [
    ['Alice', 'alice@example.com', 'Admin'],
    ['Bob', 'bob@example.com', 'User'],
    ['Charlie', 'charlie@example.com', 'Editor'],
];

$table = new Table($headers, $rows);

$table->addCss(<<<CSS
body {
    font-family: system-ui, sans-serif;
}
CSS);

$table->addJs(<<<JS
console.log('Table component loaded');
JS);

echo $table->render();
CODE,
    function () use ($headers, $rows) {
        $table = new Table($headers, $rows);

        $table->addCss(<<<CSS
body {
    font-family: system-ui, sans-serif;
}
CSS);

        $table->addJs(<<<JS
console.log('Table component loaded');
JS);

        echo $table->render();
    }
);
