document.querySelectorAll('[data-component="nav-list"]').forEach((navList) => {
	if (navList.dataset.navListBound === 'true') {
		return;
	}

	navList.dataset.navListBound = 'true';

	navList.addEventListener('keydown', (event) => {
		const links = Array.from(navList.querySelectorAll('.modulr-nav-list__item[href]'));
		if (!links.length) {
			return;
		}

		const activeIndex = links.indexOf(document.activeElement);
		if (activeIndex === -1) {
			return;
		}

		if (event.key === 'ArrowDown') {
			event.preventDefault();
			const next = links[(activeIndex + 1) % links.length];
			next.focus();
		}

		if (event.key === 'ArrowUp') {
			event.preventDefault();
			const prev = links[(activeIndex - 1 + links.length) % links.length];
			prev.focus();
		}

		if (event.key === 'Home') {
			event.preventDefault();
			links[0].focus();
		}

		if (event.key === 'End') {
			event.preventDefault();
			links[links.length - 1].focus();
		}
	});
});
