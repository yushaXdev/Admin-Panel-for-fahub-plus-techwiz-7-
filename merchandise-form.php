<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$is_edit = $id > 0;

$page_title  = $is_edit ? "Edit Item" : "Add Item";
$active_menu = "merchandise";
$page_css    = "page-merchandise-form.css";
$page_js     = "page-merchandise-form.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

$item = [
    'id'          => $id,
    'name'        => $is_edit ? 'Eren Yeager Figurine' : '',
    'category'    => $is_edit ? 'anime' : '',
    'tag'         => $is_edit ? 'Limited Edition' : '',
    'price'       => $is_edit ? '49.99' : '',
    'desc'        => $is_edit ? 'Hand-painted collectible figurine.' : '',
    'status'      => $is_edit ? 'published' : 'draft',
    'is_upcoming' => $is_edit ? false : false,
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

$tags = ['', 'Limited Edition', 'Pre-Order', 'Collectible'];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <a href="merchandise.php">Merchandise</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span><?= $is_edit ? 'Edit' : 'Add New' ?></span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title"><?= $is_edit ? 'Edit Item' : 'Add Item' ?></h2>
    <p class="page-sub"><?= $is_edit ? 'Update merchandise details.' : 'Add a new showcase item.' ?></p>
  </div>
  <a href="merchandise.php" class="btn btn-ghost">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<form id="merchForm" class="form-layout" autocomplete="off">

  <div class="form-main">

    <div class="panel">
      <div class="panel-body">

        <div class="field">
          <label for="name">Item name</label>
          <input class="input input-lg" id="name" name="name" type="text"
                 placeholder="e.g. Eren Yeager Figurine" value="<?= e($item['name']) ?>" required>
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

        <label class="switch">
          <input type="checkbox" id="is_upcoming" name="is_upcoming" <?= $item['is_upcoming'] ? 'checked' : '' ?>>
          <span class="switch-track"><span class="switch-thumb"></span></span>
          <span class="switch-label">Upcoming release</span>
        </label>

        <div class="form-actions">
          <a href="merchandise.php" class="btn btn-ghost">Cancel</a>
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
            <?php foreach ($categories as $slug => $label): ?>
              <option value="<?= e($slug) ?>" <?= $item['category'] === $slug ? 'selected' : '' ?>>
                <?= e($label) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="tag">Tag</label>
          <select class="input" id="tag" name="tag">
            <?php foreach ($tags as $t): ?>
              <option value="<?= e($t) ?>" <?= $item['tag'] === $t ? 'selected' : '' ?>>
                <?= $t === '' ? 'None' : e($t) ?>
              </option>
            <?php endforeach; ?>
          </select>
          <span class="field-hint">SRS: Limited Edition, Pre-Order, Collectible.</span>
        </div>

        <div class="field">
          <label for="price">Display price</label>
          <input class="input" id="price" name="price" type="text"
                 placeholder="e.g. 49.99" value="<?= e($item['price']) ?>">
          <span class="field-hint">Display only. No purchase flow.</span>
        </div>

      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Product Image</h3>
      </div>
      <div class="panel-body">

        <div class="upload-box" id="imageBox">
          <i class="fa-regular fa-image"></i>
          <p>Click to upload image</p>
          <span>PNG, JPG up to 2MB</span>
          <input type="file" id="imageInput" accept="image/*" hidden>
        </div>

      </div>
    </div>

  </aside>

</form>

<?php include __DIR__ . '/includes/footer.php'; ?>