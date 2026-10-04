<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Upcoming Releases";
$active_menu = "releases";
$page_css    = "page-releases.css";
$page_js     = "page-releases.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Release::with('category')->orderBy('release_date')->paginate(15)
$releases = [
    ['id' => 1, 'title' => 'Attack on Titan Final Chapter',   'category' => 'anime',    'type' => 'Episode',  'date' => '2025-11-15', 'platform' => 'Crunchyroll', 'status' => 'published'],
    ['id' => 2, 'title' => 'Elden Ring: Shadow of Erdtree',   'category' => 'gaming',   'type' => 'DLC',      'date' => '2025-06-21', 'platform' => 'Steam / PS5', 'status' => 'published'],
    ['id' => 3, 'title' => 'BTS — New Album "WE ARE"',        'category' => 'kpop',     'type' => 'Album',    'date' => '2025-05-10', 'platform' => 'Spotify / Apple Music', 'status' => 'published'],
    ['id' => 4, 'title' => 'Spider-Man: Beyond the Verse',    'category' => 'movies',   'type' => 'Movie',    'date' => '2025-12-20', 'platform' => 'Cinemas Worldwide', 'status' => 'published'],
    ['id' => 5, 'title' => 'One Piece Chapter 1120',          'category' => 'manga',    'type' => 'Chapter',  'date' => '2025-04-28', 'platform' => 'Shonen Jump', 'status' => 'published'],
    ['id' => 6, 'title' => 'Marvel Phase 6 Announcement',     'category' => 'comics',   'type' => 'Announcement', 'date' => '2025-07-20', 'platform' => 'San Diego Comic-Con', 'status' => 'draft'],
    ['id' => 7, 'title' => 'Jujutsu Kaisen Season 3',         'category' => 'anime',    'type' => 'Season',   'date' => '2026-01-10', 'platform' => 'Crunchyroll', 'status' => 'published'],
    ['id' => 8, 'title' => 'Naruto Funko Pop Wave 12',        'category' => 'anime',    'type' => 'Merch',    'date' => '2025-08-15', 'platform' => 'Funko Official', 'status' => 'published'],
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

$types = ['Episode', 'Season', 'Movie', 'Album', 'Single', 'Game', 'DLC', 'Chapter', 'Volume', 'Merch', 'Announcement'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Upcoming Releases</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Upcoming Releases</h2>
    <p class="page-sub">Anticipated anime, games, movies, and merchandise drops.</p>
  </div>
  <a href="release-form.php" class="btn btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Add Release</span>
  </a>
</div>

<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="releaseSearch" placeholder="Search by title...">
  </div>
  <select class="input filter-select" id="categoryFilter">
    <option value="">All categories</option>
    <?php foreach ($categories as $slug => $name): ?>
      <option value="<?= e($slug) ?>"><?= e($name) ?></option>
    <?php endforeach; ?>
  </select>
  <select class="input filter-select" id="typeFilter">
    <option value="">All types</option>
    <?php foreach ($types as $t): ?>
      <option value="<?= e(strtolower($t)) ?>"><?= e($t) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<div class="releases-list" id="releasesList">
  <?php foreach ($releases as $r): ?>
    <article class="release-card"
             data-title="<?= e(strtolower($r['title'])) ?>"
             data-category="<?= e($r['category']) ?>"
             data-type="<?= e(strtolower($r['type'])) ?>">

      <div class="release-date" style="--c: <?= category_color($r['category']) ?>">
        <span class="release-day"><?= date('d', strtotime($r['date'])) ?></span>
        <span class="release-month"><?= date('M', strtotime($r['date'])) ?></span>
        <span class="release-year"><?= date('Y', strtotime($r['date'])) ?></span>
      </div>

      <div class="release-main">
        <div class="release-head">
          <h3 class="release-title"><?= e($r['title']) ?></h3>
          <span class="type-pill"><?= e($r['type']) ?></span>
        </div>
        <div class="release-meta">
          <span class="cat-pill" style="--c: <?= category_color($r['category']) ?>">
            <?= e($categories[$r['category']] ?? $r['category']) ?>
          </span>
          <span><i class="fa-solid fa-tv"></i> <?= e($r['platform']) ?></span>
        </div>
        <div class="release-countdown">
          <?php
            $diff = strtotime($r['date']) - time();
            $days = (int)ceil($diff / 86400);
          ?>
          <?php if ($days > 0): ?>
            <i class="fa-regular fa-clock"></i>
            <span>In <strong><?= $days ?></strong> <?= $days === 1 ? 'day' : 'days' ?></span>
          <?php else: ?>
            <i class="fa-solid fa-circle-check"></i>
            <span>Released</span>
          <?php endif; ?>
        </div>
      </div>

      <div class="release-actions">
        <?= status_badge($r['status']) ?>
        <a href="release-form.php?id=<?= (int)$r['id'] ?>" class="icon-btn" aria-label="Edit">
          <i class="fa-regular fa-pen-to-square"></i>
        </a>
        <button class="icon-btn danger" data-confirm="Delete this release?" aria-label="Delete">
          <i class="fa-regular fa-trash-can"></i>
        </button>
      </div>

    </article>
  <?php endforeach; ?>
</div>

<div class="empty hide" id="noResults">
  <i class="fa-regular fa-calendar-xmark"></i>
  <p>No releases match your filters.</p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>