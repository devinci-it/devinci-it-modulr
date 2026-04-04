console.log('Token component script loaded');

document.addEventListener('click', function (e) {

    /* =========================
     * REMOVE TOKEN
     * ========================= */
    const removeBtn = e.target.closest('.modulr-token__remove');

    if (removeBtn) {
        const token = removeBtn.closest('.modulr-token');

        if (!token) return;

        token.remove();

        document.dispatchEvent(new CustomEvent('token:removed', {
            detail: { token }
        }));

        return;
    }

    /* =========================
     * TOGGLE TOKEN GROUP (SHOW MORE)
     * ========================= */
    const toggleBtn = e.target.closest('[data-modulr-token-toggle]');

    if (toggleBtn) {
        const group = toggleBtn.closest('[data-modulr-token-group]');
        if (!group) return;

        const hidden = group.querySelector('.modulr-token-group__hidden');
        if (!hidden) return;

        const isHidden = hidden.hasAttribute('hidden');

        if (isHidden) {
            hidden.removeAttribute('hidden');
            toggleBtn.textContent = 'Show less';
        } else {
            hidden.setAttribute('hidden', '');

            const count = hidden.children.length;
            toggleBtn.textContent = `+${count}`;
        }
    }
});