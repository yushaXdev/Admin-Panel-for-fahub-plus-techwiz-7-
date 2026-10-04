<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Content Library";
$active_menu = "content";
$page_css    = "page-content.css";
$page_js     = "page-content.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Content::with('category')->paginate(15)
$contents = [
    ['id' => 1, 'title' => 'Attack on Titan S4 Review',    'category' => 'anime',    'type' => 'article', 'status' => 'published', 'views' => 4200, 'date' => '2025-03-12'],
    ['id' => 2, 'title' => 'Elden Ring Boss Guide',        'category' => 'gaming',   'type' => 'video',   'status' => 'published', 'views' => 3800, 'date' => '2025-03-10'],
    ['id' => 3, 'title' => 'BTS Concert Recap 2025',       'category' => 'kpop',     'type' => 'article', 'status' => 'published', 'views' => 2900, 'date' => '2025-03-08'],
    ['id' => 4, 'title' => 'Jinx from Arcane — Cosplay',   'category' => 'cosplay',  'type' => 'image',   'status' => 'draft',     'views' => 0,    'date' => '2025-03-06'],
    ['id' => 5, 'title' => 'Top 10 Manga of 2025',         'category' => 'manga',    'type' => 'article', 'status' => 'published', 'views' => 5100, 'date' => '2025-03-04'],
    ['id' => 6, 'title' => 'Spider-Man: Across the Verse', 'category' => 'movies',   'type' => 'video',   'status' => 'published', 'views' => 6200, 'date' => '2025-03-02'],
    ['id' => 7, 'title' => 'The Last of Us Podcast',       'category' => 'tv-shows', 'type' => 'audio',   'status' => 'published', 'views' => 1400, 'date' => '2025-02-28'],
    ['id' => 8, 'title' => 'One Piece Chapter 1100 Recap', 'category' => 'manga',    'type' => 'article', 'status' => 'draft',     'views' => 0,    'date' => '2025-02-26'],
];

// for dropdowns
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

$types = ['article', 'video', 'audio', 'image'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Content Library</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Content Library</h2>
    <p class="page-sub">All content across every category.</p>
  </div>
  <a href="article-form.php" class="btn btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Add Content</span>
  </a>
</div>

<!-- filters -->
<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="contentSearch" placeholder="Search by title...">
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
  <select class="input filter-select" id="statusFilter">
    <option value="">All status</option>
    <option value="published">Published</option>
    <option value="draft">Draft</option>
  </select>
</div>

<!-- table -->
<div class="panel">
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Type</th>
          <th>Status</th>
          <th>Views</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="contentTableBody">
        <?php foreach ($contents as $c): ?>
          <tr data-title="<?= e(strtolower($c['title'])) ?>"
              data-category="<?= e($c['category']) ?>"
              data-type="<?= e($c['type']) ?>"
              data-status="<?= e($c['status']) ?>">
            <td>
              <div class="content-cell">
                <span class="content-thumb" style="--c: <?= category_color($c['category']) ?>">
                  <i class="fa-solid <?= content_type_icon($c['type']) ?>"></i>
                </span>
                <strong><?= e($c['title']) ?></strong>
              </div>
            </td>
            <td>
              <span class="cat-pill" style="--c: <?= category_color($c['category']) ?>">
                <?= e($categories[$c['category']] ?? $c['category']) ?>
              </span>
            </td>
            <td><span class="type-pill type-<?= e($c['type']) ?>"><?= e(ucfirst($c['type'])) ?></span></td>
            <td><?= status_badge($c['status']) ?></td>
            <td><span class="mono views-txt"><?= compact_number($c['views']) ?></span></td>
            <td><span class="date-txt"><?= nice_date($c['date']) ?></span></td>
            <td class="row-actions">
              <a href="article-form.php?id=<?= (int)$c['id'] ?>" class="icon-btn" aria-label="Edit">
                <i class="fa-regular fa-pen-to-square"></i>
              </a>
              <button class="icon-btn danger" data-confirm="Delete this content?" aria-label="Delete">
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="empty hide" id="noResults">
    <i class="fa-regular fa-folder-open"></i>
    <p>No content matches your filters.</p>
  </div>

  <div class="pagination">
    <span class="page-info">Showing <strong>1–8</strong> of <strong>864</strong></span>
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