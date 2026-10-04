<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Fan Submissions";
$active_menu = "submissions";
$page_css    = "page-submissions.css";
$page_js     = "page-submissions.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Submission::with('user','category')->latest()->paginate(15)
$submissions = [
    ['id' => 1, 'title' => 'Attack on Titan S4 Review',    'user' => 'mika_asa',      'category' => 'anime',   'type' => 'article', 'status' => 'pending',  'date' => '2025-03-15', 'excerpt' => 'A deep dive into the final season.'],
    ['id' => 2, 'title' => 'Elden Ring Boss Guide',        'user' => 'tarnished_01',  'category' => 'gaming',  'type' => 'article', 'status' => 'pending',  'date' => '2025-03-14', 'excerpt' => 'Complete strategy for all main bosses.'],
    ['id' => 3, 'title' => 'BTS Concert Recap 2025',       'user' => 'army_forever',  'category' => 'kpop',    'type' => 'article', 'status' => 'approved', 'date' => '2025-03-13', 'excerpt' => 'Seoul night 3 in detail.'],
    ['id' => 4, 'title' => 'Cosplay: Jinx from Arcane',    'user' => 'artof_chloe',   'category' => 'cosplay', 'type' => 'image',   'status' => 'pending',  'date' => '2025-03-12', 'excerpt' => 'Handmade costume, 3 months of work.'],
    ['id' => 5, 'title' => 'Top 10 Manga of 2025',         'user' => 'otaku_sensei',  'category' => 'manga',   'type' => 'article', 'status' => 'approved', 'date' => '2025-03-11', 'excerpt' => 'Ranking the best manga of the year.'],
    ['id' => 6, 'title' => 'Marvel Movie Theory',          'user' => 'nova_star',     'category' => 'movies',  'type' => 'article', 'status' => 'rejected', 'date' => '2025-03-10', 'excerpt' => 'Fan theory about Phase 6.'],
    ['id' => 7, 'title' => 'My Naruto Fan Art',            'user' => 'pixel_wizard',  'category' => 'anime',   'type' => 'image',   'status' => 'pending',  'date' => '2025-03-09', 'excerpt' => 'Digital artwork of Naruto and Sasuke.'],
    ['id' => 8, 'title' => 'Spider-Verse Animation Study', 'user' => 'chloe_arts',    'category' => 'movies',  'type' => 'article', 'status' => 'pending',  'date' => '2025-03-08', 'excerpt' => 'Analysis of the animation style.'],
];

$categories = [
    'anime'    => 'Anime',
    'gaming'   => 'Gaming',
    'movies'   => 'Movies',
    'tv-shows' => 'TV Shows',
    'kpop'     => 'K-Pop',
    'comics'   => 'Comics',
    'manga'    => 'Manga',
    'cosplay'  => 'Cosplay',
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Fan Submissions</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Fan Submissions</h2>
    <p class="page-sub">Moderate content submitted by users.</p>
  </div>
</div>

<!-- stat strip -->
<section class="mini-stats">
  <div class="mini-stat">
    <span class="mini-stat-label">Pending</span>
    <span class="mini-stat-value warn">5</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">Approved</span>
    <span class="mini-stat-value ok">142</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">Rejected</span>
    <span class="mini-stat-value danger">23</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">This week</span>
    <span class="mini-stat-value">37</span>
  </div>
</section>

<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="subSearch" placeholder="Search by title or user...">
  </div>
  <select class="input filter-select" id="statusFilter">
    <option value="">All status</option>
    <option value="pending">Pending</option>
    <option value="approved">Approved</option>
    <option value="rejected">Rejected</option>
  </select>
  <select class="input filter-select" id="categoryFilter">
    <option value="">All categories</option>
    <?php foreach ($categories as $slug => $name): ?>
      <option value="<?= e($slug) ?>"><?= e($name) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<div class="panel">
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Submission</th>
          <th>Submitted by</th>
          <th>Category</th>
          <th>Status</th>
          <th>Date</th>
          <th class="col-actions"></th>
        </tr>
      </thead>
      <tbody id="subsTableBody">
        <?php foreach ($submissions as $s): ?>
          <tr data-title="<?= e(strtolower($s['title'])) ?>"
              data-user="<?= e(strtolower($s['user'])) ?>"
              data-status="<?= e($s['status']) ?>"
              data-category="<?= e($s['category']) ?>">
            <td>
              <div class="sub-cell">
                <span class="sub-type" style="--c: <?= category_color($s['category']) ?>">
                  <i class="fa-solid <?= content_type_icon($s['type']) ?>"></i>
                </span>
                <div class="sub-info">
                  <strong><?= e($s['title']) ?></strong>
                  <span class="sub-excerpt"><?= e($s['excerpt']) ?></span>
                </div>
              </div>
            </td>
            <td>
              <div class="user-mini">
                <span class="avatar avatar-xs"><?= e(initials($s['user'])) ?></span>
                <span><?= e($s['user']) ?></span>
              </div>
            </td>
            <td>
              <span class="cat-pill" style="--c: <?= category_color($s['category']) ?>">
                <?= e($categories[$s['category']] ?? $s['category']) ?>
              </span>
            </td>
            <td><?= status_badge($s['status']) ?></td>
            <td><span class="date-txt"><?= nice_date($s['date']) ?></span></td>
            <td class="col-actions">
              <div class="row-actions">
                <?php if ($s['status'] === 'pending'): ?>
                  <button class="icon-btn ok" data-approve aria-label="Approve">
                    <i class="fa-solid fa-check"></i>
                  </button>
                  <button class="icon-btn danger" data-reject aria-label="Reject">
                    <i class="fa-solid fa-xmark"></i>
                  </button>
                <?php endif; ?>
                <a href="submission-review.php?id=<?= (int)$s['id'] ?>" class="icon-btn" aria-label="Review">
                  <i class="fa-regular fa-eye"></i>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="empty hide" id="noResults">
    <i class="fa-regular fa-folder-open"></i>
    <p>No submissions match your filters.</p>
  </div>

  <div class="pagination">
    <span class="page-info">Showing <strong>1–8</strong> of <strong>170</strong></span>
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