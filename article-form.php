<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

// edit mode? URL mein ?id= ho to edit, warna add
$id = (int)($_GET['id'] ?? 0);
$is_edit = $id > 0;

$page_title  = $is_edit ? "Edit Article" : "Add Article";
$active_menu = "articles";
$page_css    = "page-article-form.css";
$page_js     = "page-article-form.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo article — Laravel: Article::findOrFail($id)
$article = [
    'id'          => $id,
    'title'       => $is_edit ? 'Attack on Titan: The Final Season Review' : '',
    'slug'        => $is_edit ? 'attack-on-titan-final-season-review' : '',
    'category'    => $is_edit ? 'anime' : '',
    'excerpt'     => $is_edit ? 'A deep dive into the final chapter of one of anime\'s greatest stories.' : '',
    'content'     => $is_edit ? 'Full article content goes here...' : '',
    'cover'       => '',
    'status'      => $is_edit ? 'published' : 'draft',
    'featured'    => $is_edit,
    'tags'        => $is_edit ? 'attack on titan, aot, review' : '',
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
  <a href="articles.php">Articles</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span><?= $is_edit ? 'Edit' : 'Add New' ?></span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title"><?= $is_edit ? 'Edit Article' : 'Add Article' ?></h2>
    <p class="page-sub"><?= $is_edit ? 'Update the article details below.' : 'Create a new article for the platform.' ?></p>
  </div>
  <a href="articles.php" class="btn btn-ghost">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<!-- backend: POST to /admin/articles (store) or /admin/articles/{id} (update) -->
<form id="articleForm" class="form-layout" autocomplete="off">

  <!-- main column -->
  <div class="form-main">

    <div class="panel">
      <div class="panel-body">

        <div class="field">
          <label for="title">Title</label>
          <input class="input input-lg" id="title" name="title" type="text"
                 placeholder="Enter article title..." value="<?= e($article['title']) ?>" required>
        </div>

        <div class="field">
          <label for="slug">Slug</label>
          <input class="input" id="slug" name="slug" type="text"
                 placeholder="auto-generated-from-title" value="<?= e($article['slug']) ?>">
          <span class="field-hint">Auto-generated from title. Edit if needed.</span>
        </div>

        <div class="field">
          <label for="excerpt">Excerpt</label>
          <textarea class="input" id="excerpt" name="excerpt" rows="3"
                    placeholder="Short summary shown in listings..."><?= e($article['excerpt']) ?></textarea>
        </div>

        <div class="field">
          <label for="content">Content</label>
          <textarea class="input" id="content" name="content" rows="12"
                    placeholder="Write your article content here..."><?= e($article['content']) ?></textarea>
          <span class="field-hint">Backend dev will attach a rich text editor (TinyMCE / Quill) here.</span>
        </div>

      </div>
    </div>

  </div>

  <!-- side column -->
  <aside class="form-side">

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Publish</h3>
      </div>
      <div class="panel-body">

        <div class="field">
          <label for="status">Status</label>
          <select class="input" id="status" name="status">
            <option value="draft" <?= $article['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $article['status'] === 'published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>

        <label class="switch">
          <input type="checkbox" id="featured" name="featured" <?= $article['featured'] ? 'checked' : '' ?>>
          <span class="switch-track"><span class="switch-thumb"></span></span>
          <span class="switch-label">Featured article</span>
        </label>

        <div class="form-actions">
          <a href="articles.php" class="btn btn-ghost">Cancel</a>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-check"></i>
            <span><?= $is_edit ? 'Save Changes' : 'Create Article' ?></span>
          </button>
        </div>

      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Details</h3>
      </div>
      <div class="panel-body">

        <div class="field">
          <label for="category">Category</label>
          <select class="input" id="category" name="category" required>
            <option value="">Select category</option>
            <?php foreach ($categories as $slug => $name): ?>
              <option value="<?= e($slug) ?>" <?= $article['category'] === $slug ? 'selected' : '' ?>>
                <?= e($name) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="tags">Tags</label>
          <input class="input" id="tags" name="tags" type="text"
                 placeholder="comma, separated, tags" value="<?= e($article['tags']) ?>">
        </div>

      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Cover Image</h3>
      </div>
      <div class="panel-body">

        <div class="upload-box" id="coverBox">
          <i class="fa-regular fa-image"></i>
          <p>Click to upload cover</p>
          <span>PNG, JPG up to 2MB</span>
          <input type="file" id="coverInput" accept="image/*" hidden>
        </div>

      </div>
    </div>

  </aside>

</form>

<?php include __DIR__ . '/includes/footer.php'; ?>