document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-component="underline-nav"]').forEach((nav) => {
    const links = nav.querySelectorAll('.modulr-underline-nav__link');
    links.forEach((link) => {
      if (link.classList.contains('is-disabled')) {
        link.addEventListener('click', (event) => {
          event.preventDefault();
        });
      }
    });
  });
});
