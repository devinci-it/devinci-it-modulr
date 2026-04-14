<?php

use DevinciIT\Modulr\Components\Navigation\UnderlineNav\UnderlineNav;

showDemo(
    'UnderlineNav URL Tabs',
    'Use UnderlineNav when activating a tab changes the URL.',
    <<<'CODE'
echo UnderlineNav::make()
    ->setTabs([
        ['label' => 'Code', 'href' => '/repo/modulr/code'],
        ['label' => 'Issues', 'href' => '/repo/modulr/issues'],
        ['label' => 'Pull Requests', 'href' => '/repo/modulr/pulls'],
        ['label' => 'Actions', 'href' => '/repo/modulr/actions'],
    ])
    ->setCurrentUrl('/repo/modulr/issues')
    ->render();
CODE,
    function () {
        echo UnderlineNav::make()
            ->setTabs([
                ['label' => 'Code', 'href' => '/repo/modulr/code'],
                ['label' => 'Issues', 'href' => '/repo/modulr/issues'],
                ['label' => 'Pull Requests', 'href' => '/repo/modulr/pulls'],
                ['label' => 'Actions', 'href' => '/repo/modulr/actions'],
            ])
            ->setCurrentUrl('/repo/modulr/issues')
            ->render();
    }
);

showDemo(
    'UnderlineNav Prefix Matching',
    'Prefix matching keeps a top-level tab active across nested URLs.',
    <<<'CODE'
echo UnderlineNav::make()
    ->setTabs([
        ['label' => 'Overview', 'href' => '/docs'],
        ['label' => 'API', 'href' => '/docs/api'],
        ['label' => 'Guides', 'href' => '/docs/guides'],
        ['label' => 'Settings', 'href' => '/docs/settings'],
    ])
    ->setMatchMode('prefix')
    ->setCurrentUrl('/docs/api/authentication/tokens')
    ->render();
CODE,
    function () {
        echo UnderlineNav::make()
            ->setTabs([
                ['label' => 'Overview', 'href' => '/docs'],
                ['label' => 'API', 'href' => '/docs/api'],
                ['label' => 'Guides', 'href' => '/docs/guides'],
                ['label' => 'Settings', 'href' => '/docs/settings'],
            ])
            ->setMatchMode('prefix')
            ->setCurrentUrl('/docs/api/authentication/tokens')
            ->render();
    }
);
