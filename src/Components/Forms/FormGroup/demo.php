<?php

use DevinciIT\Modulr\Components\Forms\FormGroup\FormGroup;
use DevinciIT\Modulr\Components\Forms\Input\Input;

showDemo(
    'FormGroup',
    'Compose labels and controls fluently with help text, error text, required state, and size control.',
    <<<'CODE'
echo FormGroup::make([
    'label' => 'Display name',
    'labelFor' => 'display_name',
    'size' => 'sm',
    'helpText' => 'Pick a short public-facing name.',
    'control' => Input::make()->setId('display_name')->setName('display_name')->setPlaceholder('Jane Doe')->render(),
])->render();

echo FormGroup::make([
    'label' => 'Username',
    'labelFor' => 'username',
    'size' => 'lg',
    'required' => true,
    'invalid' => true,
    'errorText' => 'That username is already taken.',
    'control' => Input::make()->setId('username')->setName('username')->setInvalid(true)->render(),
])->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Help Text Group</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Small form group with helper text and a standard control.</p>';

        echo FormGroup::make([
            'label' => 'Display name',
            'labelFor' => 'display_name',
            'size' => 'sm',
            'helpText' => 'Pick a short public-facing name.',
            'control' => Input::make()->setId('display_name')->setName('display_name')->setPlaceholder('Jane Doe')->render(),
        ])->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Invalid Required Group</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Large form group that surfaces required and error states together.</p>';

        echo FormGroup::make([
            'label' => 'Username',
            'labelFor' => 'username',
            'size' => 'lg',
            'required' => true,
            'invalid' => true,
            'errorText' => 'That username is already taken.',
            'control' => Input::make()->setId('username')->setName('username')->setInvalid(true)->render(),
        ])->render();

        echo '</section>';

        echo '</div>';
    }
);
