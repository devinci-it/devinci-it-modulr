<?php

use DevinciIT\Modulr\Components\PageLayout\FloatingSidebar\FloatingSidebar;

showDemo(
	'Floating Sidebar (Follows Scroll)',
	'Sidebar remains visible while page content scrolls.',
	<<<'CODE'
echo '<div style="display:grid; grid-template-columns: minmax(0, 1fr) 280px; gap:16px; align-items:start; max-height:400px; overflow:scroll; border:1px solid #e5e7eb; border-radius:12px;">';
echo '<article>...</article>';
echo FloatingSidebar::make()
	->setTitle('On this page')
	->setSlot('<a href="#">Overview</a><a href="#">Integrations</a><a href="#">Troubleshooting</a>')
	->setSide('right')
	->setTopOffset(88)
	->allowHtml(true)
	->render();
echo '</div>';
CODE,
	function () {
echo '<div style="display:grid; grid-template-columns: minmax(0, 1fr) 280px; gap:16px; align-items:start; max-height:400px; overflow:scroll; border:1px solid #e5e7eb; border-radius:12px;">';
		echo '<article style="padding:16px; border:1px solid #e5e7eb; border-radius:12px; background:#fff;">';
		echo '<h3 style="margin-top:0;">Long Content</h3>';
		for ($i = 1; $i <= 24; $i++) {
			echo '<p style="margin:0 0 10px; color:#475569;">Section paragraph ' . $i . ' for sticky-follow demonstration.</p>';
		}
		echo '</article>';

		echo FloatingSidebar::make()
			->setTitle('On this page')
			->setSlot('<a href="#">Overview</a><a href="#">Integrations</a><a href="#">Troubleshooting</a>')
			->setSide('right')
			->setTopOffset(88)
			->allowHtml(true)
			->render();
		echo '</div>';
	}
);