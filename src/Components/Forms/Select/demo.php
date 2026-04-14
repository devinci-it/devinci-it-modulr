<?php

use DevinciIT\Modulr\Components\Forms\Select\Select;

showDemo(
    'Select Variants',
    'Build selects fluently with placeholders, optgroups, multi-select, sizes, and validation states.',
    <<<'CODE'
echo Select::make()
    ->setName('country')
    ->setSize('sm')
    ->setPlaceholder('Choose a country')
    ->setOptions([
        'North America' => [
            'label' => 'North America',
            'options' => [
                'us' => 'United States',
                'ca' => 'Canada',
            ],
        ],
        'eu' => 'Europe',
        'asia' => 'Asia',
    ])
    ->render();

echo Select::make()
    ->setName('skills[]')
    ->setMultiple(true)
    ->setSize('lg')
    ->setSelected(['php', 'css'])
    ->setOptions([
        'php' => 'PHP',
        'js' => 'JavaScript',
        'css' => 'CSS',
    ])
    ->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Grouped Options</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Small select with placeholder and optgroup structure.</p>';

        echo Select::make()
            ->setName('country')
            ->setSize('sm')
            ->setPlaceholder('Choose a country')
            ->setOptions([
                'North America' => [
                    'label' => 'North America',
                    'options' => [
                        'us' => 'United States',
                        'ca' => 'Canada',
                    ],
                ],
                'eu' => 'Europe',
                'asia' => 'Asia',
            ])
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Multi-select Skills</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Large multi-select with preselected values.</p>';

        echo Select::make()
            ->setName('skills[]')
            ->setMultiple(true)
            ->setSize('lg')
            ->setSelected(['php', 'css'])
            ->setOptions([
                'php' => 'PHP',
                'js' => 'JavaScript',
                'css' => 'CSS',
            ])
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Invalid Required Select</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Show helper text and an error state on required selection.</p>';

        echo Select::make()
            ->setName('status')
            ->setSize('md')
            ->setRequired(true)
            ->setInvalid(true)
            ->setHelperText('Choose a visibility state.')
            ->setErrorMessage('Status is required.')
            ->setOptions([
                'draft' => 'Draft',
                'review' => 'In review',
                'published' => 'Published',
            ])
            ->render();

        echo '</section>';

        echo '</div>';
    }
);
