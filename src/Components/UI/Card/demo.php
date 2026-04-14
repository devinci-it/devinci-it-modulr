<?php

use DevinciIT\Modulr\Components\UI\Card\Card;

showDemo(
	'Slot Content (Simple)',
	'Use Card like a simple container by passing content/slot only.',
	<<<'CODE'
echo Card::make([
	'content' => 'Simple slot content inside the card.',
])->render();
CODE,
	function () {
		echo Card::make([
			'content' => 'Simple slot content inside the card.',
		])->render();
	}
);

showDemo(
	'Sectioned Card',
	'Use explicit header, content, and footer for structured layouts.',
	<<<'CODE'
echo Card::make()
	->setHeader('Monthly Revenue')
	->setContent('Revenue increased by 18% compared to last month.')
	->setFooter('Updated 2 hours ago')
	->render();
CODE,
	function () {
		echo Card::make()
			->setHeader('Monthly Revenue')
			->setContent('Revenue increased by 18% compared to last month.')
			->setFooter('Updated 2 hours ago')
			->render();
	}
);

showDemo(
	'Size Variants',
	'Use sm, md, and lg for consistent scaling.',
	<<<'CODE'
echo Card::make(['size' => 'sm', 'header' => 'Small', 'content' => 'Compact content'])->render();
echo Card::make(['size' => 'md', 'header' => 'Medium', 'content' => 'Default content'])->render();
echo Card::make(['size' => 'lg', 'header' => 'Large', 'content' => 'Spacious content'])->render();
CODE,
	function () {
		echo '<div style="display:grid; gap:14px; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">';
		echo Card::make(['size' => 'sm', 'header' => 'Small', 'content' => 'Compact content'])->render();
		echo Card::make(['size' => 'md', 'header' => 'Medium', 'content' => 'Default content'])->render();
		echo Card::make(['size' => 'lg', 'header' => 'Large', 'content' => 'Spacious content'])->render();
		echo '</div>';
	}
);

showDemo(
	'Glassmorphism Option',
	'Enable glass styling using setGlass(true) or the glass option.',
	<<<'CODE'
echo '<div style="padding:18px; border-radius:14px;  background: url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e') center/cover no-repeat;">';
echo Card::make([
	'header' => 'Glass Card',
	'content' => 'Soft translucent card over a vivid background.',
	'footer' => 'glassy=true',
	'glass' => true,
	'size' => 'md',
])->render();
echo '</div>';
CODE,
	function () {
echo "<div style='padding:18px; border-radius:14px; background: url(\"https://images.unsplash.com/photo-1507525428034-b723cf961d3e\") center/cover no-repeat;'>";
    echo Card::make([
			'header' => 'Glass Card',
			'content' => 'Soft translucent card over a vivid background.',
			'footer' => 'glassy=true',
			'glass' => true,
			'size' => 'md',
		])->render();
		echo '</div>';
	}
);

showDemo(
	'View File Content',
	'Pass a PHP view file and optional data to render rich content inside the card body.',
	<<<'CODE'
echo Card::make([
	'header' => 'Quarterly KPI',
	'footer' => 'From view file',
])->setView(
	__DIR__ . '/examples/metric.php',
	[
		'metricLabel' => 'Conversion Rate',
		'metricValue' => '12.8%',
		'metricDelta' => '+1.9% vs last quarter',
	]
)->render();
CODE,
	function () {
		echo Card::make([
			'header' => 'Quarterly KPI',
			'footer' => 'From view file',
		])->setView(
			__DIR__ . '/examples/metric.php',
			[
				'metricLabel' => 'Conversion Rate',
				'metricValue' => '12.8%',
				'metricDelta' => '+1.9% vs last quarter',
			]
		)->render();
	}
);

showDemo(
	'View File Content (Fluent)',
	'Fully fluent API style: chain all Card options and setView(...) together.',
	<<<'CODE'
echo Card::make()
	->setHeader('Weekly KPI')
	->setFooter('Fluent API example')
	->setSize('lg')
	->setGlass(true)
	->setView(
		__DIR__ . '/examples/metric.php',
		[
			'metricLabel' => 'Signup Rate',
			'metricValue' => '24.1%',
			'metricDelta' => '+3.4% vs last week',
		]
	)
	->render();
CODE,
	function () {
		echo Card::make()
			->setHeader('Weekly KPI')
			->setFooter('Fluent API example')
			->setSize('lg')
			->setGlass(true)
			->setView(
				__DIR__ . '/examples/metric.php',
				[
					'metricLabel' => 'Signup Rate',
					'metricValue' => '24.1%',
					'metricDelta' => '+3.4% vs last week',
				]
			)
			->render();
	}
);