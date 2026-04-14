<?php

use DevinciIT\Modulr\Components\Navigation\TreeView\TreeView;

showDemo(
    'TreeView Navigation',
    'A hierarchical list for parent-detail navigation. It can act as navigation or selection depending on the activation mode.',
    <<<'CODE'
echo TreeView::make()
    ->setActivationMode('navigation')
    ->setCurrentPath('/projects/modulr/tasks/board')
    ->setItems([
        [
            'label' => 'Project',
            'children' => [
                ['label' => 'Overview', 'href' => '/projects/modulr/overview'],
                ['label' => 'Tasks', 'href' => '/projects/modulr/tasks'],
                ['label' => 'Files', 'href' => '/projects/modulr/files'],
            ],
        ],
        [
            'label' => 'Details',
            'children' => [
                ['label' => 'Board', 'href' => '/projects/modulr/tasks/board'],
                ['label' => 'Calendar', 'href' => '/projects/modulr/tasks/calendar'],
            ],
        ],
    ])
    ->expandAll(true)
    ->render();
CODE,
    function () {
        echo TreeView::make()
            ->setActivationMode('navigation')
            ->setCurrentPath('/projects/modulr/tasks/board')
            ->setItems([
                [
                    'label' => 'Project',
                    'children' => [
                        ['label' => 'Overview', 'href' => '/projects/modulr/overview'],
                        ['label' => 'Tasks', 'href' => '/projects/modulr/tasks'],
                        ['label' => 'Files', 'href' => '/projects/modulr/files'],
                    ],
                ],
                [
                    'label' => 'Details',
                    'children' => [
                        ['label' => 'Board', 'href' => '/projects/modulr/tasks/board'],
                        ['label' => 'Calendar', 'href' => '/projects/modulr/tasks/calendar'],
                    ],
                ],
            ])
            ->expandAll(true)
            ->render();
    }
);

showDemo(
    'TreeView Selection Mode',
    'Use buttons instead of links when activating an option should not change the URL.',
    <<<'CODE'
echo TreeView::make()
    ->setActivationMode('selection')
    ->setItems([
        [
            'label' => 'Appearance',
            'children' => [
                ['label' => 'Theme'],
                ['label' => 'Density'],
                ['label' => 'Spacing'],
            ],
        ],
        [
            'label' => 'Access',
            'children' => [
                ['label' => 'Permissions'],
                ['label' => 'Roles'],
            ],
        ],
    ])
    ->expandPath('0')
    ->render();
CODE,
    function () {
        echo TreeView::make()
            ->setActivationMode('selection')
            ->setItems([
                [
                    'label' => 'Appearance',
                    'children' => [
                        ['label' => 'Theme'],
                        ['label' => 'Density'],
                        ['label' => 'Spacing'],
                    ],
                ],
                [
                    'label' => 'Access',
                    'children' => [
                        ['label' => 'Permissions'],
                        ['label' => 'Roles'],
                    ],
                ],
            ])
            ->expandPath('0')
            ->render();
    }
);
