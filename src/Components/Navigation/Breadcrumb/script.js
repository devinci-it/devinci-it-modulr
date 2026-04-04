console.log('Breadcrumb component script loaded.');

document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.modulr-breadcrumb__item');

    // Staggered entrance animation
    items.forEach((el, i) => {
        el.style.opacity = 0;
        el.style.transform = 'translateY(-4px)';

        setTimeout(() => {
            el.style.transition = 'all 180ms ease';
            el.style.opacity = 1;
            el.style.transform = 'translateY(0)';
        }, i * 40);
    });

    const toggles = document.querySelectorAll('.modulr-breadcrumb__toggle');

    toggles.forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const list = toggle.closest('.modulr-breadcrumb__list');
            if (!list) return;

            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
            const hiddenItems = list.querySelectorAll('.modulr-breadcrumb__item--hidden');

            hiddenItems.forEach((el) => {
                el.classList.toggle('modulr-breadcrumb__item--revealed', !isExpanded);
            });

            toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            toggle.setAttribute('aria-label', isExpanded ? 'Expand breadcrumb' : 'Collapse breadcrumb');
            toggle.textContent = isExpanded ? '...' : '<';
        });
    });
});