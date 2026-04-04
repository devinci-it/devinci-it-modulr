<?php

use DevinciIT\Modulr\Components\UI\Icon\Icon;

/**
 * Sample SVGs
 */
$search = '<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24"><path d="M10.25 2a8.25 8.25 0 0 1 6.34 13.53l5.69 5.69a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215l-5.69-5.69A8.25 8.25 0 1 1 10.25 2ZM3.5 10.25a6.75 6.75 0 1 0 13.5 0 6.75 6.75 0 0 0-13.5 0Z"/></svg>';

$user = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2.5a5.5 5.5 0 0 1 3.096 10.047 9.005 9.005 0 0 1 5.9 8.181.75.75 0 1 1-1.499.044 7.5 7.5 0 0 0-14.993 0 .75.75 0 0 1-1.5-.045 9.005 9.005 0 0 1 5.9-8.18A5.5 5.5 0 0 1 12 2.5ZM8 8a4 4 0 1 0 8 0 4 4 0 0 0-8 0Z"/></svg>';

$check = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 16.2l-3.5-3.5a.75.75 0 1 0-1.06 1.06l4 4a.75.75 0 0 0 1.06 0l8-8a.75.75 0 1 0-1.06-1.06L10 14.2z"/></svg>';

/* Example 1 — Basic Icons
 */

showDemo(
    'Basic Icons',
    'Render SVG icons with the default icon component settings, You can use raw SVG strings or path to svg files.',
    <<<'CODE'
$search = '<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24">
           <path d="M10.25 2a8.25 8.25 0 0 1 6.34 13.53l5.69 5.69a.749.749 0 0 1-.326 1.275.749.749 0 0 1-.734-.215l-5.69-5.69A8.25 8.25 0 1 1 10.25 2ZM3.5 10.25a6.75 6.75 0 1 0 13.5 0 6.75 6.75 0 0 0-13.5 0Z"/>
           </svg>';
echo Icon::make($search)->render();
echo Icon::make('logo.svg')->render();
CODE,
    function () use ($search, $user, $check) {
        echo Icon::make($search)->render();
        echo Icon::make('logo.svg')->render();
      
    }
);

/**
 * Example 2 — Sizes
 */
showDemo(
    'Icon Sizes',
    'Scale icons consistently using predefined size tokens.',
    <<<'CODE'
echo Icon::make($search)->setSize('sm')->render();
echo Icon::make($search)->setSize('md')->render();
echo Icon::make($search)->setSize('lg')->render();
CODE,
    function () use ($search) {
        echo Icon::make($search)->setSize('sm')->render();
        echo Icon::make($search)->setSize('md')->render();
        echo Icon::make($search)->setSize('lg')->render();
    }
);

/**
 * Example 3 — Colors
 */
showDemo(
    'Icon Colors',
    'Apply color values for semantic or branded icon styles.',
    <<<'CODE'
echo Icon::make($check)->setColor('green')->render();
echo Icon::make($check)->setColor('#0070f3')->render();
echo Icon::make($check)->setColor('red')->render();
CODE,
    function () use ($check) {
        echo Icon::make($check)->setColor('green')->render();
        echo Icon::make($check)->setColor('#0070f3')->render();
        echo Icon::make($check)->setColor('red')->render();
    }
);

/**
 * Example 4 — Accessibility
 */
showDemo(
    'Accessible vs Decorative',
    'Use labels for assistive tech when icons convey meaning.',
    <<<'CODE'
// Decorative (default)
echo Icon::make($search)->render();

// Accessible
echo Icon::make($search)
    ->setLabel('Search')
    ->render();
CODE,
    function () use ($search) {
        echo Icon::make($search)->render();

        echo Icon::make($search)
            ->setLabel('Search')
            ->render();
    }
);

/**
 * Example 5 — Practical Usage (Inside Button-like UI)
 */
showDemo(
    'Practical Usage (Inline with Text)',
    'Place icons inline with text to improve visual scanability.',
    <<<'CODE'
echo '<div style="display:flex; gap:8px; align-items:center;">';

echo Icon::make($user)->setSize('sm')->render();
echo '<span>User Profile</span>';

echo '</div>';
CODE,
    function () use ($user) {
        echo '<div style="display:flex; gap:8px; align-items:center;">';

        echo Icon::make($user)->setSize('sm')->render();
        echo '<span>User Profile</span>';

        echo '</div>';
    }
);

/**
 * Example 6 — Mixed (Real UI Feel)
 */
showDemo(
    'Mixed Example (Real UI)',
    'Combine size and color settings to mimic real interface usage.',
    <<<'CODE'
echo '<div style="display:flex; gap:12px;">';

echo Icon::make($check)->setColor('green')->render();
echo Icon::make($user)->setSize('lg')->render();
echo Icon::make($search)->setSize('sm')->setColor('#666')->render();

echo '</div>';
CODE,
    function () use ($check, $user, $search) {
        echo '<div style="display:flex; gap:12px;">';

        echo Icon::make($check)->setColor('green')->render();
        echo Icon::make($user)->setSize('lg')->render();
        echo Icon::make($search)->setSize('sm')->setColor('#666')->render();

        echo '</div>';
    }
);