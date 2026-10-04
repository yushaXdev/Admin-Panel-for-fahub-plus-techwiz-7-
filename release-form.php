<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$is_edit = $id > 0;

$page_title  = $is_edit ? "Edit Release" : "Add Release";
$active_menu = "releases";
$page_css    = "page-release-form.css";
$page_js     = "page-release-form.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

$release = [
    'id'       => $id,
    'title'    => $is_edit ? 'Attack on Titan Final Chapter' : '',
    'category' => $is_edit ? 'anime' : '',
    'type'     => $is_edit ? 'Episode' : 'Episode',
    'date'     => $is_edit ? '2025-11-15' : '',
    'platform' => $is_edit ? 'Crunchyroll' : '',
    'link'     => $is_edit ? 'https://crunchyroll.com/example' : '',
    'desc'     => $is_edit ? 'The final episode of the series.' : '',
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

$types = ['Episode', 'Season', 'Movie', 'Album', 'Single', 'Game', 'DLC', 'Chapter', 'Volume', 'Merch', 'Announcement'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <a href="upcoming-releases.php">Upcoming Releases</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span><?= $is_edit ? 'Edit' : 'Add New' ?></span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title"><?= $is_edit ? 'Edit Release' : 'Add Release' ?></h2>
    <p class="page-sub"><?= $is_edit ? 'Update release details.' : 'Announce an upcoming release.' ?></p>
  </div>
  <a href="upcoming-releases.php" class="btn btn-ghost">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<form id="releaseForm" class="form-layout" autocomplete="off">

  <div class="form-main">

    <div class="panel">
      <div class="panel-body">

        <div class="field">
          <label for="title">Release title</label>
          <input class="input input-lg" id="title" name="title" type="text"
                 placeholder="e.g. Attack on Titan Final Chapter" value="<?= e($release['title']) ?>" required>
        </div>

        <div class="field">
          <label for="desc">Description</label>
          <textarea class="input" id="desc" name="desc" rows="4"
                    placeholder="Short description..."><?= e($release['desc']) ?></textarea>
        </div>

      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">
          <i class="fa-regular fa-calendar-days"></i> Release Info
        </h3>
      </div>
      <div class="panel-body">

        <div class="grid-2">
          <div class="field">
            <label for="date">Release date</label>
            <input class="input" id="date" name="date" type="date"
                   value="<?= e($release['date']) ?>" required>
          </div>
          <div class="field">
            <label for="type">Type</label>
            <select class="input" id="type" name="type" required>
              <?php foreach ($types as $t): ?>
                <option value="<?= e($t) ?>" <?= $release['type'] === $t ? 'selected' : '' ?>>
                  <?= e($t) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="field">
          <label for="platform">Platform / Where</label>
          <input class="input" id="platform" name="platform" type="text"
                 placeholder="e.g. Crunchyroll, Steam, Cinemas" value="<?= e($release['platform']) ?>">
        </div>

        <div class="field">
          <label for="link">External link</label>
          <input class="input" id="link" name="link" type="url"
                 placeholder="https://..." value="<?= e($release['link']) ?>">
          <span class="field-hint">Optional — official page or trailer link.</span>
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
            <option value="draft" <?= $release['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $release['status'] === 'published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>

        <div class="form-actions">
          <a href="upcoming-releases.php" class="btn btn-ghost">Cancel</a>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-check"></i>
            <span><?= $is_edit ? 'Save' : 'Create' ?></span>
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
              <option value="<?= e($slug) ?>" <?= $release['category'] === $slug ? 'selected' : '' ?>>
                <?= e($name) ?>
              </option>
            <?php endforeach; ?>
          </select>
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