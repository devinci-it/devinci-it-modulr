<?php

/*
    * Not meant to be run directly. This file is included by demo/index.php to render the Token component demos.
    * This file is part of Devinci IT's Modulr package.
    *
    * (c) Devinci IT 
    *
*/

use DevinciIT\Modulr\Components\DataDisplay\Token\Token;
use DevinciIT\Modulr\Components\DataDisplay\Token\TokenGroup;

/* =========================
 * DEMO 1: BASIC TOKENS
 * ========================= */

showDemo(
    'Basic Tokens',
    'Simple tokens without interaction.',
    <<<'PHP'
new TokenGroup([
    new Token('Read-only'),
    new Token('Static Label'),
    new Token('Display Only')
]);
PHP
    ,
    function () {
        echo (new TokenGroup([
            new Token('Read-only'),
            new Token('Static Label'),
            new Token('Display Only')
        ]))->render();
    }
);

/* =========================
 * DEMO 2: SIZE VARIANTS
 * ========================= */

showDemo(
    'Token Sizes (sm / md / lg)',
    'Token size uses a baseline scale system, matching the button sizing approach.',
    <<<'PHP'
echo (new Token('Small', ['size' => 'sm']))->render();
echo (new Token('Medium', ['size' => 'md']))->render();
echo (new Token('Large'))->setSize('lg')->render();
PHP
    ,
    function () {
        echo (new Token('Small', ['size' => 'sm']))->render();
        echo (new Token('Medium', ['size' => 'md']))->render();
        echo (new Token('Large'))->setSize('lg')->render();
    }
);

/* =========================
 * DEMO 3: WITH VISUALS
 * ========================= */

showDemo(
    'Tokens with Icons & Avatars',
    'Leading visuals like icons and images.',
    <<<'PHP'
new Token('Bug', [
    'leadingVisual' => '<span class="dot red"></span>'
]);

new Token('Alice', [
    'leadingVisual' => '<img src="avatar.jpg">'
]);
PHP
    ,
    function () {
        echo (new TokenGroup([
            new Token('Bug', [
                'leadingVisual' => '<span style="width:8px;height:8px;background:#e53e3e;border-radius:50%;display:inline-block;"></span>'
            ]),
            new Token('Feature', [
                'leadingVisual' => '<span style="width:8px;height:8px;background:#38a169;border-radius:50%;display:inline-block;"></span>'
            ]),
            new Token('Alice', [
                'leadingVisual' => '<img src="https://i.pravatar.cc/20?u=alice" style="border-radius:50%">'
            ])
        ]))->render();
    }
);

/* =========================
 * DEMO 4: REMOVABLE TOKENS
 * ========================= */

showDemo(
    'Removable Tokens',
    'Tokens that can be removed via user interaction.',
    <<<'PHP'
echo (new TokenGroup([
            new Token('Filter A', ['removable' => true]),
            new Token('Filter B', ['removable' => true]),
            new Token('Filter C', ['removable' => true]),
        ]))->render();
PHP
    ,
    function () {
        echo (new TokenGroup([
            new Token('Filter A', ['removable' => true]),
            new Token('Filter B', ['removable' => true]),
            new Token('Filter C', ['removable' => true]),
        ]))->render();
    }
);

/* =========================
 * DEMO 5: LINKS
 * ========================= */

showDemo(
    'Linked Tokens',
    'Tokens that act as navigation links.',
    <<<'PHP'
new Token('Open Issue', [
    'href' => '/issue/123'
]);
PHP
    ,
    function () {
        echo (new TokenGroup([
            new Token('Open Issue', ['href' => '#']),
            new Token('View Docs', ['href' => '#']),
            new Token('Settings', ['href' => '#']),
        ]))->render();
    }
);

/* =========================
 * DEMO 6: OVERFLOW GROUP
 * ========================= */

showDemo(
    'Token Group with Overflow',
    'Limits visible tokens and collapses the rest.',
    <<<'PHP'
   echo (new TokenGroup([
            new Token('Bug'),
            new Token('Feature'),
            new Token('Frontend'),
            new Token('Backend'),
            new Token('Critical'),
            new Token('High Priority'),
        ], 3, '+%d more'))->render();
PHP
    ,
    function () {
        echo (new TokenGroup([
            new Token('Bug'),
            new Token('Feature'),
            new Token('Frontend'),
            new Token('Backend'),
            new Token('Critical'),
            new Token('High Priority'),
        ], 3, '+%d more'))->render();
    }
);

/* =========================
 * DEMO 7: REALISTIC MIX
 * ========================= */

showDemo(
    'Real-World Example (Issues + Users)',
    'Mixed visuals, links, removable tokens, and grouping.',
    <<<'PHP'
new TokenGroup($tokens, 4);
PHP
    ,
    function () {
        echo (new TokenGroup([
            new Token('Bug', [
                'leadingVisual' => '<span style="background:red;width:8px;height:8px;border-radius:50%;display:inline-block;"></span>',
                'href' => '#'
            ]),
            new Token('Feature', [
                'leadingVisual' => '<span style="background:green;width:8px;height:8px;border-radius:50%;display:inline-block;"></span>'
            ]),
            new Token('Alice', [
                'leadingVisual' => '<img src="https://i.pravatar.cc/20?u=alice" style="border-radius:50%">'
            ]),
            new Token('Bob', [
                'leadingVisual' => '<img src="https://i.pravatar.cc/20?u=bob" style="border-radius:50%">',
                'removable' => true
            ]),
            new Token('Very Long Label That Should Truncate', [
                'removable' => true
            ]),
        ], 4))->render();
    }
);

?>