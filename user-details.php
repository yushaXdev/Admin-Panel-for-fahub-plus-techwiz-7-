<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "User Details";
$active_menu = "users";
$page_css    = "page-user-details.css";
$page_js     = "page-user-details.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

$user = [
    'id'      => (int)($_GET['id'] ?? 1),
    'name'    => 'Mika Asa',
    'email'   => 'mika@fanhub.com',
    'role'    => 'user',
    'status'  => 'active',
    'joined'  => '2024-11-03',
    'bio'     => 'Anime fan since 2016. Attack on Titan forever.',
    'country' => 'Pakistan',
    'bookmarks'   => 42,
    'submissions' => 8,
    'feedback'    => 3,
];

$bookmarks = [
    ['title' => 'Attack on Titan S4 Review', 'type' => 'Article', 'when' => '2 days ago'],
    ['title' => 'Jinx from Arcane',           'type' => 'Cosplay','when' => '5 days ago'],
    ['title' => 'Top 10 Manga of 2025',       'type' => 'Article','when' => '1 week ago'],
];

$activity = [
    ['text' => 'Bookmarked "Attack on Titan S4 Review"', 'when' => '2 days ago'],
    ['text' => 'Submitted "Jinx from Arcane" cosplay',    'when' => '5 days ago'],
    ['text' => 'Rated "Elden Ring Boss Guide" 5 stars',   'when' => '1 week ago'],
    ['text' => 'Created account',                          'when' => 'Nov 3, 2024'],
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <a href="users.php">Users</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span><?= e($user['name']) ?></span>
</nav>

<!-- profile header -->
<article class="user-profile">

  <div class="user-profile-main">
    <span class="avatar avatar-lg"><?= e(initials($user['name'])) ?></span>
    <div class="user-info">
      <h3><?= e($user['name']) ?></h3>
      <p><?= e($user['email']) ?></p>
      <div class="user-tags">
        <span class="role-pill role-<?= e($user['role']) ?>"><?= e(ucfirst($user['role'])) ?></span>
        <?= status_badge($user['status']) ?>
      </div>
    </div>
  </div>

  <div class="user-profile-stats">
    <div>
      <strong><?= (int)$user['bookmarks'] ?></strong>
      <span>Bookmarks</span>
    </div>
    <div>
      <strong><?= (int)$user['submissions'] ?></strong>
      <span>Submissions</span>
    </div>
    <div>
      <strong><?= (int)$user['feedback'] ?></strong>
      <span>Feedback</span>
    </div>
  </div>

  <div class="user-profile-actions">
    <a href="users.php" class="btn btn-ghost">
      <i class="fa-solid fa-arrow-left"></i>
      <span>Back</span>
    </a>
    <button class="btn btn-ghost" id="banUser">
      <i class="fa-solid fa-ban"></i>
      <span>Ban</span>
    </button>
    <button class="btn btn-primary" id="editUser">
      <i class="fa-regular fa-pen-to-square"></i>
      <span>Edit</span>
    </button>
  </div>

</article>

<!-- info strip -->
<div class="user-info-strip">
  <div class="info-item">
    <i class="fa-regular fa-calendar"></i>
    <div>
      <span class="info-label">Joined</span>
      <span class="info-value"><?= nice_date($user['joined']) ?></span>
    </div>
  </div>
  <div class="info-item">
    <i class="fa-solid fa-location-dot"></i>
    <div>
      <span class="info-label">Country</span>
      <span class="info-value"><?= e($user['country']) ?></span>
    </div>
  </div>
  <div class="info-item info-item-wide">
    <i class="fa-regular fa-comment"></i>
    <div>
      <span class="info-label">Bio</span>
      <span class="info-value"><?= e($user['bio']) ?></span>
    </div>
  </div>
</div>

<!-- tabs -->
<div class="tabs">
  <button class="tab is-active" data-tab="activity">Activity</button>
  <button class="tab" data-tab="bookmarks">Bookmarks</button>
  <button class="tab" data-tab="submissions">Submissions</button>
</div>

<!-- panels -->
<div class="tab-panel is-active" data-panel="activity">
  <ul class="timeline">
    <?php foreach ($activity as $a): ?>
      <li>
        <span class="timeline-dot"></span>
        <div class="timeline-body">
          <p><?= e($a['text']) ?></p>
          <span class="timeline-when"><?= e($a['when']) ?></span>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="tab-panel" data-panel="bookmarks">
  <ul class="list">
    <?php foreach ($bookmarks as $b): ?>
      <li class="list-row">
        <span class="list-icon tone-info">
          <i class="fa-regular fa-bookmark"></i>
        </span>
        <div class="list-main">
          <p class="list-title"><?= e($b['title']) ?></p>
          <p class="list-meta">
            <span class="tag"><?= e($b['type']) ?></span>
            <span class="dot">·</span>
            <?= e($b['when']) ?>
          </p>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="tab-panel" data-panel="submissions">
  <div class="empty">
    <i class="fa-regular fa-folder-open"></i>
    <p>No submissions yet.</p>
  </div>
</div>

<!-- edit modal -->
<div class="modal" id="editModal" aria-hidden="true">
  <div class="modal-overlay" data-close></div>
  <div class="modal-panel">
    <header class="modal-head">
      <h3>Edit User</h3>
      <button class="icon-btn" data-close aria-label="Close">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </header>
    <div class="modal-body">
      <form class="form-grid" autocomplete="off">
        <div class="field">
          <label>Full name</label>
          <input class="input" type="text" value="<?= e($user['name']) ?>">
        </div>
        <div class="field">
          <label>Email</label>
          <input class="input" type="email" value="<?= e($user['email']) ?>">
        </div>
        <div class="field">
          <label>Role</label>
          <select class="input">
            <option <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
            <option <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
          </select>
        </div>
      </form>
    </div>
    <footer class="modal-foot">
      <button class="btn btn-ghost" data-close>Cancel</button>
      <button class="btn btn-primary" data-close>
        <i class="fa-solid fa-check"></i>
        <span>Save Changes</span>
      </button>
    </footer>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>