<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$is_edit = $id > 0;

$page_title  = $is_edit ? "Edit Character" : "Add Character";
$active_menu = "characters";
$page_css    = "page-character-form.css";
$page_js     = "page-character-form.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Character::findOrFail($id)
$char = [
    'id'       => $id,
    'name'     => $is_edit ? 'Eren Yeager' : '',
    'fandom'   => $is_edit ? 'Attack on Titan' : '',
    'category' => $is_edit ? 'anime' : '',
    'role'     => $is_edit ? 'Protagonist' : '',
    'status'   => $is_edit ? 'published' : 'draft',
    'bio'      => $is_edit ? 'Eren Yeager is the main protagonist of Attack on Titan. He vows to exterminate all Titans after his hometown is destroyed.' : '',
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
  <a href="characters.php">Characters</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span><?= $is_edit ? 'Edit' : 'Add New' ?></span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title"><?= $is_edit ? 'Edit Character' : 'Add Character' ?></h2>
    <p class="page-sub"><?= $is_edit ? 'Update the character details.' : 'Create a new character profile.' ?></p>
  </div>
  <a href="characters.php" class="btn btn-ghost">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<form id="characterForm" class="form-layout" autocomplete="off">

  <!-- main column -->
  <div class="form-main">

    <div class="panel">
      <div class="panel-body">

        <div class="field">
          <label for="name">Character name</label>
          <input class="input input-lg" id="name" name="name" type="text"
                 placeholder="e.g. Eren Yeager" value="<?= e($char['name']) ?>" required>
        </div>

        <div class="field">
          <label for="fandom">Fandom / Series</label>
          <input class="input" id="fandom" name="fandom" type="text"
                 placeholder="e.g. Attack on Titan" value="<?= e($char['fandom']) ?>" required>
        </div>

        <div class="field">
          <label for="bio">Biography</label>
          <textarea class="input" id="bio" name="bio" rows="8"
                    placeholder="Write a short biography..."><?= e($char['bio']) ?></textarea>
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
            <option value="draft" <?= $char['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $char['status'] === 'published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>

        <div class="form-actions">
          <a href="characters.php" class="btn btn-ghost">Cancel</a>
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
          <label for="category">Category</label>
          <select class="input" id="category" name="category" required>
            <option value="">Select category</option>
            <?php foreach ($categories as $slug => $label): ?>
              <option value="<?= e($slug) ?>" <?= $char['category'] === $slug ? 'selected' : '' ?>>
                <?= e($label) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="role">Role</label>
          <select class="input" id="role" name="role" required>
            <option value="">Select role</option>
            <?php foreach ($roles as $r): ?>
              <option value="<?= e($r) ?>" <?= $char['role'] === $r ? 'selected' : '' ?>>
                <?= e($r) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Character Image</h3>
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