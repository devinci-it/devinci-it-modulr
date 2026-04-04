<?php

use DevinciIT\Modulr\Components\Navigation\Breadcrumb\Breadcrumb;


/**
 * Example 1 — Basic Breadcrumb
 */
showDemo(
    'Basic Breadcrumb',
    'A simple linear breadcrumb trail showing the current location.',
    <<<'CODE'
echo Breadcrumb::make([
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Projects', 'href' => '/projects'],
    ['label' => 'Modulr', 'href' => '/projects/modulr'],
    ['label' => 'Breadcrumb', 'current' => true],
])->render();
CODE,
    fn() => print Breadcrumb::make([
        ['label' => 'Home', 'href' => '/'],
        ['label' => 'Projects', 'href' => '/projects'],
        ['label' => 'Modulr', 'href' => '/projects/modulr'],
        ['label' => 'Breadcrumb', 'current' => true],
    ])->render()
);


/**
 * Example 2 — With Icons + Separator
 */
showDemo(
    'With Icons + Custom Separator',
    'Uses icons and a custom separator to match branding or style guides.',
    <<<'CODE'
echo Breadcrumb::make([
    ['label' => 'Dashboard', 'href' => '/', 'icon' => '🏠'],
    ['label' => 'Users', 'href' => '/users'],
    ['label' => 'Profile', 'current' => true, 'icon' => '👤'],
], [
    'separator' => '>'
])->render();
CODE,
    fn() => print Breadcrumb::make([
        ['label' => 'Dashboard', 'href' => '/', 'icon' => '🏠 '],
        ['label' => 'Users', 'href' => '/users'],
        ['label' => 'Profile', 'current' => true, 'icon' => '👤 '],
    ], [
        'separator' => '>'
    ])->render()
);


/**
 * Example 3 — Disabled + Mixed State
 */
showDemo(
    'Disabled + Mixed States',
    'Combines normal, disabled, and current items in one breadcrumb.',
    <<<'CODE'
echo Breadcrumb::make([
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Library', 'href' => '/library'],
    ['label' => 'Data', 'disabled' => true],
    ['label' => 'Details', 'current' => true],
])->render();
CODE,
    fn() => print Breadcrumb::make([
        ['label' => 'Home', 'href' => '/'],
        ['label' => 'Library', 'href' => '/library'],
        ['label' => 'Data', 'disabled' => true],
        ['label' => 'Details', 'current' => true],
    ])->render()
);


/**
 * Example 4 — Truncated Breadcrumb
 */
showDemo(
    'Truncated Breadcrumb',
    'Collapses long breadcrumb paths to keep layouts tidy.',
    <<<'CODE'
echo Breadcrumb::make([
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Level 1', 'href' => '/1'],
    ['label' => 'Level 2', 'href' => '/2'],
    ['label' => 'Level 3', 'href' => '/3'],
    ['label' => 'Current', 'current' => true],
], [
    'truncated' => true,
    'maxVisible' => 3
])->render();
CODE,
    fn() => print Breadcrumb::make([
        ['label' => 'Home', 'href' => '/'],
        ['label' => 'Level 1', 'href' => '/1'],
        ['label' => 'Level 2', 'href' => '/2'],
        ['label' => 'Level 3', 'href' => '/3'],
        ['label' => 'Current', 'current' => true],
    ], [
        'truncated' => true,
        'maxVisible' => 3
    ])->render()
);


/**
 * Example 5 — Fluent API (Token Style)
 */
showDemo(
    'Fluent API (Token Style)',
    'Build breadcrumb configuration through chained fluent methods.',
    <<<'CODE'
Breadcrumb::make()
    ->setItems([
        ['label' => 'Home', 'href' => '/'],
        ['label' => 'Docs', 'href' => '/docs'],
        ['label' => 'API', 'href' => '/docs/api'],
        ['label' => 'Breadcrumb', 'current' => true],
    ])
    ->setSeparator('/')
    ->setTruncated(true)
    ->setMaxVisible(3)
    ->render();
CODE,
    fn() => print Breadcrumb::make()
        ->setItems([
            ['label' => 'Home', 'href' => '/'],
            ['label' => 'Docs', 'href' => '/docs'],
            ['label' => 'API', 'href' => '/docs/api'],
            ['label' => 'Breadcrumb', 'current' => true],
        ])
        ->setSeparator('/')
        ->setTruncated(true)
        ->setMaxVisible(3)
        ->render()
);