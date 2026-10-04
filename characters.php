<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Characters";
$active_menu = "characters";
$page_css    = "page-characters.css";
$page_js     = "page-characters.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Character::with('category')->paginate(15)
$characters = [
    ['id' => 1, 'name' => 'Eren Yeager',    'fandom' => 'Attack on Titan', 'category' => 'anime',   'role' => 'Protagonist', 'status' => 'published', 'date' => '2025-03-12'],
    ['id' => 2, 'name' => 'Levi Ackerman',  'fandom' => 'Attack on Titan', 'category' => 'anime',   'role' => 'Supporting',  'status' => 'published', 'date' => '2025-03-10'],
    ['id' => 3, 'name' => 'Jinx',           'fandom' => 'Arcane',          'category' => 'tv-shows','role' => 'Antagonist',  'status' => 'published', 'date' => '2025-03-08'],
    ['id' => 4, 'name' => 'Geralt of Rivia','fandom' => 'The Witcher',     'category' => 'gaming',  'role' => 'Protagonist', 'status' => 'published', 'date' => '2025-03-05'],
    ['id' => 5, 'name' => 'Naruto Uzumaki', 'fandom' => 'Naruto',          'category' => 'anime',   'role' => 'Protagonist', 'status' => 'published', 'date' => '2025-03-02'],
    ['id' => 6, 'name' => 'Spider-Man',     'fandom' => 'Marvel',          'category' => 'comics',  'role' => 'Protagonist', 'status' => 'draft',     'date' => '2025-02-28'],
    ['id' => 7, 'name' => 'Gojo Satoru',    'fandom' => 'Jujutsu Kaisen',  'category' => 'anime',   'role' => 'Supporting',  'status' => 'published', 'date' => '2025-02-24'],
    ['id' => 8, 'name' => 'Kim Possible',   'fandom' => 'Kim Possible',    'category' => 'tv-shows','role' => 'Protagonist', 'status' => 'draft',     'date' => '2025-02-20'],
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

$roles = ['Protagonist', 'Antagonist', 'Supporting', 'Side'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Characters</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Character Profiles</h2>
    <p class="page-sub">Card-based character profiles across every fandom.</p>
  </div>
  <a href="character-form.php" class="btn btn-primary">
    <i class="fa-solid fa-plus"></i>
    <span>Add Character</span>
  </a>
</div>

<!-- filters -->
<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="characterSearch" placeholder="Search by name or fandom...">
  </div>
  <select class="input filter-select" id="categoryFilter">
    <option value="">All categories</option>
    <?php foreach ($categories as $slug => $name): ?>
      <option value="<?= e($slug) ?>"><?= e($name) ?></option>
    <?php endforeach; ?>
  </select>
  <select class="input filter-select" id="roleFilter">
    <option value="">All roles</option>
    <?php foreach ($roles as $r): ?>
      <option value="<?= e($r) ?>"><?= e($r) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<!-- cards grid -->
<div class="chars-grid" id="charsGrid">
  <?php foreach ($characters as $c): ?>
    <article class="char-card"
             data-name="<?= e(strtolower($c['name'])) ?>"
             data-fandom="<?= e(strtolower($c['fandom'])) ?>"
             data-category="<?= e($c['category']) ?>"
             data-role="<?= e($c['role']) ?>">

      <div class="char-image" style="--c: <?= category_color($c['category']) ?>">
        <span class="char-initials"><?= e(initials($c['name'])) ?></span>
        <span class="char-cat"><?= e($categories[$c['category']] ?? $c['category']) ?></span>
      </div>

      <div class="char-body">
        <h3 class="char-name"><?= e($c['name']) ?></h3>
        <p class="char-fandom"><?= e($c['fandom']) ?></p>

        <div class="char-meta">
          <span class="role-pill"><?= e($c['role']) ?></span>
          <?= status_badge($c['status']) ?>
        </div>
      </div>

      <div class="char-actions">
        <a href="character-form.php?id=<?= (int)$c['id'] ?>" class="icon-btn" aria-label="Edit">
          <i class="fa-regular fa-pen-to-square"></i>
        </a>
        <button class="icon-btn danger" data-confirm="Delete this character?" aria-label="Delete">
          <i class="fa-regular fa-trash-can"></i>
        </button>
      </div>

    </article>
  <?php endforeach; ?>
</div>

<div class="empty hide" id="noResults">
  <i class="fa-regular fa-face-frown"></i>
  <p>No characters match your filters.</p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>