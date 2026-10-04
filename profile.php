<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "My Profile";
$active_menu = "profile";
$page_css    = "page-profile.css";
$page_js     = "page-profile.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

$admin_name = $_SESSION['admin_username'] ?? 'Admin';

// demo — Laravel: auth()->user()
$user = [
    'name'   => $admin_name,
    'email'  => 'admin@fanhubplus.com',
    'role'   => 'Administrator',
    'joined' => '2024-09-15',
    'bio'    => 'Managing Fan Hub Plus. Fandom enthusiast.',
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>My Profile</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">My Profile</h2>
    <p class="page-sub">Manage your personal information and security.</p>
  </div>
</div>

<div class="profile-grid">

  <!-- left: avatar + summary -->
  <aside class="profile-side">
    <div class="panel">
      <div class="panel-body profile-summary">
        <span class="avatar avatar-xl"><?= e(initials($user['name'])) ?></span>
        <h3><?= e($user['name']) ?></h3>
        <p><?= e($user['email']) ?></p>
        <span class="role-tag"><?= e($user['role']) ?></span>

        <button class="btn btn-ghost btn-sm upload-avatar" id="changeAvatar">
          <i class="fa-regular fa-image"></i>
          <span>Change Photo</span>
        </button>
      </div>
    </div>
  </aside>

  <!-- right: forms -->
  <div class="profile-main">

    <!-- tabs -->
    <div class="tabs">
      <button class="tab is-active" data-tab="info">Personal Info</button>
      <button class="tab" data-tab="password">Password</button>
    </div>

    <!-- personal info -->
    <div class="tab-panel is-active" data-panel="info">
      <div class="panel">
        <div class="panel-body">
          <form class="form-grid" id="infoForm">
            <div class="field">
              <label for="name">Full name</label>
              <input class="input" id="name" type="text" value="<?= e($user['name']) ?>" required>
            </div>
            <div class="field">
              <label for="email">Email</label>
              <input class="input" id="email" type="email" value="<?= e($user['email']) ?>" required>
            </div>
            <div class="field">
              <label for="bio">Bio</label>
              <textarea class="input" id="bio" rows="4"><?= e($user['bio']) ?></textarea>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-check"></i>
                <span>Save Changes</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- password -->
    <div class="tab-panel" data-panel="password">
      <div class="panel">
        <div class="panel-body">
          <form class="form-grid" id="passwordForm">
            <div class="field">
              <label for="current">Current password</label>
              <input class="input" id="current" type="password" required>
            </div>
            <div class="field">
              <label for="newpass">New password</label>
              <input class="input" id="newpass" type="password" required>
              <span class="field-hint">Minimum 8 characters.</span>
            </div>
            <div class="field">
              <label for="confirm">Confirm new password</label>
              <input class="input" id="confirm" type="password" required>
            </div>
            <div class="form-actions">
              <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-lock"></i>
                <span>Update Password</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>