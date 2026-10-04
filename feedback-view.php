<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 1);

$page_title  = "Feedback Detail";
$active_menu = "feedback";
$page_css    = "page-feedback-view.css";
$page_js     = "page-feedback-view.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Feedback::with('user')->findOrFail($id)
$fb = [
    'id'      => $id,
    'type'    => 'bug',
    'subject' => 'Video player not loading on mobile',
    'user'    => 'mika_asa',
    'email'   => 'mika@fanhub.com',
    'status'  => 'open',
    'date'    => '2025-03-15',
    'message' => "Hi team,\n\nI tried watching the Attack on Titan trailer on my phone (Android, Chrome) but the video player just shows a black screen. It works fine on desktop.\n\nSteps to reproduce:\n1. Open any trailer on mobile\n2. Tap play\n3. Player turns black, no controls appear\n\nPlease fix. Thanks!",
    'meta'    => [
        'device'  => 'Android 14 · Chrome 121',
        'page'    => '/media/attack-on-titan-s4',
        'user_agent' => 'Mozilla/5.0 (Linux; Android 14)...',
    ],
];

$type_meta = [
    'bug'        => ['icon' => 'fa-bug',             'label' => 'Bug Report', 'tone' => 'danger'],
    'suggestion' => ['icon' => 'fa-lightbulb',       'label' => 'Suggestion', 'tone' => 'warn'],
    'query'      => ['icon' => 'fa-circle-question', 'label' => 'Query',      'tone' => 'info'],
];

$meta = $type_meta[$fb['type']] ?? ['icon' => 'fa-comment', 'label' => 'Other', 'tone' => 'neutral'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <a href="feedback.php">Feedback</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>#<?= (int)$fb['id'] ?></span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Feedback Detail</h2>
    <p class="page-sub">View and resolve user feedback.</p>
  </div>
  <a href="feedback.php" class="btn btn-ghost">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<div class="detail-layout">

  <!-- main: feedback content -->
  <div class="detail-main">

    <div class="panel">
      <div class="panel-head">
        <div class="feedback-head">
          <span class="type-icon tone-<?= e($meta['tone']) ?>">
            <i class="fa-solid <?= e($meta['icon']) ?>"></i>
          </span>
          <div>
            <h3 class="panel-title"><?= e($fb['subject']) ?></h3>
            <p class="panel-sub">
              <span class="type-label"><?= e($meta['label']) ?></span>
              <span class="dot">·</span>
              <?= nice_date($fb['date']) ?>
            </p>
          </div>
        </div>
        <?= status_badge($fb['status']) ?>
      </div>
      <div class="panel-body">
        <div class="feedback-message">
          <?= nl2br(e($fb['message'])) ?>
        </div>
      </div>
    </div>

    <!-- technical meta (for bugs) -->
    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Technical Info</h3>
      </div>
      <div class="panel-body">
        <div class="meta-grid">
          <div class="meta-row">
            <span class="meta-label">Device</span>
            <span class="meta-value mono"><?= e($fb['meta']['device']) ?></span>
          </div>
          <div class="meta-row">
            <span class="meta-label">Page</span>
            <span class="meta-value mono"><?= e($fb['meta']['page']) ?></span>
          </div>
          <div class="meta-row">
            <span class="meta-label">User agent</span>
            <span class="meta-value mono small"><?= e($fb['meta']['user_agent']) ?></span>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- side: user + actions -->
  <aside class="detail-side">

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Submitted By</h3>
      </div>
      <div class="panel-body">
        <div class="author-block">
          <span class="avatar avatar-lg"><?= e(initials($fb['user'])) ?></span>
          <div class="author-info">
            <strong><?= e($fb['user']) ?></strong>
            <span><?= e($fb['email']) ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Actions</h3>
      </div>
      <div class="panel-body">

        <div class="field">
          <label for="adminReply">Reply (optional)</label>
          <textarea class="input" id="adminReply" rows="4"
                    placeholder="Internal note or reply to user..."></textarea>
        </div>

        <div class="actions-stack">
          <?php if ($fb['status'] !== 'resolved'): ?>
            <button class="btn btn-primary" id="resolveBtn">
              <i class="fa-solid fa-check"></i>
              <span>Mark Resolved</span>
            </button>
          <?php else: ?>
            <button class="btn btn-ghost" id="reopenBtn">
              <i class="fa-solid fa-rotate-left"></i>
              <span>Reopen</span>
            </button>
          <?php endif; ?>
          <button class="btn btn-danger" id="deleteBtn">
            <i class="fa-regular fa-trash-can"></i>
            <span>Delete</span>
          </button>
        </div>

      </div>
    </div>

  </aside>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>