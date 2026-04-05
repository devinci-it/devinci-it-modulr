document.querySelectorAll('[data-component="sidebar"]').forEach((sidebar) => {
	if (sidebar.dataset.sidebarBound === 'true') {
		return;
	}

	sidebar.dataset.sidebarBound = 'true';

	const toggle = sidebar.querySelector('[data-sidebar-toggle]');
	const panel = sidebar.querySelector('[data-sidebar-panel]');
	const toggleIcon = sidebar.querySelector('[data-sidebar-toggle-icon]');
	const expandedLabel = sidebar.dataset.expandedLabel || 'Hide menu';
	const collapsedLabel = sidebar.dataset.collapsedLabel || 'Show menu';

	if (!toggle || !panel) {
		return;
	}

	const setExpanded = (expanded) => {
		sidebar.dataset.expanded = expanded ? 'true' : 'false';
		toggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
		toggle.setAttribute('aria-label', expanded ? expandedLabel : collapsedLabel);
		if (toggleIcon) {
			toggleIcon.textContent = expanded ? '×' : '☰';
		}
	};

	toggle.addEventListener('click', () => {
		setExpanded(sidebar.dataset.expanded !== 'true');
	});

	setExpanded(sidebar.dataset.expanded === 'true');
});
