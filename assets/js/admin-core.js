// global utilities — backend dev can extend
(function () {
  // auto-dismiss alert messages
  document.querySelectorAll('.alert[data-dismiss]').forEach(function (el) {
    setTimeout(function () {
      el.style.transition = 'opacity .3s';
      el.style.opacity = '0';
      setTimeout(function () { el.remove(); }, 300);
    }, 4000);
  });

  // confirm on danger actions
  document.querySelectorAll('[data-confirm]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      if (!confirm(el.dataset.confirm)) e.preventDefault();
    });
  });
})();