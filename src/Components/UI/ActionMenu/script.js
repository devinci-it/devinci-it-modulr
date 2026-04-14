document.querySelectorAll('[data-component="action-menu"]').forEach((menu) => {
	if (menu.dataset.actionMenuBound === 'true') {
		return;
	}

	menu.dataset.actionMenuBound = 'true';
});
