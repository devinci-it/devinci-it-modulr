<?php

use DevinciIT\Modulr\Components\PageLayout\Footer\Footer;

showDemo(
	'Basic Footer Slot',
	'Simple slot content for a page footer.',
	<<<'CODE'
echo Footer::make()
	->setSlot('Built with Modulr components.')
	->render();
CODE,
	function () {
		echo Footer::make()
			->setSlot('Built with Modulr components.')
			->render();
	}
);

showDemo(
	'Footer With Left And Right',
	'Use left, slot, and right regions for legal text and links.',
	<<<'CODE'
echo Footer::make()
	->setLeft('© 2026 DevinciIT')
	->setSlot('<a href="#">Docs</a> · <a href="#">Support</a> · <a href="#">Status</a>')
	->setRight('Version 1.0.0')
	->allowHtml(true)
	->render();
CODE,
	function () {
		echo Footer::make()
			->setLeft('© 2026 DevinciIT')
			->setSlot('<a href="#">Docs</a> · <a href="#">Support</a> · <a href="#">Status</a>')
			->setRight('Version 1.0.0')
			->allowHtml(true)
			->render();
	}
);