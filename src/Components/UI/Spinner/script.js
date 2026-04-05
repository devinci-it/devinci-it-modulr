console.log('Spinner component script loaded. Initializing animations...');

document.querySelectorAll('[data-component="spinner"][data-animate-text="true"]').forEach((spinner) => {
	if (spinner.dataset.spinnerBound === 'true') {
		return;
	}

	const textEl = spinner.querySelector('.modulr-spinner__text');
	if (!textEl) {
		return;
	}

	spinner.dataset.spinnerBound = 'true';

	const base = textEl.dataset.baseText || textEl.textContent || 'Loading';
	let i = 0;

	window.setInterval(() => {
		i = (i + 1) % 4;
		textEl.textContent = base + '.'.repeat(i);
	}, 420);
});
