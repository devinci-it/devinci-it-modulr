document.addEventListener('DOMContentLoaded', () => {
	const POSITION_CLASSES = ['top-right', 'top-left', 'bottom-right', 'bottom-left'];
	const DEFAULT_STACK_POSITION = 'top-right';

	const closeToast = (toast) => {
		if (!toast || toast.dataset.toastClosing === 'true') {
			return;
		}

		toast.dataset.toastClosing = 'true';
		if (toast.classList.contains('is-open') || toast.dataset.toastTemplate !== 'true') {
			toast.style.display = 'flex';
		}
		toast.classList.remove('is-open');
		toast.setAttribute('aria-hidden', 'true');
		toast.style.pointerEvents = 'none';

		window.setTimeout(() => {
			if (toast.dataset.toastTemplate === 'true') {
				toast.dataset.toastClosing = 'false';
				return;
			}

			if (toast.parentElement) {
				toast.parentElement.removeChild(toast);
			}
		}, 240);
	};

	const openToast = (toast) => {
		if (!toast) {
			return;
		}

		toast.style.display = 'flex';
		toast.style.pointerEvents = 'auto';
		toast.getBoundingClientRect();

		window.requestAnimationFrame(() => {
			toast.classList.add('is-open');
			toast.dataset.toastClosing = 'false';
		});
	};

	const registerToast = (toast) => {
		if (!toast || toast.dataset.toastBound === 'true') {
			return;
		}

		toast.dataset.toastBound = 'true';

		const autoHideMs = Number.parseInt(toast.dataset.autoCloseMs || toast.dataset.autoHide || '0', 10);

		toast.addEventListener('click', (event) => {
			const closeTrigger = event.target.closest('[data-toast-close]');
			if (!closeTrigger || !toast.contains(closeTrigger)) {
				return;
			}

			closeToast(toast);
		});

		if (Number.isFinite(autoHideMs) && autoHideMs > 0) {
			window.setTimeout(() => {
				closeToast(toast);
			}, autoHideMs);
		}
	};

	const resolveAnchor = (selector) => {
		if (!selector) {
			return document.body;
		}

		const anchor = document.querySelector(selector);
		if (!anchor) {
			return document.body;
		}

		if (anchor.tagName === 'IFRAME') {
			try {
				const iframeBody = anchor.contentDocument && anchor.contentDocument.body;
				return iframeBody || document.body;
			} catch (error) {
				return document.body;
			}
		}

		return anchor;
	};

	const getToastPosition = (toast) => {
		if (!toast) {
			return DEFAULT_STACK_POSITION;
		}

		const declaredPosition = toast.getAttribute('data-toast-position') || '';
		if (POSITION_CLASSES.includes(declaredPosition)) {
			return declaredPosition;
		}

		for (const position of POSITION_CLASSES) {
			if (toast.classList.contains(`modulr-toast--${position}`)) {
				return position;
			}
		}

		return DEFAULT_STACK_POSITION;
	};

	const ensureStack = (anchor, position) => {
		const stackSelector = `[data-toast-anchor-stack="true"][data-toast-position="${position}"]`;
		const existing = anchor.querySelector(stackSelector);
		if (existing) {
			return existing;
		}

		const anchorStyle = window.getComputedStyle(anchor);
		if (anchorStyle.position === 'static') {
			anchor.style.position = 'relative';
		}

		const created = document.createElement('div');
		created.className = `modulr-toast-stack modulr-toast-stack--${position}`;
		created.setAttribute('data-toast-anchor-stack', 'true');
		created.setAttribute('data-toast-position', position);
		anchor.appendChild(created);

		return created;
	};

	document.querySelectorAll('[data-component="toast"]').forEach((toast) => {
		registerToast(toast);
	});

	document.querySelectorAll('[data-toast-trigger]').forEach((trigger) => {
		trigger.addEventListener('click', (event) => {
			event.preventDefault();

			const templateSelector = trigger.getAttribute('data-toast-trigger');
			if (!templateSelector) {
				return;
			}

			const template = document.querySelector(templateSelector);
			if (!template) {
				return;
			}

			const anchorSelector = trigger.getAttribute('data-toast-anchor') || '';
			const anchor = resolveAnchor(anchorSelector);

			const toast = template.cloneNode(true);
			const position = getToastPosition(toast);
			const stack = ensureStack(anchor, position);

			toast.dataset.toastTemplate = 'false';
			toast.dataset.toastBound = 'false';
			toast.dataset.toastClosing = 'false';
			toast.removeAttribute('id');
			toast.setAttribute('aria-hidden', 'false');
			toast.style.display = 'none';
			toast.style.pointerEvents = 'auto';

			if (trigger.dataset.toastOverrideTone) {
				const tone = trigger.dataset.toastOverrideTone;
				['neutral', 'info', 'warning', 'error', 'success', 'debug', 'alert', 'default'].forEach((name) => {
					toast.classList.remove(`modulr-toast--${name}`);
				});
				toast.classList.add(`modulr-toast--${tone}`);
			}

			stack.appendChild(toast);
			registerToast(toast);
			openToast(toast);
		});
	});
});
