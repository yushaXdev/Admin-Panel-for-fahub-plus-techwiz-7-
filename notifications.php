<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Notifications";
$active_menu = "";
$page_css    = "page-notifications.css";
$page_js     = "page-notifications.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Notification::latest()->paginate(20)
$notifications = [
    ['id' => 1, 'type' => 'submission', 'title' => 'New submission from mika_asa',       'text' => 'Attack on Titan S4 Review',    'when' => '5 min ago',  'read' => false],
    ['id' => 2, 'type' => 'feedback',   'title' => 'New bug report',                     'text' => 'Video player not loading',      'when' => '22 min ago', 'read' => false],
    ['id' => 3, 'type' => 'user',       'title' => 'New user registered',                'text' => 'army_forever joined',           'when' => '1 hr ago',   'read' => false],
    ['id' => 4, 'type' => 'submission', 'title' => 'Submission approved',                'text' => 'BTS Concert Recap published',   'when' => '2 hr ago',   'read' => true],
    ['id' => 5, 'type' => 'system',     'title' => 'Backup completed',                   'text' => 'Nightly backup finished',       'when' => '5 hr ago',   'read' => true],
    ['id' => 6, 'type' => 'feedback',   'title' => 'Feedback resolved',                  'text' => 'Bookmark issue closed',         'when' => 'Yesterday',  'read' => true],
];

$type_meta = [
    'submission' => ['icon' => 'fa-inbox',         'tone' => 'info'],
    'feedback'   => ['icon' => 'fa-comment-dots',  'tone' => 'warn'],
    'user'       => ['icon' => 'fa-user-plus',     'tone' => 'ok'],
    'system'     => ['icon' => 'fa-server',        'tone' => 'neutral'],
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Notifications</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Notifications</h2>
    <p class="page-sub">Recent activity and system alerts.</p>
  </div>
  <button class="btn btn-ghost" id="markAllBtn">
    <i class="fa-regular fa-circle-check"></i>
    <span>Mark all as read</span>
  </button>
</div>

<div class="filters-bar">
  <select class="input filter-select" id="readFilter">
    <option value="">All</option>
    <option value="unread">Unread</option>
    <option value="read">Read</option>
  </select>
  <select class="input filter-select" id="typeFilter">
    <option value="">All types</option>
    <option value="submission">Submissions</option>
    <option value="feedback">Feedback</option>
    <option value="user">Users</option>
    <option value="system">System</option>
  </select>
</div>

<div class="notif-list" id="notifList">
  <?php foreach ($notifications as $n):
    $meta = $type_meta[$n['type']] ?? ['icon' => 'fa-bell', 'tone' => 'neutral'];
  ?>
    <article class="notif-card <?= $n['read'] ? 'is-read' : 'is-unread' ?>"
             data-type="<?= e($n['type']) ?>"
             data-read="<?= $n['read'] ? 'read' : 'unread' ?>">

      <span class="notif-dot"></span>

      <span class="notif-icon tone-<?= e($meta['tone']) ?>">
        <i class="fa-solid <?= e($meta['icon']) ?>"></i>
      </span>

      <div class="notif-body">
        <p class="notif-title"><?= e($n['title']) ?></p>
        <p class="notif-text"><?= e($n['text']) ?></p>
      </div>

      <span class="notif-time"><?= e($n['when']) ?></span>

      <button class="icon-btn notif-close" aria-label="Dismiss" data-dismiss>
        <i class="fa-solid fa-xmark"></i>
      </button>

    </article>
  <?php endforeach; ?>
</div>

<div class="empty hide" id="noResults">
  <i class="fa-regular fa-bell-slash"></i>
  <p>No notifications match your filters.</p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>