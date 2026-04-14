document.addEventListener('DOMContentLoaded', () => {
  const setLoadingState = (pagination, isLoading) => {
    const region = pagination.closest('[data-pagination-loading-region]');

    if (!region) {
      return;
    }

    region.classList.toggle('is-loading', isLoading);
  };

  document.querySelectorAll('[data-component="pagination"]').forEach((pagination) => {
    const setCurrentPage = (nextPage) => {
      if (!Number.isFinite(nextPage) || nextPage < 1) {
        return;
      }

      pagination.dataset.currentPage = String(nextPage);

      pagination.querySelectorAll('.modulr-pagination__link').forEach((link) => {
        link.classList.remove('is-current');
        if (link.getAttribute('aria-current') === 'page') {
          link.removeAttribute('aria-current');
        }
      });

      const activeLink = pagination.querySelector(`.modulr-pagination__link[data-page="${nextPage}"]`);

      if (activeLink) {
        activeLink.classList.add('is-current');
        activeLink.setAttribute('aria-current', 'page');
      }
    };

    pagination.addEventListener('click', (event) => {
      const link = event.target.closest('.modulr-pagination__link');

      if (!link || !pagination.contains(link)) {
        return;
      }

      if (link.classList.contains('is-disabled')) {
        event.preventDefault();
        return;
      }

      const nextPage = Number.parseInt(link.dataset.page || '', 10);

      if (Number.isFinite(nextPage)) {
        setLoadingState(pagination, true);
        setCurrentPage(nextPage);
      }
    });
  });

  window.addEventListener('pageshow', () => {
    document.querySelectorAll('[data-component="pagination"]').forEach((pagination) => {
      setLoadingState(pagination, false);
    });
  });
});
