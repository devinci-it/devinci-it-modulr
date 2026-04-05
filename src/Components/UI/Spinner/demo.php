<?php

use DevinciIT\Modulr\Components\UI\Spinner\Spinner;

showDemo(
	'Basic Spinner',
	'Default ring spinner with no text.',
	<<<'CODE'
echo Spinner::make()->render();
CODE,
	function () {
		echo Spinner::make()->render();
	}
);

showDemo(
	'Optional Text + Animated Text',
	'Add helper text and optionally animate trailing dots via JS.',
	<<<'CODE'
echo Spinner::make()
	->setText('Loading data')
	->setAnimateText(true)
	->render();
CODE,
	function () {
		echo Spinner::make()
			->setText('Loading data')
			->setAnimateText(true)
			->render();
	}
);

showDemo(
	'Size Variants (sm / md / lg)',
	'Use size variants to scale spinner visuals and text proportionally.',
	<<<'CODE'
echo Spinner::make(['size' => 'sm', 'text' => 'Small'])->render();
echo Spinner::make(['size' => 'md', 'text' => 'Medium'])->render();
echo Spinner::make(['size' => 'lg', 'text' => 'Large'])->render();
CODE,
	function () {
		echo '<div style="display:flex; flex-direction:column; gap:12px;">';
		echo Spinner::make(['size' => 'sm', 'text' => 'Small'])->render();
		echo Spinner::make(['size' => 'md', 'text' => 'Medium'])->render();
		echo Spinner::make(['size' => 'lg', 'text' => 'Large'])->render();
		echo '</div>';
	}
);

showDemo(
	'Style Variants (ring / dots / pulse)',
	'Switch between three spinner styles with the same API.',
	<<<'CODE'
echo Spinner::make(['variant' => 'ring', 'text' => 'Ring'])->render();
echo Spinner::make(['variant' => 'dots', 'text' => 'Dots'])->render();
echo Spinner::make(['variant' => 'pulse', 'text' => 'Pulse'])->render();
CODE,
	function () {
		echo '<div style="display:flex; flex-direction:column; gap:12px;">';
		echo Spinner::make(['variant' => 'ring', 'text' => 'Ring'])->render();
		echo Spinner::make(['variant' => 'dots', 'text' => 'Dots'])->render();
		echo Spinner::make(['variant' => 'pulse', 'text' => 'Pulse'])->render();
		echo '</div>';
	}
);