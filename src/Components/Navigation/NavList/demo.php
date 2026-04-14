<?php

use DevinciIT\Modulr\Components\Navigation\NavList\NavList;

showDemo(
	'NavList Basic',
	'Vertical list of links for parent-detail navigation.',
	<<<'CODE'
echo NavList::make()
	->setItems([
		['label' => 'Overview', 'href' => '/project/overview'],
		['label' => 'Tasks', 'href' => '/project/tasks'],
		['label' => 'Files', 'href' => '/project/files'],
	])
	->setCurrentPath('/project/tasks')
	->render();
CODE,
	function () {
		echo NavList::make()
			->setItems([
				['label' => 'Overview', 'href' => '/project/overview'],
				['label' => 'Tasks', 'href' => '/project/tasks'],
				['label' => 'Files', 'href' => '/project/files'],
			])
			->setCurrentPath('/project/tasks')
			->render();
	}
);

showDemo(
	'NavList Sections',
	'Grouped links with icon and badge support.',
	<<<'CODE'
echo NavList::make()
	->setSections([
		[
			'label' => 'Project',
			'items' => [
				['label' => 'Summary', 'href' => '/summary', 'icon' => 'S'],
				['label' => 'Issues', 'href' => '/issues', 'icon' => 'I', 'badge' => '12'],
			],
		],
		[
			'label' => 'Administration',
			'items' => [
				['label' => 'Members', 'href' => '/members', 'icon' => 'M'],
				['label' => 'Billing', 'href' => '/billing', 'icon' => 'B', 'disabled' => true],
			],
		],
	])
	->setInset(true)
	->render();
CODE,
	function () {
		echo NavList::make()
			->setSections([
				[
					'label' => 'Project',
					'items' => [
						['label' => 'Summary', 'href' => '/summary', 'icon' => 'S'],
						['label' => 'Issues', 'href' => '/issues', 'icon' => 'I', 'badge' => '12'],
					],
				],
				[
					'label' => 'Administration',
					'items' => [
						['label' => 'Members', 'href' => '/members', 'icon' => 'M'],
						['label' => 'Billing', 'href' => '/billing', 'icon' => 'B', 'disabled' => true],
					],
				],
			])
			->setInset(true)
			->render();
	}
);