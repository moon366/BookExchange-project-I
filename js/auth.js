document.addEventListener("DOMContentLoaded", () => {
  const logoutBtn = document.getElementById("logout-btn");
  const menuTrigger = document.getElementById("menu-trigger");
  const userMenuList = document.getElementById("user-menu-list");
  const navToggle = document.getElementById("nav-toggle");
  const navLinks = document.getElementById("nav-links");

  if (navToggle && navLinks) {
    navToggle.addEventListener("click", () => {
      const expanded = navLinks.classList.toggle("open");
      navToggle.setAttribute("aria-expanded", expanded);
    });

    document.addEventListener("click", (e) => {
      if (!e.target.closest(".app-header")) {
        navLinks.classList.remove("open");
        navToggle.setAttribute("aria-expanded", "false");
        if (userMenuList) {
          userMenuList.hidden = true;
          if (menuTrigger) menuTrigger.setAttribute("aria-expanded", "false");
        }
      }
    });
  }

  if (menuTrigger && userMenuList) {
    menuTrigger.addEventListener("click", (e) => {
      e.stopPropagation();
      const isOpen = !userMenuList.hidden;
      userMenuList.hidden = isOpen;
      menuTrigger.setAttribute("aria-expanded", String(!isOpen));
    });
  }

  if (logoutBtn) {
    logoutBtn.addEventListener("click", async (e) => {
      e.preventDefault();
      try {
        await apiPost("logout.php");
      } catch (_) {}
      window.location.href = "/book-exchange/pages/index.php";
    });
  }
});
