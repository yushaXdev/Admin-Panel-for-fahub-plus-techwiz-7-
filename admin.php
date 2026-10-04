<?php

// SESSION START
session_start();

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Dashboard";
$active_menu = "dashboard";
$page_css    = "page-dashboard.css";
$page_js     = "page-dashboard.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

/* INSHAL YAI DEMO DATA HAY TUM ISKO REPLACE KRO GY */
$admin_name = $_SESSION['admin_username'] ?? 'Admin';
$first_name = explode('@', explode(' ', trim($admin_name))[0])[0];

// this will greet the admin
$hour = (int)date('H');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

$stats = [
    'users'       => 12480,
    'content'     => 864,
    'submissions' => 37,
    'queries'     => 4203,
];

$categories = [
    ['slug' => 'anime',    'name' => 'Anime',    'count' => 218, 'trend' => +12],
    ['slug' => 'gaming',   'name' => 'Gaming',   'count' => 176, 'trend' => +8],
    ['slug' => 'movies',   'name' => 'Movies',   'count' => 142, 'trend' => +4],
    ['slug' => 'tv-shows', 'name' => 'TV Shows', 'count' => 98,  'trend' => -2],
    ['slug' => 'kpop',     'name' => 'K-Pop',    'count' => 87,  'trend' => +15],
    ['slug' => 'comics',   'name' => 'Comics',   'count' => 64,  'trend' => +3],
    ['slug' => 'manga',    'name' => 'Manga',    'count' => 51,  'trend' => +6],
    ['slug' => 'cosplay',  'name' => 'Cosplay',  'count' => 28,  'trend' => +9],
];

$recent_submissions = [
    ['title' => 'Attack on Titan S4 Review',    'user' => 'mika_asa',      'cat' => 'anime',   'when' => '5 min ago',  'status' => 'pending'],
    ['title' => 'Elden Ring Boss Guide',        'user' => 'tarnished_01',  'cat' => 'gaming',  'when' => '22 min ago', 'status' => 'pending'],
    ['title' => 'BTS Concert Recap 2025',       'user' => 'army_forever',  'cat' => 'kpop',    'when' => '1 hr ago',   'status' => 'approved'],
    ['title' => 'Cosplay: Jinx from Arcane',    'user' => 'artof_chloe',   'cat' => 'cosplay', 'when' => '2 hr ago',   'status' => 'pending'],
    ['title' => 'Top 10 Manga of 2025',         'user' => 'otaku_sensei',  'cat' => 'manga',   'when' => '3 hr ago',   'status' => 'approved'],
];

$recent_feedback = [
    ['type' => 'bug',       'msg' => 'Video player not loading on mobile',    'when' => '10 min ago'],
    ['type' => 'suggestion','msg' => 'Add dark mode to public site',          'when' => '45 min ago'],
    ['type' => 'query',     'msg' => 'How do I bookmark a character?',        'when' => '1 hr ago'],
];
?>

<!-- Breadcrumbs -->
<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Dashboard</span>
</nav>

<!-- Page header -->
<div class="page-header">
  <div>
    <h2 class="page-title"><?= $greeting ?>, <?= e($first_name) ?>.</h2>
    <p class="page-sub">Here's what's happening across Fan Hub Plus today.</p>
  </div>
  <div class="page-actions">
    <button class="btn btn-ghost" type="button">
      <i class="fa-solid fa-download"></i>
      <span>Export</span>
    </button>
    <a href="article-form.php" class="btn btn-primary">
      <i class="fa-solid fa-plus"></i>
      <span>New Content</span>
    </a>
  </div>
</div>

<!-- STATS -->
<section class="stats-grid" aria-label="Key metrics">

  <article class="stat-card">
    <div class="stat-icon" style="--tone:#8237AC">
      <i class="fa-solid fa-users"></i>
    </div>
    <div class="stat-body">
      <span class="stat-label">Total Users</span>
      <span class="stat-value"><?= compact_number($stats['users']) ?></span>
      <span class="stat-trend up">
        <i class="fa-solid fa-arrow-trend-up"></i> +12.4%
      </span>
    </div>
  </article>

  <article class="stat-card">
    <div class="stat-icon" style="--tone:#653C9E">
      <i class="fa-solid fa-rectangle-list"></i>
    </div>
    <div class="stat-body">
      <span class="stat-label">Content Items</span>
      <span class="stat-value"><?= compact_number($stats['content']) ?></span>
      <span class="stat-trend up">
        <i class="fa-solid fa-arrow-trend-up"></i> +8.1%
      </span>
    </div>
  </article>

  <article class="stat-card">
    <div class="stat-icon" style="--tone:#6F3788">
      <i class="fa-solid fa-inbox"></i>
    </div>
    <div class="stat-body">
      <span class="stat-label">Pending Submissions</span>
      <span class="stat-value"><?= (int)$stats['submissions'] ?></span>
      <span class="stat-trend warn">
        <i class="fa-solid fa-clock"></i> Awaiting review
      </span>
    </div>
  </article>

  <article class="stat-card">
    <div class="stat-icon" style="--tone:#22217A">
      <i class="fa-solid fa-robot"></i>
    </div>
    <div class="stat-body">
      <span class="stat-label">Chatbot Queries</span>
      <span class="stat-value"><?= compact_number($stats['queries']) ?></span>
      <span class="stat-trend up">
        <i class="fa-solid fa-arrow-trend-up"></i> +21.7%
      </span>
    </div>
  </article>

</section>

<!-- CHARTS -->
<section class="charts-row">

  <!-- Activity chart -->
  <article class="panel">
    <header class="panel-head">
      <div>
        <h3 class="panel-title">Platform Activity</h3>
        <p class="panel-sub">Visitors vs registered users — last 7 days</p>
      </div>
      <div class="panel-tabs">
        <button class="tab is-active" data-range="7d">7D</button>
        <button class="tab" data-range="30d">30D</button>
        <button class="tab" data-range="90d">90D</button>
      </div>
    </header>
    <div class="panel-body">
      <canvas id="activityChart" height="120"></canvas>
    </div>
  </article>

  <!-- Category distribution -->
  <article class="panel">
    <header class="panel-head">
      <div>
        <h3 class="panel-title">Content by Category</h3>
        <p class="panel-sub">Distribution across 8 fandoms</p>
      </div>
    </header>
    <div class="panel-body">
      <canvas id="categoryChart" height="180"></canvas>
    </div>
  </article>

</section>

<!-- BOTTOM -->
<section class="bottom-row">

  <!-- Popular categories list -->
  <article class="panel">
    <header class="panel-head">
      <div>
        <h3 class="panel-title">Popular Categories</h3>
        <p class="panel-sub">By content volume</p>
      </div>
      <a href="categories.php" class="link-sm">Manage</a>
    </header>
    <div class="panel-body">
      <ul class="cat-list">
        <?php foreach ($categories as $c): ?>
          <li class="cat-row">
            <span class="cat-dot" style="background: <?= category_color($c['slug']) ?>"></span>
            <span class="cat-name"><?= e($c['name']) ?></span>
            <div class="cat-bar">
              <span class="cat-fill"
                    style="width: <?= round(($c['count'] / 218) * 100) ?>%;
                           background: <?= category_color($c['slug']) ?>"></span>
            </div>
            <span class="cat-count"><?= (int)$c['count'] ?></span>
            <span class="cat-trend <?= $c['trend'] >= 0 ? 'up' : 'down' ?>">
              <i class="fa-solid fa-arrow-<?= $c['trend'] >= 0 ? 'up' : 'down' ?>"></i>
              <?= abs($c['trend']) ?>%
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </article>

  <!-- Recent submissions -->
  <article class="panel">
    <header class="panel-head">
      <div>
        <h3 class="panel-title">Recent Submissions</h3>
        <p class="panel-sub">Fan content awaiting moderation</p>
      </div>
      <a href="fan-submissions.php" class="link-sm">View all</a>
    </header>
    <div class="panel-body no-pad">
      <ul class="list">
        <?php foreach ($recent_submissions as $s): ?>
          <li class="list-row">
            <span class="list-dot" style="background: <?= category_color($s['cat']) ?>"></span>
            <div class="list-main">
              <p class="list-title"><?= e($s['title']) ?></p>
              <p class="list-meta">
                <i class="fa-regular fa-user"></i> <?= e($s['user']) ?>
                <span class="dot">·</span>
                <?= e($s['when']) ?>
              </p>
            </div>
            <?= status_badge($s['status']) ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </article>

  <!-- Recent feedback -->
  <article class="panel">
    <header class="panel-head">
      <div>
        <h3 class="panel-title">Recent Feedback</h3>
        <p class="panel-sub">Bug reports, suggestions & queries</p>
      </div>
      <a href="feedback.php" class="link-sm">View all</a>
    </header>
    <div class="panel-body no-pad">
      <ul class="list">
        <?php foreach ($recent_feedback as $f):
          $icons = [
            'bug'        => ['fa-bug',              'danger'],
            'suggestion' => ['fa-lightbulb',        'warn'],
            'query'      => ['fa-circle-question',  'info'],
          ];
          [$icon, $tone] = $icons[$f['type']] ?? ['fa-comment', 'neutral'];
        ?>
          <li class="list-row">
            <span class="list-icon tone-<?= $tone ?>">
              <i class="fa-solid <?= $icon ?>"></i>
            </span>
            <div class="list-main">
              <p class="list-title"><?= e($f['msg']) ?></p>
              <p class="list-meta">
                <span class="tag"><?= ucfirst($f['type']) ?></span>
                <span class="dot">·</span>
                <?= e($f['when']) ?>
              </p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </article>

</section>

<?php include __DIR__ . '/includes/footer.php'; ?>