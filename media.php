<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Media Center";
$active_menu = "media";
$page_css    = "page-media.css";
$page_js     = "page-media.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Media::with('category')->latest()->paginate(12)
$media = [
    ['id' => 1, 'title' => 'Attack on Titan S4 Trailer',      'category' => 'anime',    'type' => 'video', 'duration' => '2:14', 'views' => 4200, 'status' => 'published', 'date' => '2025-03-12'],
    ['id' => 2, 'title' => 'Elden Ring Gameplay Montage',     'category' => 'gaming',   'type' => 'video', 'duration' => '8:32', 'views' => 3800, 'status' => 'published', 'date' => '2025-03-10'],
    ['id' => 3, 'title' => 'BTS — Dynamite (Live)',           'category' => 'kpop',     'type' => 'video', 'duration' => '3:45', 'views' => 8900, 'status' => 'published', 'date' => '2025-03-08'],
    ['id' => 4, 'title' => 'Spider-Verse Soundtrack Mix',     'category' => 'movies',   'type' => 'audio', 'duration' => '12:20','views' => 2100, 'status' => 'published', 'date' => '2025-03-06'],
    ['id' => 5, 'title' => 'Jujutsu Kaisen Opening 1',        'category' => 'anime',    'type' => 'audio', 'duration' => '1:30', 'views' => 5400, 'status' => 'published', 'date' => '2025-03-04'],
    ['id' => 6, 'title' => 'The Last of Us Podcast Ep. 5',    'category' => 'tv-shows', 'type' => 'audio', 'duration' => '45:10','views' => 1400, 'status' => 'draft',     'date' => '2025-03-02'],
    ['id' => 7, 'title' => 'Cosplay Showcase Gallery',        'category' => 'cosplay',  'type' => 'image', 'duration' => '—',    'views' => 980,  'status' => 'published', 'date' => '2025-02-28'],
    ['id' => 8, 'title' => 'Manga Cover Art Collection',      'category' => 'manga',    'type' => 'image', 'duration' => '—',    'views' => 760,  'status' => 'published', 'date' => '2025-02-24'],
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

$types = ['video', 'audio', 'image'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Media Center</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Media Center</h2>
    <p class="page-sub">Videos, audio clips, and image galleries.</p>
  </div>
  <a href="media-form.php" class="btn btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Add Media</span>
  </a>
</div>

<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="mediaSearch" placeholder="Search by title...">
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
      <option value="<?= e($t) ?>"><?= e(ucfirst($t)) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<!-- media grid -->
<div class="media-grid" id="mediaGrid">
  <?php foreach ($media as $m): ?>
    <article class="media-card"
             data-title="<?= e(strtolower($m['title'])) ?>"
             data-category="<?= e($m['category']) ?>"
             data-type="<?= e($m['type']) ?>">

      <div class="media-thumb" style="--c: <?= category_color($m['category']) ?>">
        <i class="fa-solid <?= media_type_icon($m['type']) ?>"></i>
        <span class="media-type"><?= e(ucfirst($m['type'])) ?></span>
        <?php if ($m['duration'] !== '—'): ?>
          <span class="media-duration">
            <i class="fa-solid fa-clock"></i> <?= e($m['duration']) ?>
          </span>
        <?php endif; ?>
      </div>

      <div class="media-body">
        <h3 class="media-title"><?= e($m['title']) ?></h3>
        <div class="media-meta">
          <span class="cat-pill" style="--c: <?= category_color($m['category']) ?>">
            <?= e($categories[$m['category']] ?? $m['category']) ?>
          </span>
          <?= status_badge($m['status']) ?>
        </div>
        <div class="media-foot">
          <span class="mono views-txt"><i class="fa-regular fa-eye"></i> <?= compact_number($m['views']) ?></span>
          <div class="media-actions">
            <a href="media-form.php?id=<?= (int)$m['id'] ?>" class="icon-btn" aria-label="Edit">
              <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <button class="icon-btn danger" data-confirm="Delete this media?" aria-label="Delete">
              <i class="fa-regular fa-trash-can"></i>
            </button>
          </div>
        </div>
      </div>

    </article>
  <?php endforeach; ?>
</div>

<div class="empty hide" id="noResults">
  <i class="fa-regular fa-folder-open"></i>
  <p>No media matches your filters.</p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>