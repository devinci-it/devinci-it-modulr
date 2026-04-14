<?php

use DevinciIT\Modulr\Components\Forms\Label\Label;

showDemo(
    'Label Variants',
    'Build labels fluently with for targets, sizes, required markers, and assistive text.',
    <<<'CODE'
echo Label::make()
    ->setFor('email')
    ->setText('Email address')
    ->setSize('sm')
    ->setRequired(true)
    ->render();

echo Label::make()
    ->setFor('name')
    ->setText('Full name')
    ->setSize('md')
    ->render();

echo Label::make()
    ->setFor('username')
    ->setText('Username')
    ->setSize('lg')
    ->setAssistiveText('This will be shown publicly.')
    ->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Small + Required</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Use compact label sizing with a required marker.</p>';

        echo Label::make()
            ->setFor('email')
            ->setText('Email address')
            ->setSize('sm')
            ->setRequired(true)
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Default Label</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Standard medium size for most form fields.</p>';

        echo Label::make()
            ->setFor('name')
            ->setText('Full name')
            ->setSize('md')
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Large + Assistive Text</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Add supporting guidance next to the main label text.</p>';

        echo Label::make()
            ->setFor('username')
            ->setText('Username')
            ->setSize('lg')
            ->setAssistiveText('This will be shown publicly.')
            ->render();

        echo '</section>';

        echo '</div>';
    }
);
