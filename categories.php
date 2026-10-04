<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Categories";
$active_menu = "categories";
$page_css    = "page-categories.css";
$page_js     = "page-categories.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// Demo data — MySQL/Laravel will replace this with:
// $categories = Category::withCount('contents')->get();
$categories = [
    ['id' => 1, 'name' => 'Anime',    'slug' => 'anime',    'icon' => 'fa-solid fa-dragon',         'desc' => 'Japanese animation series and films',       'count' => 218, 'active' => true],
    ['id' => 2, 'name' => 'Gaming',   'slug' => 'gaming',   'icon' => 'fa-solid fa-gamepad',        'desc' => 'Video games across all platforms',           'count' => 176, 'active' => true],
    ['id' => 3, 'name' => 'Movies',   'slug' => 'movies',   'icon' => 'fa-solid fa-film',           'desc' => 'Feature films from every genre',             'count' => 142, 'active' => true],
    ['id' => 4, 'name' => 'TV Shows', 'slug' => 'tv-shows', 'icon' => 'fa-solid fa-tv',             'desc' => 'Series, sitcoms, and streaming originals',   'count' => 98,  'active' => true],
    ['id' => 5, 'name' => 'K-Pop',    'slug' => 'kpop',     'icon' => 'fa-solid fa-music',          'desc' => 'Korean pop music and artists',               'count' => 87,  'active' => true],
    ['id' => 6, 'name' => 'Comics',   'slug' => 'comics',   'icon' => 'fa-solid fa-mask',           'desc' => 'Western comic books and superheroes',        'count' => 64,  'active' => true],
    ['id' => 7, 'name' => 'Manga',    'slug' => 'manga',    'icon' => 'fa-solid fa-book-open',      'desc' => 'Japanese manga and light novels',            'count' => 51,  'active' => true],
    ['id' => 8, 'name' => 'Cosplay',  'slug' => 'cosplay',  'icon' => 'fa-solid fa-user-astronaut','desc' => 'Costume design and cosplay culture',         'count' => 28,  'active' => false],
];
?>

<!-- breadcrumbs -->
<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Categories</span>
</nav>

<!-- page header -->
<div class="page-header">
  <div>
    <h2 class="page-title">Categories</h2>
    <p class="page-sub">Manage the 8 core fandoms on your platform.</p>
  </div>
  <button class="btn btn-primary" id="addCategoryBtn">
    <i class="fa-solid fa-plus"></i>
    <span>Add Category</span>
  </button>
</div>

<!-- filters -->
<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="categorySearch" placeholder="Search categories...">
  </div>
  <select class="input filter-select" id="statusFilter">
    <option value="">All status</option>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
  </select>
</div>

<!-- table -->
<div class="panel">
  <div class="panel-body no-pad">
    <div class="table-wrap">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Slug</th>
            <th>Description</th>
            <th>Content</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="categoryTableBody">
          <?php foreach ($categories as $c): ?>
            <tr data-name="<?= e(strtolower($c['name'])) ?>"
                data-status="<?= $c['active'] ? 'active' : 'inactive' ?>">
              <td>
                <div class="cat-cell">
                  <span class="cat-icon" style="--c: <?= category_color($c['slug']) ?>">
                    <i class="<?= e($c['icon']) ?>"></i>
                  </span>
                  <strong><?= e($c['name']) ?></strong>
                </div>
              </td>
              <td><code class="mono code-pill"><?= e($c['slug']) ?></code></td>
              <td class="cat-desc"><?= e($c['desc']) ?></td>
              <td><span class="pill"><?= (int)$c['count'] ?> items</span></td>
              <td><?= status_badge($c['active'] ? 'active' : 'inactive') ?></td>
              <td class="row-actions">
                <button class="icon-btn" aria-label="Edit" data-edit>
                  <i class="fa-regular fa-pen-to-square"></i>
                </button>
                <button class="icon-btn danger" aria-label="Delete"
                        data-delete
                        data-confirm="Delete this category? This cannot be undone.">
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
      <p>No categories match your search.</p>
    </div>
  </div>
</div>

<!-- add/edit modal -->
<div class="modal" id="categoryModal" aria-hidden="true">
  <div class="modal-overlay" data-close></div>
  <div class="modal-panel">
    <header class="modal-head">
      <h3 id="modalTitle">Add Category</h3>
      <button class="icon-btn" data-close aria-label="Close">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </header>

    <div class="modal-body">
      <!-- Laravel will POST to /admin/categories -->
      <form id="categoryForm" class="form-grid" autocomplete="off">
        <div class="field">
          <label for="catName">Name</label>
          <input class="input" id="catName" name="name" type="text"
                 placeholder="e.g. Anime" required>
        </div>

        <div class="field">
          <label for="catSlug">Slug</label>
          <input class="input" id="catSlug" name="slug" type="text"
                 placeholder="e.g. anime" required>
        </div>

        <div class="field">
          <label for="catIcon">Icon class</label>
          <input class="input" id="catIcon" name="icon" type="text"
                 placeholder="fa-solid fa-dragon">
        </div>

        <div class="field">
          <label for="catDesc">Description</label>
          <textarea class="input" id="catDesc" name="description" rows="3"
                    placeholder="Short description"></textarea>
        </div>

        <label class="switch">
          <input type="checkbox" id="catActive" name="active" checked>
          <span class="switch-track"><span class="switch-thumb"></span></span>
          <span class="switch-label">Active</span>
        </label>
      </form>
    </div>

    <footer class="modal-foot">
      <button class="btn btn-ghost" data-close>Cancel</button>
      <button class="btn btn-primary" id="saveCategory" type="button">
        <i class="fa-solid fa-check"></i>
        <span>Save Category</span>
      </button>
    </footer>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>