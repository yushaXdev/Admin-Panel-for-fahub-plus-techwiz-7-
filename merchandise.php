<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Merchandise";
$active_menu = "merchandise";
$page_css    = "page-merchandise.css";
$page_js     = "page-merchandise.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Merchandise::with('category')->latest()->paginate(12)
$items = [
    ['id' => 1, 'name' => 'Eren Yeager Figurine',    'category' => 'anime',    'tag' => 'Limited Edition', 'price' => '$49.99', 'status' => 'published', 'views' => 3400, 'date' => '2025-03-12'],
    ['id' => 2, 'name' => 'Elden Ring T-Shirt',      'category' => 'gaming',   'tag' => 'Pre-Order',       'price' => '$29.99', 'status' => 'published', 'views' => 2100, 'date' => '2025-03-10'],
    ['id' => 3, 'name' => 'BTS Light Stick Ver. 4',  'category' => 'kpop',     'tag' => 'Collectible',     'price' => '$89.99', 'status' => 'published', 'views' => 5600, 'date' => '2025-03-08'],
    ['id' => 4, 'name' => 'Jinx Cosplay Wig',        'category' => 'cosplay',  'tag' => '',                'price' => '$45.00', 'status' => 'published', 'views' => 980,  'date' => '2025-03-06'],
    ['id' => 5, 'name' => 'Naruto Headband',         'category' => 'anime',    'tag' => 'Collectible',     'price' => '$19.99', 'status' => 'published', 'views' => 4200, 'date' => '2025-03-04'],
    ['id' => 6, 'name' => 'Spider-Man Poster Pack',  'category' => 'movies',   'tag' => '',                'price' => '$24.99', 'status' => 'draft',     'views' => 0,    'date' => '2025-03-02'],
    ['id' => 7, 'name' => 'Manga Art Book Vol. 1',   'category' => 'manga',    'tag' => 'Limited Edition', 'price' => '$39.99', 'status' => 'published', 'views' => 1800, 'date' => '2025-02-28'],
    ['id' => 8, 'name' => 'Marvel Enamel Pins',      'category' => 'comics',   'tag' => 'Collectible',     'price' => '$14.99', 'status' => 'published', 'views' => 2400, 'date' => '2025-02-24'],
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

$tags = ['Limited Edition', 'Pre-Order', 'Collectible'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Merchandise</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Merchandise</h2>
    <p class="page-sub">Display-only showcase. No purchase flow — SRS note.</p>
  </div>
  <a href="merchandise-form.php" class="btn btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Add Item</span>
  </a>
</div>

<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="merchSearch" placeholder="Search by name...">
  </div>
  <select class="input filter-select" id="categoryFilter">
    <option value="">All categories</option>
    <?php foreach ($categories as $slug => $name): ?>
      <option value="<?= e($slug) ?>"><?= e($name) ?></option>
    <?php endforeach; ?>
  </select>
  <select class="input filter-select" id="tagFilter">
    <option value="">All tags</option>
    <?php foreach ($tags as $t): ?>
      <option value="<?= e($t) ?>"><?= e($t) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<div class="merch-grid" id="merchGrid">
  <?php foreach ($items as $m): ?>
    <article class="merch-card"
             data-name="<?= e(strtolower($m['name'])) ?>"
             data-category="<?= e($m['category']) ?>"
             data-tag="<?= e($m['tag']) ?>">

      <div class="merch-image" style="--c: <?= category_color($m['category']) ?>">
        <i class="fa-solid fa-bag-shopping"></i>
        <?php if ($m['tag']): ?>
          <span class="merch-tag tag-<?= strtolower(str_replace(' ', '-', $m['tag'])) ?>">
            <?= e($m['tag']) ?>
          </span>
        <?php endif; ?>
      </div>

      <div class="merch-body">
        <h3 class="merch-name"><?= e($m['name']) ?></h3>
        <div class="merch-meta">
          <span class="cat-pill" style="--c: <?= category_color($m['category']) ?>">
            <?= e($categories[$m['category']] ?? $m['category']) ?>
          </span>
        </div>
        <div class="merch-foot">
          <span class="merch-price"><?= e($m['price']) ?></span>
          <div class="merch-actions">
            <a href="merchandise-form.php?id=<?= (int)$m['id'] ?>" class="icon-btn" aria-label="Edit">
              <i class="fa-regular fa-pen-to-square"></i>
            </a>
            <button class="icon-btn danger" data-confirm="Delete this item?" aria-label="Delete">
              <i class="fa-regular fa-trash-can"></i>
            </button>
          </div>
        </div>
      </div>

    </article>
  <?php endforeach; ?>
</div>

<div class="empty hide" id="noResults">
  <i class="fa-regular fa-face-frown"></i>
  <p>No merchandise matches your filters.</p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>