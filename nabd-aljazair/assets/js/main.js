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

  /* ---- Drag-to-scroll for the desktop category menu bar (mouse users get
     the same free horizontal movement touch users already have) ---------- */
  document.querySelectorAll("[data-nabd-drag-scroll]").forEach(function (el) {
    var isDown = false;
    var startX = 0;
    var startScroll = 0;
    var moved = false;

    el.addEventListener("mousedown", function (e) {
      isDown = true;
      moved = false;
      startX = e.clientX;
      startScroll = el.scrollLeft;
    });

    window.addEventListener("mouseup", function () {
      isDown = false;
    });

    el.addEventListener("mouseleave", function () {
      isDown = false;
    });

    el.addEventListener("mousemove", function (e) {
      if (!isDown) return;
      var dx = e.clientX - startX;
      if (Math.abs(dx) > 4) moved = true;
      // RTL elements report scrollLeft in [-max, 0], the mirror image of the
      // usual [0, max] — so the drag math flips sign versus an LTR bar.
      // This site is RTL-only, so that's hardcoded rather than detected.
      el.scrollLeft = startScroll + dx;
    });

    // A real drag shouldn't also follow the link it started on.
    el.addEventListener(
      "click",
      function (e) {
        if (moved) {
          e.preventDefault();
          moved = false;
        }
      },
      true
    );
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
