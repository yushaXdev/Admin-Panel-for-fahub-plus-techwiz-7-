// chatbot FAQ — search, filter, modal
(function () {
  const body = document.body;
  const cards = document.querySelectorAll('.faq-card');
  const searchInput = document.getElementById('faqSearch');
  const categoryFilter = document.getElementById('categoryFilter');
  const statusFilter = document.getElementById('statusFilter');
  const noResults = document.getElementById('noResults');

  const modal = document.getElementById('faqModal');
  const modalTitle = document.getElementById('faqModalTitle');
  const form = document.getElementById('faqForm');

  // open add modal
  document.getElementById('addFaqBtn')?.addEventListener('click', function () {
    modalTitle.textContent = 'Add FAQ';
    form.reset();
    document.getElementById('faqStatus').checked = true;
    openModal();
  });

  // edit
  document.querySelectorAll('[data-edit]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const card = btn.closest('.faq-card');
      modalTitle.textContent = 'Edit FAQ';
      document.getElementById('faqQuestion').value =
        card.querySelector('.faq-question').textContent.trim();
      document.getElementById('faqAnswer').value = '';
      document.getElementById('faqCategory').value =
        card.querySelector('.cat-tag').textContent.trim();
      document.getElementById('faqStatus').checked =
        card.dataset.status === 'active';
      openModal();
    });
  });

  // save
  document.getElementById('saveFaq')?.addEventListener('click', function () {
    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }
    // backend handoff: POST /admin/faqs
    closeModal();
  });

  // close
  modal?.querySelectorAll('[data-close]').forEach(function (el) {
    el.addEventListener('click', closeModal);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
  });

  function openModal() {
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    body.style.overflow = 'hidden';
    setTimeout(function () {
      document.getElementById('faqQuestion')?.focus();
    }, 100);
  }

  function closeModal() {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    body.style.overflow = '';
  }

  // filters
  function applyFilters() {
    const q = (searchInput?.value || '').toLowerCase().trim();
    const category = categoryFilter?.value || '';
    const status = statusFilter?.value || '';
    let visible = 0;

    cards.forEach(function (card) {
      const matchQ = !q || card.dataset.question.includes(q);
      const matchCat = !category || card.dataset.category === category;
      const matchStatus = !status || card.dataset.status === status;
      const show = matchQ && matchCat && matchStatus;
      card.style.display = show ? '' : 'none';
      if (show) visible++;
    });

    noResults?.classList.toggle('hide', visible > 0);
  }

  searchInput?.addEventListener('input', applyFilters);
  categoryFilter?.addEventListener('change', applyFilters);
  statusFilter?.addEventListener('change', applyFilters);
})();