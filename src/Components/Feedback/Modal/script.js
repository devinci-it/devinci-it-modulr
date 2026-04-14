document.addEventListener('DOMContentLoaded', () => {
  const findModalByTarget = (target) => {
    if (!target) {
      return null;
    }

    return document.querySelector(target);
  };

  const setOpenState = (modal, isOpen) => {
    modal.classList.toggle('is-open', isOpen);
    modal.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

    if (isOpen) {
      document.body.classList.add('modulr-modal-open');
      modal.focus();
    } else if (!document.querySelector('.modulr-modal.is-open')) {
      document.body.classList.remove('modulr-modal-open');
    }
  };

  document.querySelectorAll('[data-component="modal"]').forEach((modal) => {
    modal.addEventListener('click', (event) => {
      const closeTrigger = event.target.closest('[data-modal-close]');
      if (!closeTrigger || !modal.contains(closeTrigger)) {
        return;
      }

      if (closeTrigger.getAttribute('data-modal-close') === 'backdrop'
        && modal.dataset.dismissBackdrop === 'false') {
        return;
      }

      setOpenState(modal, false);
    });
  });

  document.addEventListener('click', (event) => {
    const opener = event.target.closest('[data-modal-target]');
    if (!opener) {
      return;
    }

    const modal = findModalByTarget(opener.getAttribute('data-modal-target'));
    if (!modal) {
      return;
    }

    event.preventDefault();
    setOpenState(modal, true);
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
      return;
    }

    const openModals = Array.from(document.querySelectorAll('.modulr-modal.is-open'));
    const topModal = openModals.length ? openModals[openModals.length - 1] : null;

    if (!topModal) {
      return;
    }

    if (topModal.dataset.dismissEsc === 'false') {
      return;
    }

    setOpenState(topModal, false);
  });
});
