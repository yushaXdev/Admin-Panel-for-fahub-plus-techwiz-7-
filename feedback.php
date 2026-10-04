<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Feedback";
$active_menu = "feedback";
$page_css    = "page-feedback.css";
$page_js     = "page-feedback.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Feedback::with('user')->latest()->paginate(15)
$feedbacks = [
    ['id' => 1, 'type' => 'bug',        'subject' => 'Video player not loading on mobile',   'user' => 'mika_asa',     'status' => 'open',     'date' => '2025-03-15'],
    ['id' => 2, 'type' => 'suggestion', 'subject' => 'Add dark mode to public site',         'user' => 'nova_star',    'status' => 'open',     'date' => '2025-03-14'],
    ['id' => 3, 'type' => 'query',      'subject' => 'How do I bookmark a character?',       'user' => 'chloe_arts',   'status' => 'resolved', 'date' => '2025-03-13'],
    ['id' => 4, 'type' => 'bug',        'subject' => 'Search returns wrong results',         'user' => 'army_forever', 'status' => 'open',     'date' => '2025-03-12'],
    ['id' => 5, 'type' => 'suggestion', 'subject' => 'Add K-drama category',                 'user' => 'otaku_sensei', 'status' => 'resolved', 'date' => '2025-03-11'],
    ['id' => 6, 'type' => 'query',      'subject' => 'Can I submit multiple articles?',      'user' => 'pixel_wizard', 'status' => 'open',     'date' => '2025-03-10'],
    ['id' => 7, 'type' => 'bug',        'subject' => 'Image gallery flickers on Safari',     'user' => 'tarnished_01', 'status' => 'resolved', 'date' => '2025-03-09'],
    ['id' => 8, 'type' => 'suggestion', 'subject' => 'Show trending fandoms on homepage',    'user' => 'artof_chloe',  'status' => 'open',     'date' => '2025-03-08'],
];

$type_meta = [
    'bug'        => ['icon' => 'fa-bug',             'label' => 'Bug',        'tone' => 'danger'],
    'suggestion' => ['icon' => 'fa-lightbulb',       'label' => 'Suggestion', 'tone' => 'warn'],
    'query'      => ['icon' => 'fa-circle-question', 'label' => 'Query',      'tone' => 'info'],
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Feedback</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Feedback</h2>
    <p class="page-sub">Bug reports, suggestions, and user queries.</p>
  </div>
</div>

<!-- stat strip -->
<section class="mini-stats">
  <div class="mini-stat">
    <span class="mini-stat-label">Open</span>
    <span class="mini-stat-value warn">5</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">Resolved</span>
    <span class="mini-stat-value ok">3</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">Bugs</span>
    <span class="mini-stat-value danger">3</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">This week</span>
    <span class="mini-stat-value">8</span>
  </div>
</section>

<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="feedbackSearch" placeholder="Search by subject or user...">
  </div>
  <select class="input filter-select" id="typeFilter">
    <option value="">All types</option>
    <option value="bug">Bug</option>
    <option value="suggestion">Suggestion</option>
    <option value="query">Query</option>
  </select>
  <select class="input filter-select" id="statusFilter">
    <option value="">All status</option>
    <option value="open">Open</option>
    <option value="resolved">Resolved</option>
  </select>
</div>

<div class="panel">
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Type</th>
          <th>Subject</th>
          <th>User</th>
          <th>Status</th>
          <th>Date</th>
          <th class="col-actions"></th>
        </tr>
      </thead>
      <tbody id="feedbackTableBody">
        <?php foreach ($feedbacks as $f):
          $meta = $type_meta[$f['type']] ?? ['icon' => 'fa-comment', 'label' => 'Other', 'tone' => 'neutral'];
        ?>
          <tr data-subject="<?= e(strtolower($f['subject'])) ?>"
              data-user="<?= e(strtolower($f['user'])) ?>"
              data-type="<?= e($f['type']) ?>"
              data-status="<?= e($f['status']) ?>">
            <td>
              <span class="type-icon tone-<?= e($meta['tone']) ?>">
                <i class="fa-solid <?= e($meta['icon']) ?>"></i>
              </span>
            </td>
            <td>
              <a href="feedback-view.php?id=<?= (int)$f['id'] ?>" class="feedback-subject">
                <?= e($f['subject']) ?>
              </a>
            </td>
            <td>
              <div class="user-mini">
                <span class="avatar avatar-xs"><?= e(initials($f['user'])) ?></span>
                <span><?= e($f['user']) ?></span>
              </div>
            </td>
            <td><?= status_badge($f['status']) ?></td>
            <td><span class="date-txt"><?= nice_date($f['date']) ?></span></td>
            <td class="row-actions">
              <a href="feedback-view.php?id=<?= (int)$f['id'] ?>" class="icon-btn" aria-label="View">
                <i class="fa-regular fa-eye"></i>
              </a>
              <button class="icon-btn danger" data-confirm="Delete this feedback?" aria-label="Delete">
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="empty hide" id="noResults">
    <i class="fa-regular fa-comment-dots"></i>
    <p>No feedback matches your filters.</p>
  </div>

  <div class="pagination">
    <span class="page-info">Showing <strong>1–8</strong> of <strong>48</strong></span>
    <div class="page-controls">
      <button class="page-btn" disabled><i class="fa-solid fa-chevron-left"></i></button>
      <button class="page-btn is-active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>