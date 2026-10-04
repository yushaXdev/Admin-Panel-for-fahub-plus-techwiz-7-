<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 1);

$page_title  = "Review Submission";
$active_menu = "submissions";
$page_css    = "page-submission-review.css";
$page_js     = "page-submission-review.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Submission::with('user','category')->findOrFail($id)
$sub = [
    'id'       => $id,
    'title'    => 'Attack on Titan S4 Review',
    'user'     => 'mika_asa',
    'email'    => 'mika@fanhub.com',
    'category' => 'anime',
    'type'     => 'article',
    'status'   => 'pending',
    'date'     => '2025-03-15',
    'excerpt'  => 'A deep dive into the final season.',
    'content'  => "The final season of Attack on Titan delivers an emotional and visually stunning conclusion.\n\nThe animation quality has improved dramatically, and the soundtrack continues to elevate every key moment. Voice acting brings the characters to life in ways that manga readers could only imagine.\n\nWhat stands out most is the thematic weight — freedom, sacrifice, and the cycle of violence are explored with nuance that rewards careful viewing.",
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
  <a href="fan-submissions.php">Fan Submissions</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Review #<?= (int)$sub['id'] ?></span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Review Submission</h2>
    <p class="page-sub">Approve or reject fan content before publishing.</p>
  </div>
  <a href="fan-submissions.php" class="btn btn-ghost">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<div class="review-layout">

  <!-- main: submission content -->
  <div class="review-main">

    <div class="panel">
      <div class="panel-head">
        <div>
          <h3 class="panel-title"><?= e($sub['title']) ?></h3>
          <p class="panel-sub">
            <span class="cat-pill" style="--c: <?= category_color($sub['category']) ?>">
              <?= e($categories[$sub['category']] ?? $sub['category']) ?>
            </span>
            <span class="sub-type-tag">
              <i class="fa-solid <?= content_type_icon($sub['type']) ?>"></i>
              <?= e(ucfirst($sub['type'])) ?>
            </span>
          </p>
        </div>
        <?= status_badge($sub['status']) ?>
      </div>
      <div class="panel-body">
        <p class="excerpt"><?= e($sub['excerpt']) ?></p>
        <div class="content-body">
          <?= nl2br(e($sub['content'])) ?>
        </div>
      </div>
    </div>

  </div>

  <!-- side: author + actions -->
  <aside class="review-side">

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Submitted By</h3>
      </div>
      <div class="panel-body">
        <div class="author-block">
          <span class="avatar avatar-lg"><?= e(initials($sub['user'])) ?></span>
          <div class="author-info">
            <strong><?= e($sub['user']) ?></strong>
            <span><?= e($sub['email']) ?></span>
          </div>
        </div>
        <div class="sub-meta">
          <div class="meta-row">
            <span class="meta-label">Submitted</span>
            <span class="meta-value"><?= nice_date($sub['date']) ?></span>
          </div>
          <div class="meta-row">
            <span class="meta-label">Category</span>
            <span class="meta-value"><?= e($categories[$sub['category']] ?? $sub['category']) ?></span>
          </div>
          <div class="meta-row">
            <span class="meta-label">Type</span>
            <span class="meta-value"><?= e(ucfirst($sub['type'])) ?></span>
          </div>
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">Moderation</h3>
      </div>
      <div class="panel-body">

        <div class="field">
          <label for="adminNote">Note to submitter (optional)</label>
          <textarea class="input" id="adminNote" rows="3"
                    placeholder="Reason for rejection, or feedback..."></textarea>
        </div>

        <div class="review-actions">
          <button class="btn btn-danger" id="rejectBtn">
            <i class="fa-solid fa-xmark"></i>
            <span>Reject</span>
          </button>
          <button class="btn btn-primary" id="approveBtn">
            <i class="fa-solid fa-check"></i>
            <span>Approve &amp; Publish</span>
          </button>
        </div>

      </div>
    </div>

  </aside>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>