<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$is_edit = $id > 0;

$page_title  = $is_edit ? "Edit Media" : "Add Media";
$active_menu = "media";
$page_css    = "page-media-form.css";
$page_js     = "page-media-form.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

$item = [
    'id'       => $id,
    'title'    => $is_edit ? 'Attack on Titan S4 Trailer' : '',
    'type'     => $is_edit ? 'video' : 'video',
    'category' => $is_edit ? 'anime' : '',
    'url'      => $is_edit ? 'https://www.youtube.com/watch?v=example' : '',
    'duration' => $is_edit ? '2:14' : '',
    'desc'     => $is_edit ? 'Official trailer for the final season.' : '',
    'tags'     => $is_edit ? 'aot, trailer, final season' : '',
    'status'   => $is_edit ? 'published' : 'draft',
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
  <a href="media.php">Media Center</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span><?= $is_edit ? 'Edit' : 'Add New' ?></span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title"><?= $is_edit ? 'Edit Media' : 'Add Media' ?></h2>
    <p class="page-sub"><?= $is_edit ? 'Update media details.' : 'Add video, audio, or image to the platform.' ?></p>
  </div>
  <a href="media.php" class="btn btn-ghost">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<form id="mediaForm" class="form-layout" autocomplete="off">

  <div class="form-main">

    <div class="panel">
      <div class="panel-body">

        <div class="field">
          <label for="title">Title</label>
          <input class="input input-lg" id="title" name="title" type="text"
                 placeholder="e.g. Attack on Titan S4 Trailer" value="<?= e($item['title']) ?>" required>
        </div>

        <div class="field">
          <label for="url">Embed / Source URL</label>
          <input class="input" id="url" name="url" type="url"
                 placeholder="https://..." value="<?= e($item['url']) ?>">
          <span class="field-hint">YouTube, Vimeo, SoundCloud, or direct file link.</span>
        </div>

        <div class="field">
          <label for="desc">Description</label>
          <textarea class="input" id="desc" name="desc" rows="5"
                    placeholder="Short description..."><?= e($item['desc']) ?></textarea>
        </div>

      </div>
    </div>

  </div>

  <aside class="form-side">

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Publish</h3>
      </div>
      <div class="panel-body">

        <div class="field">
          <label for="status">Status</label>
          <select class="input" id="status" name="status">
            <option value="draft" <?= $item['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $item['status'] === 'published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>

        <div class="form-actions">
          <a href="media.php" class="btn btn-ghost">Cancel</a>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-check"></i>
            <span><?= $is_edit ? 'Save Changes' : 'Create' ?></span>
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
          <label for="type">Type</label>
          <select class="input" id="type" name="type" required>
            <?php foreach ($types as $t): ?>
              <option value="<?= e($t) ?>" <?= $item['type'] === $t ? 'selected' : '' ?>>
                <?= e(ucfirst($t)) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="category">Category</label>
          <select class="input" id="category" name="category" required>
            <option value="">Select category</option>
            <?php foreach ($categories as $slug => $name): ?>
              <option value="<?= e($slug) ?>" <?= $item['category'] === $slug ? 'selected' : '' ?>>
                <?= e($name) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="duration">Duration</label>
          <input class="input" id="duration" name="duration" type="text"
                 placeholder="e.g. 2:14" value="<?= e($item['duration']) ?>">
          <span class="field-hint">Leave empty for images.</span>
        </div>

        <div class="field">
          <label for="tags">Tags</label>
          <input class="input" id="tags" name="tags" type="text"
                 placeholder="comma, separated" value="<?= e($item['tags']) ?>">
        </div>

      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Thumbnail</h3>
      </div>
      <div class="panel-body">

        <div class="upload-box" id="thumbBox">
          <i class="fa-regular fa-image"></i>
          <p>Click to upload thumbnail</p>
          <span>PNG, JPG up to 2MB</span>
          <input type="file" id="thumbInput" accept="image/*" hidden>
        </div>

      </div>
    </div>

  </aside>

</form>

<?php include __DIR__ . '/includes/footer.php'; ?>