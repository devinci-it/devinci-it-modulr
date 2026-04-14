<?php

use DevinciIT\Modulr\Components\Feedback\Toast\Toast;

showDemo(
    'Toast Tones',
    'Exact setter calls for each tone variant.',
    <<<'CODE'
echo '<div style="display:grid;gap:12px;">';
echo Toast::make()->setTone('neutral')->setTitle('Neutral toast')->setMessage('A neutral toast for general updates.')->render();
echo Toast::make()->setTone('info')->setTitle('Info toast')->setMessage('An informational toast for helpful context.')->render();
echo Toast::make()->setTone('success')->setTitle('Success toast')->setMessage('A success toast for completed actions.')->render();
echo Toast::make()->setTone('warning')->setTitle('Warning toast')->setMessage('A warning toast for attention-worthy states.')->render();
echo Toast::make()->setTone('error')->setTitle('Error toast')->setMessage('An error toast for failed actions.')->render();
echo Toast::make()->setTone('debug')->setTitle('Debug toast')->setMessage('A debug toast for development feedback.')->render();
echo '</div>';
CODE,
    function () {
        echo '<div style="display:grid;gap:12px;">';
        echo Toast::make()->setTone('neutral')->setTitle('Neutral toast')->setMessage('A neutral toast for general updates.')->render();
        echo Toast::make()->setTone('info')->setTitle('Info toast')->setMessage('An informational toast for helpful context.')->render();
        echo Toast::make()->setTone('success')->setTitle('Success toast')->setMessage('A success toast for completed actions.')->render();
        echo Toast::make()->setTone('warning')->setTitle('Warning toast')->setMessage('A warning toast for attention-worthy states.')->render();
        echo Toast::make()->setTone('error')->setTitle('Error toast')->setMessage('An error toast for failed actions.')->render();
        echo Toast::make()->setTone('debug')->setTitle('Debug toast')->setMessage('A debug toast for development feedback.')->render();
        echo '</div>';
    }
);

showDemo(
    'Toast Sizes',
    'Exact setter calls for each size variant.',
    <<<'CODE'
echo '<div style="display:grid;gap:12px;">';
echo Toast::make()->setSize('sm')->setTitle('Small toast')->setMessage('Uses the sm size preset.')->render();
echo Toast::make()->setSize('md')->setTitle('Medium toast')->setMessage('Uses the md size preset.')->render();
echo Toast::make()->setSize('lg')->setTitle('Large toast')->setMessage('Uses the lg size preset.')->render();
echo '</div>';
CODE,
    function () {
        echo '<div style="display:grid;gap:12px;">';
        echo Toast::make()->setSize('sm')->setTitle('Small toast')->setMessage('Uses the sm size preset.')->render();
        echo Toast::make()->setSize('md')->setTitle('Medium toast')->setMessage('Uses the md size preset.')->render();
        echo Toast::make()->setSize('lg')->setTitle('Large toast')->setMessage('Uses the lg size preset.')->render();
        echo '</div>';
    }
);

showDemo(
    'Toast Positions',
    'Exact setter calls for each stack position.',
    <<<'CODE'
echo '<div style="display:grid;gap:12px;">';
echo Toast::make()->setPosition('top-right')->setTone('info')->setTitle('Top right')->setMessage('Positioned in the top-right corner.')->render();
echo Toast::make()->setPosition('top-left')->setTone('info')->setTitle('Top left')->setMessage('Positioned in the top-left corner.')->render();
echo Toast::make()->setPosition('bottom-right')->setTone('info')->setTitle('Bottom right')->setMessage('Positioned in the bottom-right corner.')->render();
echo Toast::make()->setPosition('bottom-left')->setTone('info')->setTitle('Bottom left')->setMessage('Positioned in the bottom-left corner.')->render();
echo '</div>';
CODE,
    function () {
        echo '<div style="display:grid;gap:12px;">';
        echo Toast::make()->setPosition('top-right')->setTone('info')->setTitle('Top right')->setMessage('Positioned in the top-right corner.')->render();
        echo Toast::make()->setPosition('top-left')->setTone('info')->setTitle('Top left')->setMessage('Positioned in the top-left corner.')->render();
        echo Toast::make()->setPosition('bottom-right')->setTone('info')->setTitle('Bottom right')->setMessage('Positioned in the bottom-right corner.')->render();
        echo Toast::make()->setPosition('bottom-left')->setTone('info')->setTitle('Bottom left')->setMessage('Positioned in the bottom-left corner.')->render();
        echo '</div>';
    }
);

showDemo(
    'Toast Auto Close',
    'Exact setter calls for the auto-close timer alias.',
    <<<'CODE'
echo '<div style="display:grid;gap:12px;">';
echo Toast::make()->setAutoCloseMs(0)->setTone('neutral')->setTitle('No auto close')->setMessage('This toast stays open until dismissed.')->render();
echo Toast::make()->setAutoCloseMs(2000)->setTone('success')->setTitle('2 second auto close')->setMessage('This toast closes automatically after 2 seconds.')->render();
echo Toast::make()->setAutoHideMs(3500)->setTone('warning')->setTitle('3.5 second auto hide')->setMessage('This uses the original auto-hide setter.')->render();
echo '</div>';
CODE,
    function () {
        echo '<div style="display:grid;gap:12px;">';
        echo Toast::make()->setAutoCloseMs(0)->setTone('neutral')->setTitle('No auto close')->setMessage('This toast stays open until dismissed.')->render();
        echo Toast::make()->setAutoCloseMs(2000)->setTone('success')->setTitle('2 second auto close')->setMessage('This toast closes automatically after 2 seconds.')->render();
        echo Toast::make()->setAutoHideMs(3500)->setTone('warning')->setTitle('3.5 second auto hide')->setMessage('This uses the original auto-hide setter.')->render();
        echo '</div>';
    }
);
