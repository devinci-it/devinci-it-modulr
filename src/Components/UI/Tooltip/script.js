document.querySelectorAll('[data-component="tooltip"]').forEach((tooltip) => {
	if (tooltip.dataset.tooltipBound === 'true') {
		return;
	}

	const trigger = tooltip.querySelector('.modulr-tooltip__trigger');
	const bubble = tooltip.querySelector('.modulr-tooltip__bubble');
	if (!trigger) {
		return;
	}

	tooltip.dataset.tooltipBound = 'true';

	const open = () => {
		tooltip.dataset.open = 'true';
		trigger.setAttribute('aria-expanded', 'true');
		if (bubble) {
			bubble.setAttribute('aria-hidden', 'false');
		}
	};

	const close = () => {
		tooltip.dataset.open = 'false';
		trigger.setAttribute('aria-expanded', 'false');
		if (bubble) {
			bubble.setAttribute('aria-hidden', 'true');
		}
	};

	trigger.addEventListener('mouseenter', open);
	trigger.addEventListener('focus', open);
	trigger.addEventListener('mouseleave', close);
	trigger.addEventListener('blur', close);

	trigger.addEventListener('click', (event) => {
		event.preventDefault();

		const isOpen = tooltip.dataset.open === 'true';
		if (isOpen) {
			close();
		} else {
			open();
		}
	});

	trigger.addEventListener('keydown', (event) => {
		if (event.key === 'Escape') {
			close();
			trigger.blur();
		}
	});

	document.addEventListener('click', (event) => {
		if (!tooltip.contains(event.target)) {
			close();
		}
	});
});
