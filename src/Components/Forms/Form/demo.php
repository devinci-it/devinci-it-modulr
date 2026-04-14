<?php

use DevinciIT\Modulr\Components\Forms\Form\Form;
use DevinciIT\Modulr\Components\Forms\Input\Input;
use DevinciIT\Modulr\Components\Forms\Label\Label;
use DevinciIT\Modulr\Components\UI\Button\Button;

showDemo(
    'Form Layouts',
    'Build stacked, inline, and grid forms fluently with action, method, autocomplete, noValidate, content, and submit areas.',
    <<<'CODE'
echo Form::make()
    ->setAction('/profile')
    ->setMethod('post')
    ->setLayout('stacked')
    ->setContent(
        Label::make()->setFor('name')->setText('Full name')->render() .
        Input::make()->setId('name')->setName('name')->setPlaceholder('Jane Doe')->render() .
        Label::make()->setFor('email')->setText('Email address')->render() .
        Input::make()->setId('email')->setName('email')->setType('email')->setPlaceholder('you@example.com')->render()
    )
    ->setSubmitArea(Button::make()->setLabel('Save changes')->render())
    ->render();

echo Form::make()
    ->setAction('/search')
    ->setMethod('get')
    ->setLayout('inline')
    ->setAutocomplete('off')
    ->setContent(
        Label::make()->setFor('query')->setText('Search')->render() .
        Input::make()->setId('query')->setName('query')->setType('search')->setPlaceholder('Find a user')->render()
    )
    ->setSubmitArea(Button::make()->setLabel('Search')->render())
    ->render();

echo Form::make()
    ->setAction('/settings')
    ->setMethod('post')
    ->setLayout('grid')
    ->setNoValidate(true)
    ->setContent(
        Label::make()->setFor('username')->setText('Username')->render() .
        Input::make()->setId('username')->setName('username')->setPlaceholder('jane-doe')->render() .
        Label::make()->setFor('website')->setText('Website')->render() .
        Input::make()->setId('website')->setName('website')->setType('url')->setPlaceholder('https://example.com')->render()
    )
    ->setSubmitArea(Button::make()->setLabel('Update profile')->render())
    ->render();
CODE,
    function () {
        echo '<div style="display:grid;gap:18px;">';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Stacked Layout</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Default vertical flow for most settings and profile forms.</p>';

        echo Form::make()
            ->setAction('/profile')
            ->setMethod('post')
            ->setLayout('stacked')
            ->setContent(
                Label::make()->setFor('name')->setText('Full name')->render() .
                Input::make()->setId('name')->setName('name')->setPlaceholder('Jane Doe')->render() .
                Label::make()->setFor('email')->setText('Email address')->render() .
                Input::make()->setId('email')->setName('email')->setType('email')->setPlaceholder('you@example.com')->render()
            )
            ->setSubmitArea(Button::make()->setLabel('Save changes')->render())
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Inline Layout</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Compact horizontal arrangement for fast search-style forms.</p>';

        echo Form::make()
            ->setAction('/search')
            ->setMethod('get')
            ->setLayout('inline')
            ->setAutocomplete('off')
            ->setContent(
                Label::make()->setFor('query')->setText('Search')->render() .
                Input::make()->setId('query')->setName('query')->setType('search')->setPlaceholder('Find a user')->render()
            )
            ->setSubmitArea(Button::make()->setLabel('Search')->render())
            ->render();

        echo '</section>';

        echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
        echo '<h4 style="margin:0 0 4px;">Grid Layout</h4>';
        echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Multi-field layout with noValidate enabled for custom validation flows.</p>';

        echo Form::make()
            ->setAction('/settings')
            ->setMethod('post')
            ->setLayout('grid')
            ->setNoValidate(true)
            ->setContent(
                Label::make()->setFor('username')->setText('Username')->render() .
                Input::make()->setId('username')->setName('username')->setPlaceholder('jane-doe')->render() .
                Label::make()->setFor('website')->setText('Website')->render() .
                Input::make()->setId('website')->setName('website')->setType('url')->setPlaceholder('https://example.com')->render()
            )
            ->setSubmitArea(Button::make()->setLabel('Update profile')->render())
            ->render();

        echo '</section>';

        echo '</div>';
    }
);
