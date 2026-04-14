<?php

use DevinciIT\Modulr\Components\UI\Tooltip\Tooltip;

showDemo(
	'Basic Tooltip',
	'Simple tooltip with default top placement and dark style.',
	<<<'CODE'
echo Tooltip::make([
	'content' => 'This is a tooltip',
	'trigger' => '?',
])->render();
CODE,
	function () {
		echo Tooltip::make([
			'content' => 'This is a tooltip',
			'trigger' => '?',
		])->render();
	}
);

showDemo(
	'Placement Variants',
	'Top, right, bottom, and left placements for different layout needs.',
	<<<'CODE'
echo Tooltip::make(['content' => 'Top tooltip', 'placement' => 'top', 'trigger' => 'Top'])->render();
echo Tooltip::make(['content' => 'Right tooltip', 'placement' => 'right', 'trigger' => 'Right'])->render();
echo Tooltip::make(['content' => 'Bottom tooltip', 'placement' => 'bottom', 'trigger' => 'Bottom'])->render();
echo Tooltip::make(['content' => 'Left tooltip', 'placement' => 'left', 'trigger' => 'Left'])->render();
CODE,
	function () {
		echo '<div style="display:flex; gap:14px; align-items:center; flex-wrap:wrap;">';
		echo Tooltip::make(['content' => 'Top tooltip', 'placement' => 'top', 'trigger' => 'Top'])->render();
		echo Tooltip::make(['content' => 'Right tooltip', 'placement' => 'right', 'trigger' => 'Right'])->render();
		echo Tooltip::make(['content' => 'Bottom tooltip', 'placement' => 'bottom', 'trigger' => 'Bottom'])->render();
		echo Tooltip::make(['content' => 'Left tooltip', 'placement' => 'left', 'trigger' => 'Left'])->render();
		echo '</div>';
	}
);

showDemo(
	'Style Variants (3 Types)',
	'Use dark, light, or brand tooltip styles.',
	<<<'CODE'
echo Tooltip::make(['content' => 'Dark style', 'variant' => 'dark', 'trigger' => 'Dark'])->render();
echo Tooltip::make(['content' => 'Light style', 'variant' => 'light', 'trigger' => 'Light'])->render();
echo Tooltip::make(['content' => 'Brand style', 'variant' => 'brand', 'trigger' => 'Brand'])->render();
CODE,
	function () {
		echo '<div style="display:flex; gap:14px; align-items:center; flex-wrap:wrap;">';
		echo Tooltip::make(['content' => 'Dark style', 'variant' => 'dark', 'trigger' => 'Dark'])->render();
		echo Tooltip::make(['content' => 'Light style', 'variant' => 'light', 'trigger' => 'Light'])->render();
		echo Tooltip::make(['content' => 'Brand style', 'variant' => 'brand', 'trigger' => 'Brand'])->render();
		echo '</div>';
	}
);

showDemo(
	'Size Variants',
	'Scale trigger and tooltip bubble with sm, md, and lg.',
	<<<'CODE'
echo Tooltip::make(['content' => 'Small', 'size' => 'sm', 'trigger' => 'sm'])->render();
echo Tooltip::make(['content' => 'Medium', 'size' => 'md', 'trigger' => 'md'])->render();
echo Tooltip::make(['content' => 'Large', 'size' => 'lg', 'trigger' => 'lg'])->render();
CODE,
	function () {
		echo '<div style="display:flex; gap:14px; align-items:center; flex-wrap:wrap;">';
		echo Tooltip::make(['content' => 'Small', 'size' => 'sm', 'trigger' => 'sm'])->render();
		echo Tooltip::make(['content' => 'Medium', 'size' => 'md', 'trigger' => 'md'])->render();
		echo Tooltip::make(['content' => 'Large', 'size' => 'lg', 'trigger' => 'lg'])->render();
		echo '</div>';
	}
);