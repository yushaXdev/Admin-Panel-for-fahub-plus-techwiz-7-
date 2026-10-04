<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Articles";
$active_menu = "articles";
$page_css    = "page-articles.css";
$page_js     = "page-articles.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Article::with('category','author')->paginate(15)
$articles = [
    ['id' => 1, 'title' => 'Attack on Titan: The Final Season Review', 'category' => 'anime',    'author' => 'Mika Asa',     'status' => 'published', 'featured' => true,  'views' => 4200, 'date' => '2025-03-12'],
    ['id' => 2, 'title' => 'Top 10 Manga of 2025',                     'category' => 'manga',    'author' => 'Otaku Sensei', 'status' => 'published', 'featured' => true,  'views' => 5100, 'date' => '2025-03-04'],
    ['id' => 3, 'title' => 'BTS Concert Recap: Seoul Night 3',         'category' => 'kpop',     'author' => 'ARMY Forever', 'status' => 'published', 'featured' => false, 'views' => 2900, 'date' => '2025-03-08'],
    ['id' => 4, 'title' => 'Why Elden Ring is a Masterpiece',          'category' => 'gaming',   'author' => 'Nova Star',    'status' => 'published', 'featured' => true,  'views' => 3800, 'date' => '2025-03-10'],
    ['id' => 5, 'title' => 'Spider-Verse: Animation Evolution',        'category' => 'movies',   'author' => 'Chloe Arts',   'status' => 'draft',     'featured' => false, 'views' => 0,    'date' => '2025-03-06'],
    ['id' => 6, 'title' => 'Cosplay Tips for Beginners',               'category' => 'cosplay',  'author' => 'Pixel Wizard', 'status' => 'published', 'featured' => false, 'views' => 1500, 'date' => '2025-02-28'],
    ['id' => 7, 'title' => 'The Last of Us: Adaptation Done Right',    'category' => 'tv-shows', 'author' => 'Riko Tanaka',  'status' => 'draft',     'featured' => false, 'views' => 0,    'date' => '2025-02-26'],
    ['id' => 8, 'title' => 'Batman Comics: Best Storylines',           'category' => 'comics',   'author' => 'Nova Star',    'status' => 'published', 'featured' => false, 'views' => 2100, 'date' => '2025-02-22'],
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
  <span>Articles</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Articles</h2>
    <p class="page-sub">Featured articles and reviews across every fandom.</p>
  </div>
  <a href="article-form.php" class="btn btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Add Article</span>
  </a>
</div>

<!-- filters -->
<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="articleSearch" placeholder="Search by title or author...">
  </div>
  <select class="input filter-select" id="categoryFilter">
    <option value="">All categories</option>
    <?php foreach ($categories as $slug => $name): ?>
      <option value="<?= e($slug) ?>"><?= e($name) ?></option>
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
          <th>Author</th>
          <th>Status</th>
          <th>Views</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="articlesTableBody">
        <?php foreach ($articles as $a): ?>
          <tr data-title="<?= e(strtolower($a['title'])) ?>"
              data-author="<?= e(strtolower($a['author'])) ?>"
              data-category="<?= e($a['category']) ?>"
              data-status="<?= e($a['status']) ?>">
            <td>
              <div class="article-cell">
                <span class="article-thumb" style="--c: <?= category_color($a['category']) ?>">
                  <i class="fa-regular fa-newspaper"></i>
                </span>
                <div class="article-info">
                  <strong><?= e($a['title']) ?></strong>
                  <?php if ($a['featured']): ?>
                    <span class="featured-tag">
                      <i class="fa-solid fa-star"></i> Featured
                    </span>
                  <?php endif; ?>
                </div>
              </div>
            </td>
            <td>
              <span class="cat-pill" style="--c: <?= category_color($a['category']) ?>">
                <?= e($categories[$a['category']] ?? $a['category']) ?>
              </span>
            </td>
            <td>
              <div class="author-cell">
                <span class="avatar avatar-xs"><?= e(initials($a['author'])) ?></span>
                <span><?= e($a['author']) ?></span>
              </div>
            </td>
            <td><?= status_badge($a['status']) ?></td>
            <td><span class="mono views-txt"><?= compact_number($a['views']) ?></span></td>
            <td><span class="date-txt"><?= nice_date($a['date']) ?></span></td>
            <td class="row-actions">
              <a href="article-form.php?id=<?= (int)$a['id'] ?>" class="icon-btn" aria-label="Edit">
                <i class="fa-regular fa-pen-to-square"></i>
              </a>
              <button class="icon-btn danger" data-confirm="Delete this article?" aria-label="Delete">
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
    <p>No articles match your filters.</p>
  </div>

  <div class="pagination">
    <span class="page-info">Showing <strong>1–8</strong> of <strong>142</strong></span>
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