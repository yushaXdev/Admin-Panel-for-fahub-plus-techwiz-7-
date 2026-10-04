<!-- Universal Top Navbar -->

<?php
?>
<header class="navbar">

  <!-- Left: hamburger + page title -->
  <div class="navbar-left">
    <button class="icon-btn navbar-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
      <i class="fa-solid fa-bars"></i>
    </button>
    <h1 class="navbar-title"><?= e($page_title) ?></h1>
  </div>

  <!-- Center: search -->
  <div class="navbar-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" placeholder="Search content, users, categories..." aria-label="Search">
    <kbd>⌘K</kbd>
  </div>

  <!-- Right: actions -->
  <div class="navbar-right">

    <!-- Theme toggle -->
    <button class="icon-btn" id="themeToggle" aria-label="Toggle theme" title="Toggle theme">
      <i class="fa-regular fa-moon" data-theme-icon></i>
    </button>

    <!-- Notifications -->
    <div class="dropdown">
      <button class="icon-btn dropdown-toggle" data-dropdown aria-label="Notifications">
        <i class="fa-regular fa-bell"></i>
        <span class="dot-badge"></span>
      </button>
      <div class="dropdown-menu dropdown-notifications">
        <div class="dropdown-head">
          <span>Notifications</span>
          <a href="notifications.php" class="link-sm">View all</a>
        </div>
        <div class="dropdown-empty">
          <i class="fa-regular fa-bell-slash"></i>
          <p>No new notifications</p>
        </div>
      </div>
    </div>

    <!-- Profile -->
    <div class="dropdown">
      <button class="profile-trigger dropdown-toggle" data-dropdown>
        <span class="avatar"><?= e($admin_initials) ?></span>
        <span class="profile-name"><?= e($admin_name) ?></span>
        <i class="fa-solid fa-chevron-down chev"></i>
      </button>
      <div class="dropdown-menu dropdown-profile">
        <div class="dropdown-user">
          <span class="avatar avatar-lg"><?= e($admin_initials) ?></span>
          <div>
            <p class="user-name"><?= e($admin_name) ?></p>
            <p class="user-mail">admin@fanhubplus.com</p>
          </div>
        </div>
        <div class="dropdown-divider"></div>
        <a href="profile.php" class="dropdown-item">
          <i class="fa-regular fa-user"></i>
          <span>My Profile</span>
        </a>
        <a href="settings.php" class="dropdown-item">
          <i class="fa-solid fa-sliders"></i>
          <span>Settings</span>
        </a>
        <a href="#" class="dropdown-item">
          <i class="fa-regular fa-circle-question"></i>
          <span>Help &amp; Support</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="logout.php" class="dropdown-item dropdown-item-danger">
          <i class="fa-solid fa-arrow-right-from-bracket"></i>
          <span>Sign out</span>
        </a>
      </div>
    </div>

  </div>

</header>