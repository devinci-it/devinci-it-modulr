<?php

use DevinciIT\Modulr\Components\Forms\Input\Input;

showDemo(
    'Input States',
    'Build text, email, search, and password inputs fluently with sizes, adornments, helper text, and validation states.',
    <<<'CODE'
echo Input::make()
    ->setName('email')
    ->setType('email')
    ->setSize('sm')
    ->setPlaceholder('you@example.com')
    ->setAutocomplete('email')
    ->setHelperText('We will never share your email.')
    ->render();

echo Input::make()
    ->setName('search')
    ->setType('search')
    ->setSize('md')
    ->setLeadingAdornment('<span aria-hidden="true">🔎</span>')
    ->setTrailingAdornment('<span aria-hidden="true">⌘K</span>')
    ->setPlaceholder('Search users')
    ->render();

echo Input::make()
    ->setName('password')
    ->setType('password')
    ->setSize('lg')
    ->setRequired(true)
    ->setPlaceholder('••••••••')
    ->setHelperText('At least 8 characters.')
    ->render();

echo Input::make()
    ->setName('invalid')
    ->setType('text')
    ->setSize('md')
    ->setInvalid(true)
    ->setErrorMessage('This field is required.')
    ->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:14px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Email Input</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Small size with helper text and browser autocomplete hint.</p>';

        echo Input::make()
            ->setName('email')
            ->setType('email')
            ->setSize('sm')
            ->setPlaceholder('you@example.com')
            ->setAutocomplete('email')
            ->setHelperText('We will never share your email.')
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Search with Adornments</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Use leading and trailing adornments for contextual actions.</p>';

        echo Input::make()
            ->setName('search')
            ->setType('search')
            ->setSize('md')
            ->setLeadingAdornment('<span aria-hidden="true">🔎</span>')
            ->setTrailingAdornment('<span aria-hidden="true">⌘K</span>')
            ->setPlaceholder('Search users')
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Password Field</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Large required password input with helper guidance.</p>';

        echo Input::make()
            ->setName('password')
            ->setType('password')
            ->setSize('lg')
            ->setRequired(true)
            ->setPlaceholder('••••••••')
            ->setHelperText('At least 8 characters.')
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Validation Error</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Mark the field invalid and surface an error message.</p>';

        echo Input::make()
            ->setName('invalid')
            ->setType('text')
            ->setSize('md')
            ->setInvalid(true)
            ->setErrorMessage('This field is required.')
            ->render();

        echo '</section>';

        echo '</div>';
    }
);
