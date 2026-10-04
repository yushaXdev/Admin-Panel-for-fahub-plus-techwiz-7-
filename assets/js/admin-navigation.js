// dropdown menus (notifications + profile)
(function () {
  const dropdowns = document.querySelectorAll('.dropdown');

  dropdowns.forEach(function (dd) {
    const trigger = dd.querySelector('[data-dropdown]');
    if (!trigger) return;

    trigger.addEventListener('click', function (e) {
      e.stopPropagation();

      // close others
      dropdowns.forEach(function (other) {
        if (other !== dd) other.classList.remove('is-open');
      });

      dd.classList.toggle('is-open');
    });
  });

  // outside click
  document.addEventListener('click', function () {
    dropdowns.forEach(function (dd) { dd.classList.remove('is-open'); });
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      dropdowns.forEach(function (dd) { dd.classList.remove('is-open'); });
    }
  });

  // search shortcut
  document.addEventListener('keydown', function (e) {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
      e.preventDefault();
      const input = document.querySelector('.navbar-search input');
      input && input.focus();
    }
  });
})();