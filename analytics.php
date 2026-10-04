<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Analytics";
$active_menu = "analytics";
$page_css    = "page-analytics.css";
$page_js     = "page-analytics.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo stats — Laravel will aggregate from real data
$kpis = [
    ['label' => 'Active Users',      'value' => '2,847',  'trend' => '+12.4%', 'icon' => 'fa-users',        'tone' => '#8237AC'],
    ['label' => 'Sessions',          'value' => '18.4K',  'trend' => '+8.2%',  'icon' => 'fa-chart-line',   'tone' => '#653C9E'],
    ['label' => 'Chatbot Queries',   'value' => '4,203',  'trend' => '+21.7%', 'icon' => 'fa-robot',        'tone' => '#6F3788'],
    ['label' => 'Avg. Session Time', 'value' => '6m 42s', 'trend' => '+3.1%',  'icon' => 'fa-clock',        'tone' => '#22217A'],
];

$category_data = [
    ['name' => 'Anime',    'count' => 218, 'color' => '#E85D3D'],
    ['name' => 'Gaming',   'count' => 176, 'color' => '#7B5FA8'],
    ['name' => 'Movies',   'count' => 142, 'color' => '#8237AC'],
    ['name' => 'TV Shows', 'count' => 98,  'color' => '#22217A'],
    ['name' => 'K-Pop',    'count' => 87,  'color' => '#D96FA0'],
    ['name' => 'Comics',   'count' => 64,  'color' => '#E8A33D'],
    ['name' => 'Manga',    'count' => 51,  'color' => '#5A4578'],
    ['name' => 'Cosplay',  'count' => 28,  'color' => '#653C9E'],
];

$top_pages = [
    ['path' => '/anime/attack-on-titan',    'views' => 12400, 'avg_time' => '5:20'],
    ['path' => '/gaming/elden-ring',        'views' => 9800,  'avg_time' => '6:10'],
    ['path' => '/kpop/bts-concert-2025',    'views' => 7400,  'avg_time' => '4:45'],
    ['path' => '/manga/top-10-2025',        'views' => 6200,  'avg_time' => '7:30'],
    ['path' => '/movies/spider-verse',      'views' => 5800,  'avg_time' => '3:55'],
];

$traffic_sources = [
    ['name' => 'Direct',    'pct' => 42],
    ['name' => 'Search',    'pct' => 28],
    ['name' => 'Social',    'pct' => 18],
    ['name' => 'Referral',  'pct' => 12],
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Analytics</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Analytics</h2>
    <p class="page-sub">Usage statistics across the platform.</p>
  </div>
  <div class="page-actions">
    <select class="input filter-select" id="rangeFilter">
      <option value="7">Last 7 days</option>
      <option value="30" selected>Last 30 days</option>
      <option value="90">Last 90 days</option>
    </select>
    <button class="btn btn-ghost" id="exportBtn">
      <i class="fa-solid fa-download"></i>
      <span>Export</span>
    </button>
  </div>
</div>

<!-- KPI cards -->
<section class="kpi-grid">
  <?php foreach ($kpis as $k): ?>
    <article class="kpi-card">
      <div class="kpi-icon" style="--tone: <?= $k['tone'] ?>">
        <i class="fa-solid <?= $k['icon'] ?>"></i>
      </div>
      <div class="kpi-body">
        <span class="kpi-label"><?= e($k['label']) ?></span>
        <span class="kpi-value"><?= e($k['value']) ?></span>
        <span class="kpi-trend up">
          <i class="fa-solid fa-arrow-trend-up"></i> <?= e($k['trend']) ?>
        </span>
      </div>
    </article>
  <?php endforeach; ?>
</section>

<!-- main chart -->
<div class="panel">
  <div class="panel-head">
    <div>
      <h3 class="panel-title">Traffic Overview</h3>
      <p class="panel-sub">Visitors, registered users, and chatbot usage</p>
    </div>
  </div>
  <div class="panel-body">
    <canvas id="trafficChart" height="110"></canvas>
  </div>
</div>

<!-- 2-column charts -->
<section class="charts-row">
  <article class="panel">
    <div class="panel-head">
      <div>
        <h3 class="panel-title">Content by Category</h3>
        <p class="panel-sub">Distribution across 8 fandoms</p>
      </div>
    </div>
    <div class="panel-body">
      <canvas id="categoryChart" height="180"></canvas>
    </div>
  </article>

  <article class="panel">
    <div class="panel-head">
      <div>
        <h3 class="panel-title">Traffic Sources</h3>
        <p class="panel-sub">Where visitors come from</p>
      </div>
    </div>
    <div class="panel-body">
      <canvas id="trafficSourcesChart" height="180"></canvas>
    </div>
  </article>
</section>

<!-- bottom row -->
<section class="bottom-row">

  <!-- top pages -->
  <article class="panel">
    <div class="panel-head">
      <div>
        <h3 class="panel-title">Top Pages</h3>
        <p class="panel-sub">Most visited content</p>
      </div>
    </div>
    <div class="panel-body no-pad">
      <table class="table mini-table">
        <thead>
          <tr>
            <th>Page</th>
            <th>Views</th>
            <th>Avg. Time</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($top_pages as $p): ?>
            <tr>
              <td>
                <span class="page-path"><?= e($p['path']) ?></span>
              </td>
              <td><span class="mono"><?= compact_number($p['views']) ?></span></td>
              <td><span class="mono time-cell"><?= e($p['avg_time']) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </article>

  <!-- chatbot interaction -->
  <article class="panel">
    <div class="panel-head">
      <div>
        <h3 class="panel-title">Chatbot Interactions</h3>
        <p class="panel-sub">Last 7 days</p>
      </div>
    </div>
    <div class="panel-body">
      <canvas id="chatbotChart" height="180"></canvas>
    </div>
  </article>

</section>

<?php include __DIR__ . '/includes/footer.php'; ?>