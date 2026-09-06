// Padel Anggun — interaksi UI (reveal on scroll, animasi baris tabel, sidebar admin)
document.addEventListener('DOMContentLoaded', function () {
  // Reveal elemen saat discroll ke viewport
  var revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    revealEls.forEach(function (el) { io.observe(el); });
  } else {
    revealEls.forEach(function (el) { el.classList.add('is-visible'); });
  }

  // Baris tabel muncul bertahap (halaman admin)
  document.querySelectorAll('tbody tr').forEach(function (row, i) {
    row.classList.add('row-in');
    row.style.animationDelay = (i * 0.05) + 's';
  });

  // Catatan: status "aktif" pada nav-underline sekarang ditentukan oleh
  // Blade (request()->routeIs(...)) di partials/nav.blade.php & admin-sidebar.blade.php,
  // bukan lagi dicocokkan lewat nama file .html di sini.

  // Sidebar admin: minimize / perbesar
  var sidebarToggle = document.getElementById('pa-sidebar-toggle');
  var STORAGE_KEY = 'pa_sidebar_collapsed';

  function applySidebarState(collapsed) {
    document.body.classList.toggle('pa-sidebar-collapsed', collapsed);
    var icon = document.getElementById('pa-sidebar-toggle-icon');
    if (icon) icon.textContent = collapsed ? 'chevron_right' : 'chevron_left';
    if (sidebarToggle) {
      sidebarToggle.setAttribute('aria-expanded', String(!collapsed));
    }
  }

  var savedState = localStorage.getItem(STORAGE_KEY) === '1';
  applySidebarState(savedState);

  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
      var collapsed = !document.body.classList.contains('pa-sidebar-collapsed');
      applySidebarState(collapsed);
      localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
    });
  }

  // Menu dropdown profil di navbar customer: tutup otomatis kalau klik di luar menu
  var navProfileMenu = document.getElementById('nav-profile-menu');
  if (navProfileMenu) {
    document.addEventListener('click', function (event) {
      var toggle = event.target.closest('button[onclick*="nav-profile-menu"]');
      var insideMenu = event.target.closest('#nav-profile-menu');
      if (!toggle && !insideMenu) {
        navProfileMenu.classList.add('hidden');
      }
    });
  }
});
