<?php

use DevinciIT\Modulr\Components\Navigation\UnderlinePanels\UnderlinePanels;

showDemo(
    'UnderlinePanels In-Page Tabs',
    'Use UnderlinePanels when activating a tab switches content on the same page without changing URL.',
    <<<'CODE'
echo UnderlinePanels::make()
    ->setTabs([
        [
            'id' => 'overview',
            'label' => 'Overview',
            'panel' => '<h4>Overview</h4><p>Repository pulse, contribution graph, and summary metrics.</p>',
        ],
        [
            'id' => 'details',
            'label' => 'Details',
            'panel' => '<h4>Details</h4><p>Language breakdown, branch protections, and release cadence.</p>',
        ],
        [
            'id' => 'activity',
            'label' => 'Activity',
            'panel' => '<h4>Activity</h4><p>Recent commits, issue updates, and deployment history.</p>',
        ],
    ])
    ->allowHtml(true)
    ->setActiveTab('details')
    ->render();
CODE,
    function () {
        echo UnderlinePanels::make()
            ->setTabs([
                [
                    'id' => 'overview',
                    'label' => 'Overview',
                    'panel' => '<h4>Overview</h4><p>Repository pulse, contribution graph, and summary metrics.</p>',
                ],
                [
                    'id' => 'details',
                    'label' => 'Details',
                    'panel' => '<h4>Details</h4><p>Language breakdown, branch protections, and release cadence.</p>',
                ],
                [
                    'id' => 'activity',
                    'label' => 'Activity',
                    'panel' => '<h4>Activity</h4><p>Recent commits, issue updates, and deployment history.</p>',
                ],
            ])
            ->allowHtml(true)
            ->setActiveTab('details')
            ->render();
    }
);

showDemo(
    'UnderlinePanels Disabled Tab',
    'Tabs can be disabled, but they still remain part of the same in-page tab context.',
    <<<'CODE'
echo UnderlinePanels::make()
    ->setTabs([
        ['id' => 'daily', 'label' => 'Daily', 'panel' => '<p>Daily report content.</p>'],
        ['id' => 'weekly', 'label' => 'Weekly', 'panel' => '<p>Weekly report content.</p>', 'disabled' => true],
        ['id' => 'monthly', 'label' => 'Monthly', 'panel' => '<p>Monthly report content.</p>'],
    ])
    ->allowHtml(true)
    ->setActiveTab('daily')
    ->render();
CODE,
    function () {
        echo UnderlinePanels::make()
            ->setTabs([
                ['id' => 'daily', 'label' => 'Daily', 'panel' => '<p>Daily report content.</p>'],
                ['id' => 'weekly', 'label' => 'Weekly', 'panel' => '<p>Weekly report content.</p>', 'disabled' => true],
                ['id' => 'monthly', 'label' => 'Monthly', 'panel' => '<p>Monthly report content.</p>'],
            ])
            ->allowHtml(true)
            ->setActiveTab('daily')
            ->render();
    }
);

showDemo(
    'UnderlinePanels Panel View Path',
    'Pass panelView to render a tab panel from a PHP view file instead of inline markup.',
    <<<'CODE'
echo UnderlinePanels::make()
    ->setTabs([
        ['id' => 'summary', 'label' => 'Summary', 'panel' => '<p>Inline summary content.</p>'],
        [
            'id' => 'release-notes',
            'label' => 'Release Notes',
            'panelView' => __DIR__ . '/examples/release-notes.php',
            'panelData' => [
                'version' => 'v2.4.0',
                'items' => ['New tree navigation transitions', 'Faster demo bootstrap', 'Improved keyboard handling'],
            ],
        ],
    ])
    ->allowHtml(true)
    ->setActiveTab('release-notes')
    ->render();
CODE,
    function () {
        echo UnderlinePanels::make()
            ->setTabs([
                ['id' => 'summary', 'label' => 'Summary', 'panel' => '<p>Inline summary content.</p>'],
                [
                    'id' => 'release-notes',
                    'label' => 'Release Notes',
                    'panelView' => __DIR__ . '/examples/release-notes.php',
                    'panelData' => [
                        'version' => 'v2.4.0',
                        'items' => ['New tree navigation transitions', 'Faster demo bootstrap', 'Improved keyboard handling'],
                    ],
                ],
            ])
            ->allowHtml(true)
            ->setActiveTab('release-notes')
            ->render();
    }
);
