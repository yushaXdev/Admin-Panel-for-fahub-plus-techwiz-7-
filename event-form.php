<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$id = (int)($_GET['id'] ?? 0);
$is_edit = $id > 0;

$page_title  = $is_edit ? "Edit Event" : "Add Event";
$active_menu = "events";
$page_css    = "page-event-form.css";
$page_js     = "page-event-form.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

$event = [
    'id'         => $id,
    'title'      => $is_edit ? 'Anime Expo 2025' : '',
    'category'   => $is_edit ? 'anime' : '',
    'venue'      => $is_edit ? 'LA Convention Center' : '',
    'city'       => $is_edit ? 'Los Angeles' : '',
    'address'    => $is_edit ? '1201 S Figueroa St, Los Angeles, CA' : '',
    'latitude'   => $is_edit ? '34.0407' : '',
    'longitude'  => $is_edit ? '-118.2697' : '',
    'date'       => $is_edit ? '2025-07-04' : '',
    'time'       => $is_edit ? '10:00 AM' : '',
    'tickets'    => $is_edit ? 'https://animeexpo.com' : '',
    'description'=> $is_edit ? 'Annual anime convention with panels, cosplay, and exclusive reveals.' : '',
    'status'     => $is_edit ? 'published' : 'draft',
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
  <a href="events.php">Events</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span><?= $is_edit ? 'Edit' : 'Add New' ?></span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title"><?= $is_edit ? 'Edit Event' : 'Add Event' ?></h2>
    <p class="page-sub"><?= $is_edit ? 'Update event details.' : 'Create a new fan event.' ?></p>
  </div>
  <a href="events.php" class="btn btn-ghost">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>
</div>

<form id="eventForm" class="form-layout" autocomplete="off">

  <div class="form-main">

    <div class="panel">
      <div class="panel-body">

        <div class="field">
          <label for="title">Event title</label>
          <input class="input input-lg" id="title" name="title" type="text"
                 placeholder="e.g. Anime Expo 2025" value="<?= e($event['title']) ?>" required>
        </div>

        <div class="field">
          <label for="description">Description</label>
          <textarea class="input" id="description" name="description" rows="5"
                    placeholder="What is this event about..."><?= e($event['description']) ?></textarea>
        </div>

      </div>
    </div>

    <!-- location -->
    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">
          <i class="fa-solid fa-location-dot"></i> Location
        </h3>
      </div>
      <div class="panel-body">

        <div class="field">
          <label for="venue">Venue</label>
          <input class="input" id="venue" name="venue" type="text"
                 placeholder="e.g. LA Convention Center" value="<?= e($event['venue']) ?>">
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="city">City</label>
            <input class="input" id="city" name="city" type="text"
                   placeholder="e.g. Los Angeles" value="<?= e($event['city']) ?>" required>
          </div>
          <div class="field">
            <label for="address">Address</label>
            <input class="input" id="address" name="address" type="text"
                   placeholder="Street address" value="<?= e($event['address']) ?>">
          </div>
        </div>

        <div class="grid-2">
          <div class="field">
            <label for="latitude">Latitude</label>
            <input class="input" id="latitude" name="latitude" type="text"
                   placeholder="34.0407" value="<?= e($event['latitude']) ?>">
          </div>
          <div class="field">
            <label for="longitude">Longitude</label>
            <input class="input" id="longitude" name="longitude" type="text"
                   placeholder="-118.2697" value="<?= e($event['longitude']) ?>">
          </div>
        </div>

        <div class="map-preview">
          <i class="fa-solid fa-map-location-dot"></i>
          <p>Map preview will appear here</p>
          <span>Backend dev will integrate Leaflet / Google Maps</span>
        </div>

      </div>
    </div>

    <!-- date & time -->
    <div class="panel">
      <div class="panel-head">
        <h3 class="panel-title">
          <i class="fa-regular fa-calendar-days"></i> Date &amp; Time
        </h3>
      </div>
      <div class="panel-body">

        <div class="grid-2">
          <div class="field">
            <label for="date">Date</label>
            <input class="input" id="date" name="date" type="date"
                   value="<?= e($event['date']) ?>" required>
          </div>
          <div class="field">
            <label for="time">Time</label>
            <input class="input" id="time" name="time" type="text"
                   placeholder="e.g. 10:00 AM" value="<?= e($event['time']) ?>">
          </div>
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
            <option value="draft" <?= $event['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $event['status'] === 'published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>

        <div class="form-actions">
          <a href="events.php" class="btn btn-ghost">Cancel</a>
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
              <option value="<?= e($slug) ?>" <?= $event['category'] === $slug ? 'selected' : '' ?>>
                <?= e($name) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <label for="tickets">Ticket URL</label>
          <input class="input" id="tickets" name="tickets" type="url"
                 placeholder="https://..." value="<?= e($event['tickets']) ?>">
          <span class="field-hint">Leave empty if free entry.</span>
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