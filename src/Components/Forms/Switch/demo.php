<?php

use DevinciIT\Modulr\Components\Forms\Switch\ToggleSwitch;

showDemo(
    'Switch / Toggle',
    'Build toggle switches fluently with sizes, checked state, disabled state, and descriptions.',
    <<<'CODE'
echo ToggleSwitch::make()
    ->setName('notifications')
    ->setLabel('Enable notifications')
    ->setSize('sm')
    ->setDescription('Turn on email and push notifications.')
    ->setChecked(true)
    ->render();

echo ToggleSwitch::make()
    ->setName('dark_mode')
    ->setLabel('Dark mode')
    ->setSize('lg')
    ->setDescription('Remember the preferred theme for this browser.')
    ->render();

echo ToggleSwitch::make()
    ->setName('beta_features')
    ->setLabel('Beta features')
    ->setSize('md')
    ->setDisabled(true)
    ->setDescription('This option is currently unavailable.')
    ->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Enabled Notifications</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Small switch rendered in the checked state.</p>';

        echo ToggleSwitch::make()
            ->setName('notifications')
            ->setLabel('Enable notifications')
            ->setSize('sm')
            ->setDescription('Turn on email and push notifications.')
            ->setChecked(true)
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Theme Preference</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Large switch variant for prominent preference toggles.</p>';

        echo ToggleSwitch::make()
            ->setName('dark_mode')
            ->setLabel('Dark mode')
            ->setSize('lg')
            ->setDescription('Remember the preferred theme for this browser.')
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Unavailable Toggle</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Disabled switch used for features not yet available.</p>';

        echo ToggleSwitch::make()
            ->setName('beta_features')
            ->setLabel('Beta features')
            ->setSize('md')
            ->setDisabled(true)
            ->setDescription('This option is currently unavailable.')
            ->render();

        echo '</section>';

        echo '</div>';
    }
);
