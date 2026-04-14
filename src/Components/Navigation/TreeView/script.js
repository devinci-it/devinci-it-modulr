document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('[data-component="tree-view"]').forEach((tree) => {
    const singleOpen = tree.dataset.singleOpen === "true";

    tree.addEventListener("click", (e) => {
      const toggle = e.target.closest("[data-tree-toggle]");
      if (!toggle) return;

      const item = toggle.closest("[data-tree-item]");
      if (!item) return;

      const isOpen = item.classList.contains("is-open");

      // close others if single open mode
      if (singleOpen) {
        tree.querySelectorAll("[data-tree-item].is-open").forEach((el) => {
          if (el !== item) collapse(el);
        });
      }

      if (isOpen) {
        collapse(item);
      } else {
        expand(item);
      }
    });

    function expand(item) {
      const panel = item.querySelector("[data-tree-children]");
      if (!panel) return;

      item.classList.add("is-open");

      panel.style.height = "0px";
      requestAnimationFrame(() => {
        panel.style.height = panel.scrollHeight + "px";
      });

      panel.addEventListener(
        "transitionend",
        () => {
          panel.style.height = "auto";
        },
        { once: true }
      );
    }

    function collapse(item) {
      const panel = item.querySelector("[data-tree-children]");
      if (!panel) return;

      panel.style.height = panel.scrollHeight + "px";

      requestAnimationFrame(() => {
        panel.style.height = "0px";
      });

      item.classList.remove("is-open");
    }
  });
});