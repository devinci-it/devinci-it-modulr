<?php

use DevinciIT\Modulr\Components\Forms\Radio\Radio;

showDemo(
    'Radio Groups',
    'Build radio choices fluently with a shared name, sizes, checked state, and helper text.',
    <<<'CODE'
echo Radio::make()
    ->setName('plan')
    ->setValue('starter')
    ->setSize('sm')
    ->setLabel('Starter')
    ->render();

echo Radio::make()
    ->setName('plan')
    ->setValue('pro')
    ->setSize('md')
    ->setLabel('Pro')
    ->setChecked(true)
    ->render();

echo Radio::make()
    ->setName('plan')
    ->setValue('enterprise')
    ->setSize('lg')
    ->setLabel('Enterprise')
    ->setHelperText('Contact sales for enterprise pricing.')
    ->setDisabled(true)
    ->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Starter Option</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Small radio option for compact choice lists.</p>';

        echo Radio::make()
            ->setName('plan')
            ->setValue('starter')
            ->setLabel('Starter')
            ->setSize('sm')
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Preselected Option</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Medium radio option rendered as checked.</p>';

        echo Radio::make()
            ->setName('plan')
            ->setValue('pro')
            ->setLabel('Pro')
            ->setSize('md')
            ->setChecked(true)
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Disabled Enterprise</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Large disabled option with helper text.</p>';

        echo Radio::make()
            ->setName('plan')
            ->setValue('enterprise')
            ->setLabel('Enterprise')
            ->setSize('lg')
            ->setHelperText('Contact sales for enterprise pricing.')
            ->setDisabled(true)
            ->render();

        echo '</section>';

        echo '</div>';
    }
);
