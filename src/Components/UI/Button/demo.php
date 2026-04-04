<?php

// This file demonstrates the Button component with various configurations.
/*
 * To run this demo, ensure you have the Modulr framework set up and include this file in your routing or testing environment.
 * Each section shows different features of the Button component with live previews and code snippets.
 */

use DevinciIT\Modulr\Components\UI\Button\Button;

if (!function_exists('showButtonCode')) {
    function showButtonCode(string $title, string $description, string $code, callable $render)
    {
        echo '<div class="demo-block" style="margin-bottom: 40px;">';

        // Title
        echo '<h3 style="margin-bottom: 6px;">' . htmlspecialchars($title) . '</h3>';

        // Description
        echo '<p style="margin: 0 0 10px; font-size: 13px; color: #6b7280;">'
            . htmlspecialchars($description) .
            '</p>';

        // Preview
        echo '<div class="demo-preview" style="padding: 12px; border: 1px solid #ddd; border-radius: 6px; display:flex; gap:8px; flex-wrap:wrap; align-items:center;">';
        $render();
        echo '</div>';

        // Toggle button
        echo '<button class="modulr-show-code-btn"
            onclick="this.nextElementSibling.style.display = (this.nextElementSibling.style.display === \'none\' ? \'block\' : \'none\')"
            style="margin-top: 8px; font-size: 12px;">Show Code</button>';

        // Code block
        echo '<pre class="demo-code" style="display:none; background:#111; color:#eee; padding:12px; overflow:auto; font-size:12px;">';
        echo htmlspecialchars($code);
        echo '</pre>';

        echo '</div>';
    }
}

/**
 * Example 1 — Variants
 */
showButtonCode(
    'Button Variants',
    'Use variants to communicate intent. Primary = main action, Secondary = supporting, Outline = subtle.',
    <<<'CODE'
echo (new Button())->setLabel('Primary')->setVariant('primary')->render();
echo (new Button())->setLabel('Secondary')->setVariant('secondary')->render();
echo (new Button())->setLabel('Outline')->setVariant('outline')->render();
echo (new Button())->setLabel('Rounded')->setVariant('primary')->setRounded(true)->render();
CODE,
    function () {
        echo (new Button())->setLabel('Primary')->setVariant('primary')->render();
        echo (new Button())->setLabel('Secondary')->setVariant('secondary')->render();
        echo (new Button())->setLabel('Outline')->setVariant('outline')->render();
        echo (new Button())->setLabel('Rounded')->setVariant('primary')->setRounded(true)->render();
    }
);

/**
 * Example 2 — Sizes
 */
showButtonCode(
    'Button Sizes',
    'Sizes scale automatically using the internal design system. Adjust once, everything scales.',
    <<<'CODE'
echo (new Button())->setLabel('Small')->setVariant('primary')->setSize('sm')->render();
echo (new Button())->setLabel('Medium')->setVariant('primary')->setSize('md')->render();
echo (new Button())->setLabel('Large')->setVariant('primary')->setSize('lg')->render();
CODE,
    function () {
        echo (new Button())->setLabel('Small')->setVariant('primary')->setSize('sm')->render();
        echo (new Button())->setLabel('Medium')->setVariant('primary')->setSize('md')->render();
        echo (new Button())->setLabel('Large')->setVariant('primary')->setSize('lg')->render();
    }
);

/**
 * Example 3 — States
 */
showButtonCode(
    'States (Disabled / Loading)',
    'Use disabled for unavailable actions and loading for async feedback. Loading blocks interaction.',
    <<<'CODE'
echo (new Button())->setLabel('Disabled')->setVariant('secondary')->setDisabled(true)->render();
echo (new Button())->setLabel('Loading')->setVariant('primary')->setLoading(true)->render();
CODE,
    function () {
        echo (new Button())->setLabel('Disabled')->setVariant('secondary')->setDisabled(true)->render();
        echo (new Button())->setLabel('Loading')->setVariant('primary')->setLoading(true)->render();
    }
);

/**
 * Example 4 — Links + Icons
 */
showButtonCode(
    'Links + Icons',
    'Buttons can act as links and support icons for better UX clarity.',
    <<<'CODE'
echo (new Button())
    ->setLabel('Create')
    ->setVariant('primary')
    ->setIcon($plus, 'left')
    ->render();

echo (new Button())
    ->setLabel('Go to Docs')
    ->setVariant('outline')
    ->setHref('/docs')
    ->setIcon($arrow, 'right')
    ->render();
CODE,
    function () {
        $plus = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2"/></svg>';
        $arrow = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2"/></svg>';

        echo (new Button())
            ->setLabel('Create')
            ->setVariant('primary')
            ->setIcon($plus, 'left')
            ->render();

        echo (new Button())
            ->setLabel('Go to Docs')
            ->setVariant('outline')
            ->setHref('/docs')
            ->setIcon($arrow, 'right')
            ->render();
    }
);

/**
 * Example 5 — Fluent API
 */
showButtonCode(
    'Fluent API',
    'Chain methods for clean, readable component configuration.',
    <<<'CODE'
echo (new Button())
    ->setLabel('Save Changes')
    ->setVariant('primary')
    ->setSize('lg')
    ->render();
CODE,
    function () {
        echo (new Button())
            ->setLabel('Save Changes')
            ->setVariant('primary')
            ->setSize('lg')
            ->render();
    }
);

/**
 * Example 6 — Practical Usage (Mix Everything)
 */
showButtonCode(
    'Real UI Example (Mixed)',
    'Real-world usage combining variants, sizes, icons, states, and shape.',
    <<<'CODE'
echo (new Button())
    ->setLabel('Publish')
    ->setVariant('primary')
    ->setSize('lg')
    ->setIcon($check, 'left')
    ->setRounded(true)
    ->render();

echo (new Button())
    ->setLabel('Cancel')
    ->setVariant('secondary')
    ->setSize('md')
    ->render();

echo (new Button())
    ->setLabel('Delete')
    ->setVariant('outline')
    ->setSize('sm')
    ->setDisabled(true)
    ->render();
CODE,
    function () {
        $check = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2"/></svg>';

        echo (new Button())
            ->setLabel('Publish')
            ->setVariant('primary')
            ->setSize('lg')
            ->setIcon($check, 'left')
            ->setRounded(true)
            ->render();

        echo (new Button())
            ->setLabel('Cancel')
            ->setVariant('secondary')
            ->setSize('md')
            ->render();

        echo (new Button())
            ->setLabel('Delete')
            ->setVariant('outline')
            ->setSize('sm')
            ->setDisabled(true)
            ->render();
    }
);