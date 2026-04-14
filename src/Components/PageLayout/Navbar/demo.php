<?php

use DevinciIT\Modulr\Components\PageLayout\Navbar\Navbar;
use DevinciIT\Modulr\Components\UI\Button\Button;

showDemo(
	'Static Navbar',
	'Navbar stays in normal document flow and supports slot content.',
	<<<'CODE'
echo Navbar::make()
	->setStatic()
	->setBrand('Modulr')
	->setSlot('<a href="#">Home</a><a href="#">Docs</a><a href="#">Pricing</a>')
	->setActions('<button type="button">Sign in</button>')
	->allowHtml(true)
	->render();
CODE,
	function () {
		echo Navbar::make()
			->setStatic()
			->setBrand('Modulr')
			->setSlot('<a href="#">Home</a><a href="#">Docs</a><a href="#">Pricing</a>')
			->setActions('<button type="button">Sign in</button>')
			->allowHtml(true)
			->render();
	}
);

showDemo(
	'Sticky Navbar',
	'Navbar sticks to the top while scrolling.',
	<<<'CODE'
echo Navbar::make()
	->setSticky()
	->setBrand('Admin')
	->setSlot('<strong>Workspace</strong>')
	->setActions(
		Button::make()
			->setLabel('Publish')
			->setVariant('primary')
			->render()
	)
	->allowHtml(true)
	->render();
CODE,
	function () {
		echo '<div style="height: 220px; overflow: auto; border: 1px solid #e5e7eb; border-radius: 12px;">';
		echo Navbar::make()
			->setSticky()
			->setBrand('Admin')
			->setSlot('<strong>Workspace</strong>')
			->setActions(
				Button::make()
					->setLabel('Publish')
					->setVariant('primary')
					->render()
			)
			->allowHtml(true)
			->render();
		echo '<div style="padding: 16px; display:grid; gap: 10px;">';
		for ($i = 1; $i <= 18; $i++) {
			echo '<p style="margin:0; color:#334155;">Scrollable content row ' . $i . '</p>';
		}
		echo '</div></div>';
	}
);

showDemo(
	'Hide On Scroll Navbar',
	'Navbar hides while scrolling down and returns when scrolling up.',
	<<<'CODE'
echo Navbar::make()
	->setHideOnScroll()
	->setBrand('Portal')
	->setSlot('<a href="#">Overview</a><a href="#">Reports</a><a href="#">Billing</a>')
	->setActions('<button type="button">Settings</button>')
	->allowHtml(true)
	->render();
CODE,
	function () {
		echo '<div style="height: 240px; overflow: auto; border: 1px solid #e5e7eb; border-radius: 12px;">';
		echo Navbar::make()
			->setHideOnScroll()
			->setBrand('Portal')
			->setSlot('<a href="#">Overview</a><a href="#">Reports</a><a href="#">Billing</a>')
			->setActions('<button type="button">Settings</button>')
			->allowHtml(true)
			->render();
		echo '<div style="padding: 16px; display:grid; gap: 10px;">';
		for ($i = 1; $i <= 20; $i++) {
			echo '<p style="margin:0; color:#334155;">Scroll down to hide navbar, up to reveal it. Row ' . $i . '</p>';
		}
		echo '</div></div>';
	}
);