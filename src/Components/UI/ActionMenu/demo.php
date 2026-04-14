<?php

use DevinciIT\Modulr\Components\UI\ActionMenu\ActionMenu;

showDemo(
	'Action Menu',
	'A fluent Modulr component that renders action links with optional icons.',
	<<<'CODE'
echo ActionMenu::make()
	->addAction('Dashboard', '/dashboard', '/icons/dashboard.svg')
	->addAction('Settings', '/settings', '/icons/settings.svg')
	->addAction('Reports', '/reports', '📊')
	->render();
CODE,
	function () {
		echo ActionMenu::make()
			->addAction('Dashboard', '/dashboard', '/icons/dashboard.svg')
			->addAction('Settings', '/settings', '/icons/settings.svg')
			->addAction('Reports', '/reports', '📊')
			->render();
	}
);

showDemo(
	'Size Variants',
	'Use sm, md, and lg sizes to scale spacing, padding, and icon size.',
	<<<'CODE'
echo ActionMenu::make(['size' => 'sm'])
	->addAction('Edit', '/edit', '✏️')
	->addAction('Delete', '/delete', '🗑️')
	->render();

echo ActionMenu::make(['size' => 'md'])
	->addAction('Edit', '/edit', '✏️')
	->addAction('Delete', '/delete', '🗑️')
	->render();

echo ActionMenu::make(['size' => 'lg'])
	->addAction('Edit', '/edit', '✏️')
	->addAction('Delete', '/delete', '🗑️')
	->render();
CODE,
	function () {
		echo '<div style="display:flex; flex-direction:column; gap:16px;">';
		echo ActionMenu::make(['size' => 'sm'])
			->addAction('Edit', '/edit', '✏️')
			->addAction('Delete', '/delete', '🗑️')
			->render();

		echo ActionMenu::make(['size' => 'md'])
			->addAction('Edit', '/edit', '✏️')
			->addAction('Delete', '/delete', '🗑️')
			->render();

		echo ActionMenu::make(['size' => 'lg'])
			->addAction('Edit', '/edit', '✏️')
			->addAction('Delete', '/delete', '🗑️')
			->render();
		echo '</div>';
	}
);