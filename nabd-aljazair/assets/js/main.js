(function () {
  "use strict";

  /* ---- Dark mode ------------------------------------------------------ */
  var root = document.documentElement;

  function applyThemeIcons() {
    var isDark = root.classList.contains("dark");
    document.querySelectorAll(".nabd-theme-icon-dark").forEach(function (el) {
      el.classList.toggle("hidden", isDark);
    });
    document.querySelectorAll(".nabd-theme-icon-light").forEach(function (el) {
      el.classList.toggle("hidden", !isDark);
    });
    document.querySelectorAll(".nabd-theme-switch").forEach(function (el) {
      el.classList.toggle("bg-brand", isDark);
      el.classList.toggle("bg-ink-900/15", !isDark);
    });
    document.querySelectorAll(".nabd-theme-knob").forEach(function (el) {
      el.style.transform = isDark ? "translateX(2px)" : "translateX(22px)";
    });
  }

  function setTheme(dark) {
    root.classList.toggle("dark", dark);
    try {
      localStorage.setItem("nabd-theme", dark ? "dark" : "light");
    } catch (e) {}
    applyThemeIcons();
  }

  document.addEventListener("click", function (e) {
    if (e.target.closest("[data-nabd-theme-toggle]")) {
      setTheme(!root.classList.contains("dark"));
    }
  });
  applyThemeIcons();

  /* ---- Mobile drawer ---------------------------------------------------- */
  var drawer = document.getElementById("nabd-drawer");
  var panel = drawer ? drawer.querySelector("[data-nabd-drawer-panel]") : null;

  function openDrawer() {
    if (!drawer) return;
    drawer.classList.remove("pointer-events-none", "opacity-0");
    drawer.setAttribute("aria-hidden", "false");
    if (panel) panel.classList.remove("translate-x-full");
  }

  function closeDrawer() {
    if (!drawer) return;
    drawer.classList.add("opacity-0");
    drawer.setAttribute("aria-hidden", "true");
    if (panel) panel.classList.add("translate-x-full");
    setTimeout(function () {
      drawer.classList.add("pointer-events-none");
    }, 200);
  }

  document.addEventListener("click", function (e) {
    if (e.target.closest("[data-nabd-drawer-open]") || e.target.closest("[data-nabd-search-open]")) {
      openDrawer();
    }
    if (e.target.closest("[data-nabd-drawer-close]")) {
      closeDrawer();
    }
  });

  /* ---- Category-page tabs ------------------------------------------------ */
  document.querySelectorAll("[data-nabd-tabs]").forEach(function (tabBar) {
    var container = tabBar.parentElement;
    tabBar.querySelectorAll("[data-nabd-tab]").forEach(function (btn) {
      btn.addEventListener("click", function () {
        var key = btn.getAttribute("data-nabd-tab");

        tabBar.querySelectorAll("[data-nabd-tab]").forEach(function (b) {
          var active = b === btn;
          b.setAttribute("data-active", active ? "1" : "0");
          b.classList.toggle("text-brand", active);
          b.classList.toggle("text-ink-700/60", !active);
          var underline = b.querySelector("[data-nabd-tab-underline]");
          if (underline) underline.classList.toggle("hidden", !active);
        });

        container.querySelectorAll("[data-nabd-tab-panel]").forEach(function (panelEl) {
          panelEl.classList.toggle("hidden", panelEl.getAttribute("data-nabd-tab-panel") !== key);
        });
      });
    });
  });

  /* ---- Utility-bar date (client-rendered like the rest of the site was, to
     avoid any server/client locale mismatch) ------------------------------ */
  var WEEKDAYS = ["الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"];
  var MONTHS = ["جانفي", "فيفري", "مارس", "أفريل", "ماي", "جوان", "جويلية", "أوت", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
  var dateEl = document.getElementById("nabd-date");
  if (dateEl) {
    var today = new Date();
    dateEl.textContent = WEEKDAYS[today.getDay()] + "، " + today.getDate() + " " + MONTHS[today.getMonth()] + " " + today.getFullYear();
  }
})();
