<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Bookmarks";
$active_menu = "bookmarks";
$page_css    = "page-bookmarks.css";
$page_js     = "page-bookmarks.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Bookmark::with('user','content')->latest()->paginate(15)
$bookmarks = [
    ['id' => 1, 'user' => 'mika_asa',      'content' => 'Attack on Titan S4 Review', 'type' => 'article', 'category' => 'anime',   'note' => 'Best review I have read.', 'date' => '2025-03-15'],
    ['id' => 2, 'user' => 'tarnished_01',  'content' => 'Elden Ring Boss Guide',     'type' => 'article', 'category' => 'gaming',  'note' => '',                        'date' => '2025-03-14'],
    ['id' => 3, 'user' => 'army_forever',  'content' => 'BTS Dynamite Live',         'type' => 'video',   'category' => 'kpop',    'note' => 'Replay forever!',         'date' => '2025-03-13'],
    ['id' => 4, 'user' => 'artof_chloe',   'content' => 'Jinx from Arcane',          'type' => 'image',   'category' => 'cosplay', 'note' => 'Cosplay goals.',          'date' => '2025-03-12'],
    ['id' => 5, 'user' => 'otaku_sensei',  'content' => 'Top 10 Manga of 2025',      'type' => 'article', 'category' => 'manga',   'note' => '',                        'date' => '2025-03-11'],
    ['id' => 6, 'user' => 'nova_star',     'content' => 'Spider-Verse Soundtrack',   'type' => 'audio',   'category' => 'movies',  'note' => 'Perfect for study.',      'date' => '2025-03-10'],
    ['id' => 7, 'user' => 'pixel_wizard',  'content' => 'Naruto Headband',           'type' => 'image',   'category' => 'anime',   'note' => 'Want to buy this.',       'date' => '2025-03-09'],
    ['id' => 8, 'user' => 'chloe_arts',    'content' => 'Spider-Verse Animation Study','type' => 'article','category' => 'movies',  'note' => '',                        'date' => '2025-03-08'],
];

// top bookmarked content (for chart)
$top_content = [
    ['title' => 'Attack on Titan S4 Review', 'count' => 420],
    ['title' => 'Elden Ring Boss Guide',     'count' => 380],
    ['title' => 'BTS Dynamite Live',         'count' => 340],
    ['title' => 'Top 10 Manga of 2025',      'count' => 290],
    ['title' => 'Spider-Verse Soundtrack',   'count' => 210],
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Bookmarks</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Bookmarks</h2>
    <p class="page-sub">User bookmarks and saved content.</p>
  </div>
</div>

<!-- stats -->
<section class="mini-stats">
  <div class="mini-stat">
    <span class="mini-stat-label">Total Bookmarks</span>
    <span class="mini-stat-value">12.4K</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">With Notes</span>
    <span class="mini-stat-value">3.2K</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">This Week</span>
    <span class="mini-stat-value ok">+284</span>
  </div>
  <div class="mini-stat">
    <span class="mini-stat-label">Avg per User</span>
    <span class="mini-stat-value">8.2</span>
  </div>
</section>

<!-- top bookmarked chart -->
<div class="panel top-chart">
  <div class="panel-head">
    <div>
      <h3 class="panel-title">Top Bookmarked Content</h3>
      <p class="panel-sub">Most saved items across the platform</p>
    </div>
  </div>
  <div class="panel-body">
    <canvas id="topChart" height="90"></canvas>
  </div>
</div>

<!-- filters -->
<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="bookmarkSearch" placeholder="Search by user or content...">
  </div>
  <select class="input filter-select" id="categoryFilter">
    <option value="">All categories</option>
    <option value="anime">Anime</option>
    <option value="gaming">Gaming</option>
    <option value="movies">Movies</option>
    <option value="tv-shows">TV Shows</option>
    <option value="kpop">K-Pop</option>
    <option value="comics">Comics</option>
    <option value="manga">Manga</option>
    <option value="cosplay">Cosplay</option>
  </select>
  <select class="input filter-select" id="typeFilter">
    <option value="">All types</option>
    <option value="article">Article</option>
    <option value="video">Video</option>
    <option value="audio">Audio</option>
    <option value="image">Image</option>
  </select>
</div>

<!-- table -->
<div class="panel">
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>User</th>
          <th>Bookmarked Item</th>
          <th>Type</th>
          <th>Note</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody id="bookmarksTableBody">
        <?php foreach ($bookmarks as $b): ?>
          <tr data-user="<?= e(strtolower($b['user'])) ?>"
              data-content="<?= e(strtolower($b['content'])) ?>"
              data-category="<?= e($b['category']) ?>"
              data-type="<?= e($b['type']) ?>">
            <td>
              <div class="user-mini">
                <span class="avatar avatar-xs"><?= e(initials($b['user'])) ?></span>
                <span><?= e($b['user']) ?></span>
              </div>
            </td>
            <td>
              <div class="bm-cell">
                <span class="bm-icon" style="--c: <?= category_color($b['category']) ?>">
                  <i class="fa-solid <?= content_type_icon($b['type']) ?>"></i>
                </span>
                <strong><?= e($b['content']) ?></strong>
              </div>
            </td>
            <td>
              <span class="type-pill type-<?= e($b['type']) ?>"><?= e(ucfirst($b['type'])) ?></span>
            </td>
            <td>
              <?php if ($b['note']): ?>
                <span class="bm-note"><?= e($b['note']) ?></span>
              <?php else: ?>
                <span class="bm-note empty">—</span>
              <?php endif; ?>
            </td>
            <td><span class="date-txt"><?= nice_date($b['date']) ?></span></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="empty hide" id="noResults">
    <i class="fa-regular fa-bookmark"></i>
    <p>No bookmarks match your filters.</p>
  </div>

  <div class="pagination">
    <span class="page-info">Showing <strong>1–8</strong> of <strong>12,480</strong></span>
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