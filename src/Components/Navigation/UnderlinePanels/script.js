document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-component="underline-panels"]').forEach((root) => {
    const tabs = Array.from(root.querySelectorAll('[role="tab"][data-panel-target]'));
    const panels = Array.from(root.querySelectorAll('[role="tabpanel"]'));

    if (!tabs.length || !panels.length) {
      return;
    }

    const activate = (tab) => {
      if (!tab || tab.hasAttribute('disabled')) {
        return;
      }

      const targetId = tab.getAttribute('data-panel-target');
      if (!targetId) {
        return;
      }

      tabs.forEach((item) => {
        const isActive = item === tab;
        item.classList.toggle('is-active', isActive);
        item.setAttribute('aria-selected', isActive ? 'true' : 'false');
        item.setAttribute('tabindex', isActive ? '0' : '-1');
      });

      panels.forEach((panel) => {
        const isActive = panel.id === targetId;
        panel.classList.toggle('is-active', isActive);
        panel.hidden = !isActive;
      });
    };

    tabs.forEach((tab) => {
      tab.addEventListener('click', () => {
        activate(tab);
      });

      tab.addEventListener('keydown', (event) => {
        const enabledTabs = tabs.filter((candidate) => !candidate.hasAttribute('disabled'));
        const currentIndex = enabledTabs.indexOf(tab);
        if (currentIndex === -1) {
          return;
        }

        let nextIndex = currentIndex;

        if (event.key === 'ArrowRight') {
          nextIndex = (currentIndex + 1) % enabledTabs.length;
        } else if (event.key === 'ArrowLeft') {
          nextIndex = (currentIndex - 1 + enabledTabs.length) % enabledTabs.length;
        } else if (event.key === 'Home') {
          nextIndex = 0;
        } else if (event.key === 'End') {
          nextIndex = enabledTabs.length - 1;
        } else {
          return;
        }

        event.preventDefault();
        const nextTab = enabledTabs[nextIndex];
        nextTab.focus();
        activate(nextTab);
      });
    });
  });
});
