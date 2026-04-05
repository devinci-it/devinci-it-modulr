<?php

use DevinciIT\Modulr\Components\PageLayout\Sidebar\Sidebar;
use DevinciIT\Modulr\Components\PageLayout\Sidebar\SidebarItem;

showDemo(
	'Sidebar',
	'A Modulr page layout sidebar with a hide/show toggle and active states.',
	<<<'CODE'
echo Sidebar::make([
	'expanded' => true,
])->addMenu('Main', [
	SidebarItem::make(['id' => 'sidebar-dashboard', 'label' => 'Dashboard', 'href' => '/dashboard', 'icon' => '🏠', 'active' => true]),
	SidebarItem::make(['id' => 'sidebar-reports', 'label' => 'Reports', 'href' => '/reports', 'icon' => '📊']),
	SidebarItem::make(['id' => 'sidebar-settings', 'label' => 'Settings', 'href' => '/settings', 'icon' => '⚙️']),
])->render();
CODE,
	function () {
		echo Sidebar::make([
			'expanded' => true,
			'toggleLabel' => 'Hide menu',
		])->addMenu('Main', [
			SidebarItem::make(['id' => 'sidebar-dashboard', 'label' => 'Dashboard', 'href' => '/dashboard', 'icon' => '🏠', 'active' => true]),
			SidebarItem::make(['id' => 'sidebar-reports', 'label' => 'Reports', 'href' => '/reports', 'icon' => '📊']),
			SidebarItem::make(['id' => 'sidebar-settings', 'label' => 'Settings', 'href' => '/settings', 'icon' => '⚙️']),
		])->addMenu('More', [
			SidebarItem::make(['id' => 'sidebar-profile', 'label' => 'Profile', 'href' => '/profile', 'icon' => '👤']),
			SidebarItem::make(['id' => 'sidebar-billing', 'label' => 'Billing', 'href' => '/billing', 'icon' => '💳']),
		])->render();
	}
);

showDemo(
	'Collapsed Variant',
	'Use the compact state to show a slim sidebar and rely on the toggle button to expand it.',
	<<<'CODE'
echo Sidebar::make([
	'expanded' => false,
	'variant' => 'compact',
])->addMenu('Main', [
	SidebarItem::make(['id' => 'sidebar-dashboard-compact', 'label' => 'Dashboard', 'href' => '/dashboard', 'icon' => '🏠']),
	SidebarItem::make(['id' => 'sidebar-reports-compact', 'label' => 'Reports', 'href' => '/reports', 'icon' => '📊']),
])->render();
CODE,
	function () {
		echo Sidebar::make([
			'expanded' => false,
			'variant' => 'compact',
			'toggleLabel' => 'Show menu',
		])->addMenu('Main', [
			SidebarItem::make(['id' => 'sidebar-dashboard-compact', 'label' => 'Dashboard', 'href' => '/dashboard', 'icon' => '🏠']),
			SidebarItem::make(['id' => 'sidebar-reports-compact', 'label' => 'Reports', 'href' => '/reports', 'icon' => '📊']),
		])->render();
	}
);