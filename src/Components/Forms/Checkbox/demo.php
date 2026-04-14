<?php

use DevinciIT\Modulr\Components\Forms\Checkbox\Checkbox;

showDemo(
    'Checkbox',
    'Build checkboxes fluently with labels, sizes, checked state, required state, helper text, and validation.',
    <<<'CODE'
echo Checkbox::make()
    ->setName('terms')
    ->setLabel('I agree to the terms')
    ->setSize('sm')
    ->setHelperText('Required before submitting the form.')
    ->setRequired(true)
    ->render();

echo Checkbox::make()
    ->setName('newsletter')
    ->setLabel('Subscribe to updates')
    ->setSize('md')
    ->setChecked(true)
    ->render();

echo Checkbox::make()
    ->setName('policy')
    ->setLabel('Policy acknowledgement')
    ->setSize('lg')
    ->setDisabled(true)
    ->setInvalid(true)
    ->setHelperText('Please confirm the policy before continuing.')
    ->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Required Consent</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Small required checkbox with helper guidance.</p>';

        echo Checkbox::make()
            ->setName('terms')
            ->setLabel('I agree to the terms')
            ->setSize('sm')
            ->setHelperText('Required before submitting the form.')
            ->setRequired(true)
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Checked State</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Medium checkbox rendered as already selected.</p>';

        echo Checkbox::make()
            ->setName('newsletter')
            ->setLabel('Subscribe to updates')
            ->setSize('md')
            ->setChecked(true)
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Disabled + Invalid</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Large disabled checkbox styled with an invalid state and helper note.</p>';

        echo Checkbox::make()
            ->setName('policy')
            ->setLabel('Policy acknowledgement')
            ->setSize('lg')
            ->setDisabled(true)
            ->setInvalid(true)
            ->setHelperText('Please confirm the policy before continuing.')
            ->render();

        echo '</section>';

        echo '</div>';
    }
);
