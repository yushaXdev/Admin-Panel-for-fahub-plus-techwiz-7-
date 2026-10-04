<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Events";
$active_menu = "events";
$page_css    = "page-events.css";
$page_js     = "page-events.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Event::with('category')->orderBy('event_date')->paginate(12)
$events = [
    ['id' => 1, 'title' => 'Anime Expo 2025',        'category' => 'anime',   'city' => 'Los Angeles',  'venue' => 'LA Convention Center', 'date' => '2025-07-04', 'time' => '10:00 AM', 'status' => 'published', 'tickets' => 'https://animeexpo.com'],
    ['id' => 2, 'title' => 'Comic-Con International','category' => 'comics',  'city' => 'San Diego',    'venue' => 'SDCC Hall',            'date' => '2025-07-24', 'time' => '9:00 AM',  'status' => 'published', 'tickets' => 'https://comic-con.org'],
    ['id' => 3, 'title' => 'K-Pop World Festival',    'category' => 'kpop',    'city' => 'Seoul',        'venue' => 'Olympic Stadium',      'date' => '2025-08-15', 'time' => '6:00 PM',  'status' => 'published', 'tickets' => ''],
    ['id' => 4, 'title' => 'E3 Gaming Expo',          'category' => 'gaming',  'city' => 'Los Angeles',  'venue' => 'LA Convention Center', 'date' => '2025-06-10', 'time' => '11:00 AM', 'status' => 'draft',     'tickets' => ''],
    ['id' => 5, 'title' => 'Cosplay Championship',    'category' => 'cosplay', 'city' => 'Karachi',      'venue' => 'Expo Center',          'date' => '2025-05-20', 'time' => '2:00 PM',  'status' => 'published', 'tickets' => 'https://tickets.example.com'],
    ['id' => 6, 'title' => 'Manga Art Exhibition',    'category' => 'manga',   'city' => 'Tokyo',        'venue' => 'Mori Art Museum',      'date' => '2025-09-01', 'time' => '10:00 AM', 'status' => 'published', 'tickets' => ''],
    ['id' => 7, 'title' => 'Marvel Movie Premiere',   'category' => 'movies',  'city' => 'New York',     'venue' => 'AMC Lincoln Square',   'date' => '2025-05-05', 'time' => '7:00 PM',  'status' => 'draft',     'tickets' => ''],
    ['id' => 8, 'title' => 'Fan Meetup: Lahore',      'category' => 'anime',   'city' => 'Lahore',       'venue' => 'Packages Mall',        'date' => '2025-04-18', 'time' => '4:00 PM',  'status' => 'published', 'tickets' => ''],
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

// unique cities for dropdown
$cities = array_unique(array_column($events, 'city'));
sort($cities);
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Events</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Events</h2>
    <p class="page-sub">Conventions, meetups, and screenings — location-aware.</p>
  </div>
  <button class="btn btn-primary" id="addEventBtn">
    <i class="fa-solid fa-plus"></i>
    <span>Add Event</span>
  </button>
</div>

<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="eventSearch" placeholder="Search by title or venue...">
  </div>
  <select class="input filter-select" id="categoryFilter">
    <option value="">All categories</option>
    <?php foreach ($categories as $slug => $name): ?>
      <option value="<?= e($slug) ?>"><?= e($name) ?></option>
    <?php endforeach; ?>
  </select>
  <select class="input filter-select" id="cityFilter">
    <option value="">All cities</option>
    <?php foreach ($cities as $c): ?>
      <option value="<?= e(strtolower($c)) ?>"><?= e($c) ?></option>
    <?php endforeach; ?>
  </select>
</div>

<!-- events list -->
<div class="events-list" id="eventsList">
  <?php foreach ($events as $ev): ?>
    <article class="event-card"
             data-title="<?= e(strtolower($ev['title'])) ?>"
             data-venue="<?= e(strtolower($ev['venue'])) ?>"
             data-category="<?= e($ev['category']) ?>"
             data-city="<?= e(strtolower($ev['city'])) ?>">

      <div class="event-date" style="--c: <?= category_color($ev['category']) ?>">
        <span class="event-day"><?= date('d', strtotime($ev['date'])) ?></span>
        <span class="event-month"><?= date('M', strtotime($ev['date'])) ?></span>
      </div>

      <div class="event-main">
        <h3 class="event-title"><?= e($ev['title']) ?></h3>
        <div class="event-meta">
          <span><i class="fa-solid fa-location-dot"></i> <?= e($ev['venue']) ?>, <?= e($ev['city']) ?></span>
          <span><i class="fa-regular fa-clock"></i> <?= e($ev['time']) ?></span>
        </div>
        <div class="event-tags">
          <span class="cat-pill" style="--c: <?= category_color($ev['category']) ?>">
            <?= e($categories[$ev['category']] ?? $ev['category']) ?>
          </span>
          <?= status_badge($ev['status']) ?>
          <?php if ($ev['tickets']): ?>
            <span class="ticket-tag">
              <i class="fa-solid fa-ticket"></i> Tickets
            </span>
          <?php endif; ?>
        </div>
      </div>

      <div class="event-actions">
        <a href="event-form.php?id=<?= (int)$ev['id'] ?>" class="icon-btn" aria-label="Edit">
          <i class="fa-regular fa-pen-to-square"></i>
        </a>
        <button class="icon-btn danger" data-confirm="Delete this event?" aria-label="Delete">
          <i class="fa-regular fa-trash-can"></i>
        </button>
      </div>

    </article>
  <?php endforeach; ?>
</div>

<div class="empty hide" id="noResults">
  <i class="fa-regular fa-calendar-xmark"></i>
  <p>No events match your filters.</p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>