(function initModulrNavbar() {
	const navbars = document.querySelectorAll('[data-component="navbar"][data-behavior="hide-on-scroll"]');

	if (!navbars.length) {
		return;
	}

	let lastY = window.scrollY || 0;
	let ticking = false;

	const update = () => {
		const currentY = window.scrollY || 0;

		navbars.forEach((navbar) => {
			if (currentY <= 16) {
				navbar.classList.remove('is-hidden');
				return;
			}

			if (currentY > lastY + 4) {
				navbar.classList.add('is-hidden');
			} else if (currentY < lastY - 4) {
				navbar.classList.remove('is-hidden');
			}
		});

		lastY = currentY;
		ticking = false;
	};

	window.addEventListener('scroll', () => {
		if (!ticking) {
			window.requestAnimationFrame(update);
			ticking = true;
		}
	}, { passive: true });
})();
