<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Settings";
$active_menu = "settings";
$page_css    = "page-settings.css";
$page_js     = "page-settings.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo — Laravel: Setting::pluck('value','key')
$settings = [
    'site_name'        => 'Fan Hub Plus',
    'site_tagline'     => 'Every fandom. One home.',
    'contact_email'    => 'admin@fanhubplus.com',
    'items_per_page'   => 15,
    'allow_signups'    => true,
    'require_approval' => true,
    'maintenance_mode' => false,
    'default_theme'    => 'dark',
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Settings</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Settings</h2>
    <p class="page-sub">Platform configuration and preferences.</p>
  </div>
</div>

<div class="settings-layout">

  <!-- tabs -->
  <aside class="settings-tabs">
    <button class="settings-tab is-active" data-tab="general">
      <i class="fa-solid fa-sliders"></i> General
    </button>
    <button class="settings-tab" data-tab="users">
      <i class="fa-solid fa-users"></i> Users
    </button>
    <button class="settings-tab" data-tab="content">
      <i class="fa-solid fa-rectangle-list"></i> Content
    </button>
    <button class="settings-tab" data-tab="advanced">
      <i class="fa-solid fa-gear"></i> Advanced
    </button>
  </aside>

  <!-- panels -->
  <div class="settings-main">

    <form id="settingsForm">

      <!-- general -->
      <div class="settings-panel is-active" data-panel="general">
        <div class="panel">
          <div class="panel-head">
            <div>
              <h3 class="panel-title">Site Identity</h3>
              <p class="panel-sub">Basic information shown across the platform</p>
            </div>
          </div>
          <div class="panel-body">
            <div class="field">
              <label for="site_name">Site name</label>
              <input class="input" id="site_name" name="site_name" type="text"
                     value="<?= e($settings['site_name']) ?>">
            </div>
            <div class="field">
              <label for="site_tagline">Tagline</label>
              <input class="input" id="site_tagline" name="site_tagline" type="text"
                     value="<?= e($settings['site_tagline']) ?>">
            </div>
            <div class="field">
              <label for="contact_email">Contact email</label>
              <input class="input" id="contact_email" name="contact_email" type="email"
                     value="<?= e($settings['contact_email']) ?>">
            </div>
          </div>
        </div>
      </div>

      <!-- users -->
      <div class="settings-panel" data-panel="users">
        <div class="panel">
          <div class="panel-head">
            <div>
              <h3 class="panel-title">User Settings</h3>
              <p class="panel-sub">Registration and permissions</p>
            </div>
          </div>
          <div class="panel-body">
            <label class="switch-row">
              <div>
                <strong>Allow new signups</strong>
                <span>Visitors can create accounts</span>
              </div>
              <input type="checkbox" name="allow_signups" <?= $settings['allow_signups'] ? 'checked' : '' ?>>
              <span class="switch-track"><span class="switch-thumb"></span></span>
            </label>

            <label class="switch-row">
              <div>
                <strong>Require admin approval</strong>
                <span>New accounts need approval before activation</span>
              </div>
              <input type="checkbox" name="require_approval" <?= $settings['require_approval'] ? 'checked' : '' ?>>
              <span class="switch-track"><span class="switch-thumb"></span></span>
            </label>
          </div>
        </div>
      </div>

      <!-- content -->
      <div class="settings-panel" data-panel="content">
        <div class="panel">
          <div class="panel-head">
            <div>
              <h3 class="panel-title">Content Settings</h3>
              <p class="panel-sub">Pagination and display options</p>
            </div>
          </div>
          <div class="panel-body">
            <div class="field">
              <label for="items_per_page">Items per page</label>
              <select class="input" id="items_per_page" name="items_per_page">
                <?php foreach ([10, 15, 20, 25, 50] as $n): ?>
                  <option value="<?= $n ?>" <?= $settings['items_per_page'] === $n ? 'selected' : '' ?>>
                    <?= $n ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="field">
              <label for="default_theme">Default theme</label>
              <select class="input" id="default_theme" name="default_theme">
                <option value="dark" <?= $settings['default_theme'] === 'dark' ? 'selected' : '' ?>>Dark</option>
                <option value="light" <?= $settings['default_theme'] === 'light' ? 'selected' : '' ?>>Light</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- advanced -->
      <div class="settings-panel" data-panel="advanced">
        <div class="panel">
          <div class="panel-head">
            <div>
              <h3 class="panel-title">Advanced</h3>
              <p class="panel-sub">Use with caution</p>
            </div>
          </div>
          <div class="panel-body">
            <label class="switch-row">
              <div>
                <strong>Maintenance mode</strong>
                <span>Public site will show maintenance page</span>
              </div>
              <input type="checkbox" name="maintenance_mode" <?= $settings['maintenance_mode'] ? 'checked' : '' ?>>
              <span class="switch-track"><span class="switch-thumb"></span></span>
            </label>
          </div>
        </div>
      </div>

      <!-- save -->
      <div class="settings-actions">
        <button type="submit" class="btn btn-primary">
          <i class="fa-solid fa-check"></i>
          <span>Save Changes</span>
        </button>
      </div>

    </form>

  </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>