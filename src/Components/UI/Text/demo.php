<?php

use DevinciIT\Modulr\Components\UI\Text\Text;

showDemo(
    'Text Variants',
    'Render the complete typography set with fluent variant and tag controls.',
    <<<'CODE'
echo Text::make()->setTag('h1')->setVariant('display')->setText('Display Text')->render();
echo Text::make()->setTag('h2')->setVariant('title-large')->setText('Title Large')->render();
echo Text::make()->setTag('p')->setVariant('body-medium')->setText('Body medium content for default reading.')->render();
echo Text::make()->setTag('small')->setVariant('caption')->setText('Caption metadata text.')->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Display + Titles</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Use display and title variants for strong hierarchy.</p>';
        echo Text::make()->setTag('h1')->setVariant('display')->setText('Display Text')->render();
        echo Text::make()->setTag('h2')->setVariant('title-large')->setText('Title Large')->render();
        echo Text::make()->setTag('h3')->setVariant('title-medium')->setText('Title Medium')->render();
        echo Text::make()->setTag('h4')->setVariant('title-small')->setText('Title Small')->render();
        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Body + Subtitle + Caption</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Use body and supporting variants for long-form UI content.</p>';
        echo Text::make()->setTag('p')->setVariant('subtitle')->setText('Subtitle text to introduce a section.')->render();
        echo Text::make()->setTag('p')->setVariant('body-large')->setText('Body large text for prominent paragraph content.')->render();
        echo Text::make()->setTag('p')->setVariant('body-medium')->setText('Body medium content for default reading.')->render();
        echo Text::make()->setTag('p')->setVariant('body-small')->setText('Body small for compact interfaces.')->render();
        echo Text::make()->setTag('small')->setVariant('caption')->setText('Caption metadata text.')->render();
        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Code + Weight Overrides</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Code variants and optional weight overrides for nuanced emphasis.</p>';
        echo Text::make()->setTag('code')->setVariant('code-inline')->setText('npm run build')->render();
        echo '<br>';
        echo Text::make()->setTag('div')->setVariant('code-block')->setText('php modulr dev:publish-assets --force')->render();
        echo Text::make()->setTag('p')->setVariant('body-medium')->setWeight('light')->setText('Body medium with light weight override.')->render();
        echo Text::make()->setTag('p')->setVariant('body-medium')->setWeight('semibold')->setText('Body medium with semibold weight override.')->render();
        echo '</section>';

        echo '</div>';
    }
);
