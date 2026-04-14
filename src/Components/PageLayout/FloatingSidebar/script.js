document.addEventListener("DOMContentLoaded", () => {
  const panel = document.querySelector(".modulr-floating-sidebar__panel");
  if (!panel) return;

  let current = 0;
  let target = 0;

  console.log("FloatingSidebar initialized");

  window.addEventListener("scroll", () => {
    target = Math.min(window.scrollY * 0.05, 12);
  });

  function animate() {
    current += (target - current) * 0.1;
    panel.style.transform = `translateY(${current}px)`;
    requestAnimationFrame(animate);
  }

  animate();
});
