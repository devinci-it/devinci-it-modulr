<?php

use DevinciIT\Modulr\Components\Forms\Textarea\Textarea;

showDemo(
    'Textarea Variants',
    'Build multiline fields fluently with rows, resize modes, sizes, helper text, and validation states.',
    <<<'CODE'
echo Textarea::make()
    ->setName('bio')
    ->setRows(5)
    ->setSize('sm')
    ->setPlaceholder('Tell us about yourself')
    ->setHelperText('A short bio helps people recognize you.')
    ->render();

echo Textarea::make()
    ->setName('notes')
    ->setResize('none')
    ->setSize('md')
    ->setValue('Locked resize mode example.')
    ->setReadonly(true)
    ->render();

echo Textarea::make()
    ->setName('feedback')
    ->setResize('both')
    ->setSize('lg')
    ->setRequired(true)
    ->setInvalid(true)
    ->setErrorMessage('Please add more detail.')
    ->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Bio Field</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Small textarea with custom rows and helper guidance.</p>';

        echo Textarea::make()
            ->setName('bio')
            ->setRows(5)
            ->setSize('sm')
            ->setPlaceholder('Tell us about yourself')
            ->setHelperText('A short bio helps people recognize you.')
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Readonly Notes</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Medium textarea with resize disabled and readonly content.</p>';

        echo Textarea::make()
            ->setName('notes')
            ->setResize('none')
            ->setSize('md')
            ->setValue('Locked resize mode example.')
            ->setReadonly(true)
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Invalid Feedback</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Large required textarea with both-direction resize and validation error.</p>';

        echo Textarea::make()
            ->setName('feedback')
            ->setResize('both')
            ->setSize('lg')
            ->setRequired(true)
            ->setInvalid(true)
            ->setErrorMessage('Please add more detail.')
            ->render();

        echo '</section>';

        echo '</div>';
    }
);
