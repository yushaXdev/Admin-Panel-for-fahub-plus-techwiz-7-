<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Chatbot FAQ";
$active_menu = "chatbot";
$page_css    = "page-chatbot.css";
$page_js     = "page-chatbot.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Faq::orderBy('sort_order')->paginate(20)
$faqs = [
    ['id' => 1, 'question' => 'How do I bookmark a character?',            'category' => 'Getting Started', 'status' => 'active',   'hits' => 420, 'date' => '2025-03-12'],
    ['id' => 2, 'question' => 'How do I submit my own article?',           'category' => 'Submissions',     'status' => 'active',   'hits' => 380, 'date' => '2025-03-10'],
    ['id' => 3, 'question' => 'Is Fan Hub Plus free to use?',              'category' => 'General',         'status' => 'active',   'hits' => 620, 'date' => '2025-03-08'],
    ['id' => 4, 'question' => 'How do I reset my password?',               'category' => 'Account',         'status' => 'active',   'hits' => 540, 'date' => '2025-03-06'],
    ['id' => 5, 'question' => 'Can I download content for offline viewing?','category' => 'Media',          'status' => 'inactive', 'hits' => 210, 'date' => '2025-03-04'],
    ['id' => 6, 'question' => 'How do I change my favorite fandoms?',      'category' => 'Account',         'status' => 'active',   'hits' => 190, 'date' => '2025-03-02'],
    ['id' => 7, 'question' => 'What categories are available?',            'category' => 'General',         'status' => 'active',   'hits' => 310, 'date' => '2025-02-28'],
    ['id' => 8, 'question' => 'How do I report a bug?',                    'category' => 'Support',         'status' => 'active',   'hits' => 140, 'date' => '2025-02-24'],
];

$categories = ['General', 'Getting Started', 'Account', 'Submissions', 'Media', 'Support'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Chatbot FAQ</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Chatbot FAQ</h2>
    <p class="page-sub">Knowledge base for the AI assistant. Fans ask, bot answers.</p>
  </div>
  <button class="btn btn-primary" id="addFaqBtn">
    <i class="fa-solid fa-plus"></i>
    <span>Add FAQ</span>
  </button>
</div>

<!-- stats -->
<section class="mini-stats">
  <div class="mini-stat">
    <span class="mini-stat-label">Total FAQs</span>
    <span class="mini-stat-value">8</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">Active</span>
    <span class="mini-stat-value ok">7</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">Total Hits</span>
    <span class="mini-stat-value">2.8K</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">This Week</span>
    <span class="mini-stat-value">+142</span>
  </div>
</section>

<!-- filters -->
<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="faqSearch" placeholder="Search questions...">
  </div>
  <select class="input filter-select" id="categoryFilter">
    <option value="">All categories</option>
    <?php foreach ($categories as $c): ?>
      <option value="<?= e($c) ?>"><?= e($c) ?></option>
    <?php endforeach; ?>
  </select>
  <select class="input filter-select" id="statusFilter">
    <option value="">All status</option>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
  </select>
</div>

<!-- faq list -->
<div class="faq-list" id="faqList">
  <?php foreach ($faqs as $f): ?>
    <article class="faq-card"
             data-question="<?= e(strtolower($f['question'])) ?>"
             data-category="<?= e($f['category']) ?>"
             data-status="<?= e($f['status']) ?>">

      <div class="faq-icon">
        <i class="fa-solid fa-robot"></i>
      </div>

      <div class="faq-main">
        <h3 class="faq-question"><?= e($f['question']) ?></h3>
        <div class="faq-meta">
          <span class="cat-tag"><?= e($f['category']) ?></span>
          <span class="hits-tag"><i class="fa-regular fa-eye"></i> <?= compact_number($f['hits']) ?> hits</span>
          <span class="date-txt"><?= nice_date($f['date']) ?></span>
        </div>
      </div>

      <div class="faq-actions">
        <?= status_badge($f['status']) ?>
        <button class="icon-btn" data-edit aria-label="Edit">
          <i class="fa-regular fa-pen-to-square"></i>
        </button>
        <button class="icon-btn danger" data-confirm="Delete this FAQ?" aria-label="Delete">
          <i class="fa-regular fa-trash-can"></i>
        </button>
      </div>

    </article>
  <?php endforeach; ?>
</div>

<div class="empty hide" id="noResults">
  <i class="fa-regular fa-comment-dots"></i>
  <p>No FAQs match your filters.</p>
</div>

<!-- add/edit modal -->
<div class="modal" id="faqModal" aria-hidden="true">
  <div class="modal-overlay" data-close></div>
  <div class="modal-panel">
    <header class="modal-head">
      <h3 id="faqModalTitle">Add FAQ</h3>
      <button class="icon-btn" data-close aria-label="Close">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </header>
    <div class="modal-body">
      <form id="faqForm" class="form-grid" autocomplete="off">
        <div class="field">
          <label for="faqQuestion">Question</label>
          <input class="input" id="faqQuestion" name="question" type="text"
                 placeholder="e.g. How do I bookmark a character?" required>
        </div>
        <div class="field">
          <label for="faqAnswer">Answer</label>
          <textarea class="input" id="faqAnswer" name="answer" rows="4"
                    placeholder="The bot will say this..."></textarea>
        </div>
        <div class="field">
          <label for="faqCategory">Category</label>
          <select class="input" id="faqCategory" name="category" required>
            <?php foreach ($categories as $c): ?>
              <option value="<?= e($c) ?>"><?= e($c) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <label class="switch">
          <input type="checkbox" id="faqStatus" checked>
          <span class="switch-track"><span class="switch-thumb"></span></span>
          <span class="switch-label">Active</span>
        </label>
      </form>
    </div>
    <footer class="modal-foot">
      <button class="btn btn-ghost" data-close>Cancel</button>
      <button class="btn btn-primary" id="saveFaq" type="button">
        <i class="fa-solid fa-check"></i>
        <span>Save FAQ</span>
      </button>
    </footer>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>