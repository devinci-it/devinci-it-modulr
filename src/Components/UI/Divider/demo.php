<?php

use DevinciIT\Modulr\Components\UI\Divider\Divider;

/* =========================
 * DEMO 1: BASIC DIVIDERS
 * ========================= */

showDemo(
    'Basic Dividers',
    'Horizontal and vertical dividers with default styling.',
    <<<'CODE'
echo Divider::make()->render();
echo Divider::make()->setOrientation('vertical')->render();
CODE
    ,
    function () {
        echo '<div style="margin-bottom: 10px; color:#6b7280; font-size:13px;">';
        echo 'Faux content: Existing overview text from the previous section.';
        echo '</div>';
        echo '<h4 style="margin:0 0 10px; font-size:15px;">Profile Header</h4>';
        echo '<div style="margin-bottom: 16px;">';
        echo Divider::make()->render();
        echo '</div>';

        echo '<div style="display:flex; gap:16px; align-items:center; height:100px;">';
        echo '<div style="color:#6b7280; font-size:13px;">Faux content</div>';
        echo Divider::make()->setOrientation('vertical')->render();
        echo '<h4 style="margin:0; font-size:15px;">Vertical Header</h4>';
        echo '</div>';
    }
);

/* =========================
 * DEMO 2: SIZE VARIANTS
 * ========================= */

showDemo(
    'Size Variants (sm / md / lg)',
    'Thickness scales with size on horizontal, affecting minimum height on vertical.',
    <<<'CODE'
echo Divider::make()->setSize('sm')->render();
echo Divider::make()->setSize('md')->render();
echo Divider::make()->setSize('lg')->render();
CODE
    ,
    function () {
        echo '<div style="margin-bottom: 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:14px;">Small Header</h4>';
        echo Divider::make()->setSize('sm')->render();

        echo '<div style="margin:16px 0 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:15px;">Medium Header</h4>';
        echo Divider::make()->setSize('md')->render();

        echo '<div style="margin:16px 0 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:16px;">Large Header</h4>';
        echo Divider::make()->setSize('lg')->render();
    }
);

/* =========================
 * DEMO 3: STYLE VARIANTS
 * ========================= */

showDemo(
    'Style Variants (solid / dashed / dotted)',
    'Different visual styles for dividers.',
    <<<'CODE'
echo Divider::make()->setStyle('solid')->render();
echo Divider::make()->setStyle('dashed')->render();
echo Divider::make()->setStyle('dotted')->render();
CODE
    ,
    function () {
        echo '<div style="margin-bottom: 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:15px;">Solid Header Divider</h4>';
        echo Divider::make()->setStyle('solid')->render();

        echo '<div style="margin:16px 0 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:15px;">Dashed Header Divider</h4>';
        echo Divider::make()->setStyle('dashed')->render();

        echo '<div style="margin:16px 0 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:15px;">Dotted Header Divider</h4>';
        echo Divider::make()->setStyle('dotted')->render();
    }
);

/* =========================
 * DEMO 4: COLOR VARIANTS
 * ========================= */

showDemo(
    'Color Variants (default / muted / strong)',
    'Color prominence levels for visual hierarchy.',
    <<<'CODE'
echo Divider::make()->setColor('default')->render();
echo Divider::make()->setColor('muted')->render();
echo Divider::make()->setColor('strong')->render();
CODE
    ,
    function () {
        echo '<div style="margin-bottom: 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:15px;">Default Color Header</h4>';
        echo Divider::make()->setColor('default')->render();

        echo '<div style="margin:16px 0 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:15px;">Muted Color Header</h4>';
        echo Divider::make()->setColor('muted')->render();

        echo '<div style="margin:16px 0 8px; color:#6b7280; font-size:13px;">Sample Content</div>';
        echo '<h4 style="margin:0 0 8px; font-size:15px;">Strong Color Header</h4>';
        echo Divider::make()->setColor('strong')->render();
    }
);

/* =========================
 * DEMO 5: COMPOSITION
 * ========================= */

showDemo(
    'Combined Variants',
    'Mixing orientation, size, style, and color for flexible layouts.',
    <<<'CODE'
echo Divider::make()
    ->setSize('md')
    ->setStyle('dashed')
    ->setColor('strong')
    ->render();
CODE
    ,
    function () {
        echo '<div style="display:flex; gap:12px; align-items:center; margin: 12px 0;">';
        echo '<span style="color:#6b7280; font-size:13px;">Faux content</span>';
        echo Divider::make()
            ->setOrientation('vertical')
            ->setSize('md')
            ->setStyle('dashed')
            ->setColor('default')
            ->render();
        echo '<h4 style="margin:0; font-size:15px;">Inline Header</h4>';
        echo '</div>';

        echo '<div style="margin-bottom: 8px; color:#6b7280; font-size:13px;">Faux content before section header</div>';
        echo '<h4 style="margin:0 0 8px; font-size:15px;">Muted Dotted Section</h4>';
        echo Divider::make()
            ->setSize('lg')
            ->setStyle('dotted')
            ->setColor('muted')
            ->render();
    }
);
