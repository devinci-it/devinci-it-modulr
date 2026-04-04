<?php

use DevinciIT\Modulr\Components\PageLayout\PageHeader\PageHeader;
use DevinciIT\Modulr\Components\UI\Button\Button;
use DevinciIT\Modulr\Components\DataDisplay\Token\Token;
/**
 * BASIC
 */
showDemo(
    'Basic Page Header',
    'Simple title with description.',
    <<<'CODE'
echo PageHeader::make()
    ->setTitle('Dashboard')
    ->setDescription('Overview of your workspace')
    ->render();
CODE,
    function () {
        echo PageHeader::make()
            ->setTitle('Dashboard')
            ->setDescription('Overview of your workspace')
            ->render();
    }
);

/**
 * SIZE VARIANTS
 */
showDemo(
    'Size Variants (sm / md / lg)',
    'PageHeader uses a baseline scale system similar to Button sizing.',
    <<<'CODE'
echo PageHeader::make()->setTitle('Small')->setDescription('Compact density')->setSize('sm')->render();
echo PageHeader::make()->setTitle('Medium')->setDescription('Default density')->setSize('md')->render();
echo PageHeader::make()->setTitle('Large')->setDescription('Comfortable density')->setSize('lg')->render();
CODE,
    function () {
        echo '<div style="display:grid; gap: 12px;">';
        echo PageHeader::make()->setTitle('Small')->setDescription('Compact density')->setSize('sm')->render();
        echo PageHeader::make()->setTitle('Medium')->setDescription('Default density')->setSize('md')->render();
        echo PageHeader::make()->setTitle('Large')->setDescription('Comfortable density')->setSize('lg')->render();
        echo '</div>';
    }
);


/**
 * WITH ACTION
 */
showDemo(
    'With Actions',
    'Includes a primary action button.',
    <<<'CODE'
echo PageHeader::make()
    ->setTitle('Projects')
    ->setTrailingAction(
        Button::make()
            ->setLabel('Create Project')
            ->setVariant('primary')
            ->render()
    )
    ->render();
CODE,
    function () {
        echo PageHeader::make()
            ->setTitle('Projects')
            ->setTrailingAction(
                (new Button())
                    ->setLabel('Create Project')
                    ->setVariant('primary')
                    ->render()
            )
            ->render();
    }
);


/**
 * WITH VISUALS
 */
showDemo(
    'With Leading & Trailing Visuals',
    'Adds icon/avatar context to the title.',
    <<<'CODE'
echo PageHeader::make()
    ->setTitle('User Profile')
    ->setLeadingVisual('<span>👤</span>')
    ->setTrailingVisual('<span>Status: Active</span>')
    ->render();
CODE,
    function () {
        echo PageHeader::make()
            ->setTitle('User Profile')
            ->setLeadingVisual('<span>👤</span>')
            ->setTrailingVisual('<span>Status: Active</span>')
            ->render();
    }
);


/**
 * CONTEXT BAR
 */
showDemo(
    'With Context Bar',
    'Breadcrumb or back navigation (mobile-first).',
    <<<'CODE'
echo PageHeader::make()
    ->setContext('<a href="/">← Back</a>')
    ->setTitle('Settings')
    ->render();
CODE,
    function () {
        echo PageHeader::make()
            ->setContext('<a href="/">← Back</a>')
            ->setTitle('Settings')
            ->render();
    }
);


/**
 * FULL COMPOSITION
 */
showDemo(
    'Full Composition',
    'Combines context, visuals, description, and actions.',
    <<<'CODE'
echo PageHeader::make()
    ->setContext('<a href="/">← Projects</a>')
    ->setTitle('Project Alpha')
    ->setDescription('Manage settings and team')
    ->setLeadingVisual('<span>📁</span>')
    ->setTrailingAction(
        (new Button())
            ->setLabel('Save')
            ->setVariant('primary')
            ->render()
    )
    ->render();
CODE,
    function () {
        echo PageHeader::make()
            ->setContext('<a href="/">← Projects</a>')
            ->setTitle('Project Alpha')
            ->setDescription('Manage settings and team')
            ->setLeadingVisual('<span>📁</span>')
            ->setTrailingAction(
                (new Button())
                    ->setLabel('Save')
                    ->setVariant('primary')
                    ->render()
            )
            ->render();
    }
);

?>
