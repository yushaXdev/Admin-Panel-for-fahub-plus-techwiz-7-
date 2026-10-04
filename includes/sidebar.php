<!-- Universal sidebar, every .php will use this sidebar -->

<?php
?>
<aside class="sidebar" id="sidebar">

  <!-- Brand -->
  <div class="sidebar-brand">
    <a href="admin.php" class="brand-mark">
      <span class="brand-glyph"><i class="fa-solid fa-bolt"></i></span>
      <span class="brand-name">Fan Hub <em>Plus</em></span>
    </a>
  
  </div>

  <!-- Navigation -->
  <nav class="sidebar-nav" aria-label="Main navigation">

    <!-- MAIN -->
    <div class="nav-group">
      <p class="nav-group-label">Main</p>
      <ul class="nav-list">
        <li>
          <a href="admin.php" class="nav-item <?= is_active('dashboard', $active_menu) ?>">
            <i class="fa-solid fa-grip"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="analytics.php" class="nav-item <?= is_active('analytics', $active_menu) ?>">
            <i class="fa-solid fa-chart-line"></i>
            <span>Analytics</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- CONTENT -->
    <div class="nav-group">
      <p class="nav-group-label">Content</p>
      <ul class="nav-list">
        <li>
          <a href="categories.php" class="nav-item <?= is_active('categories', $active_menu) ?>">
            <i class="fa-solid fa-layer-group"></i>
            <span>Categories</span>
          </a>
        </li>
        <li>
          <a href="content.php" class="nav-item <?= is_active('content', $active_menu) ?>">
            <i class="fa-solid fa-rectangle-list"></i>
            <span>Content Library</span>
          </a>
        </li>
        <li>
          <a href="articles.php" class="nav-item <?= is_active('articles', $active_menu) ?>">
            <i class="fa-regular fa-newspaper"></i>
            <span>Articles</span>
          </a>
        </li>
        <li>
          <a href="characters.php" class="nav-item <?= is_active('characters', $active_menu) ?>">
            <i class="fa-solid fa-masks-theater"></i>
            <span>Characters</span>
          </a>
        </li>
        <li>
          <a href="media.php" class="nav-item <?= is_active('media', $active_menu) ?>">
            <i class="fa-solid fa-photo-film"></i>
            <span>Media Center</span>
          </a>
        </li>
        <li>
          <a href="events.php" class="nav-item <?= is_active('events', $active_menu) ?>">
            <i class="fa-regular fa-calendar-days"></i>
            <span>Events</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- CATALOG -->
    <div class="nav-group">
      <p class="nav-group-label">Catalog</p>
      <ul class="nav-list">
        <li>
          <a href="merchandise.php" class="nav-item <?= is_active('merchandise', $active_menu) ?>">
            <i class="fa-solid fa-bag-shopping"></i>
            <span>Merchandise</span>
          </a>
        </li>
        <li>
          <a href="upcoming-releases.php" class="nav-item <?= is_active('releases', $active_menu) ?>">
            <i class="fa-solid fa-rocket"></i>
            <span>Upcoming Releases</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- COMMUNITY -->
    <div class="nav-group">
      <p class="nav-group-label">Community</p>
      <ul class="nav-list">
        <li>
          <a href="users.php" class="nav-item <?= is_active('users', $active_menu) ?>">
            <i class="fa-solid fa-users"></i>
            <span>Users</span>
          </a>
        </li>
        <li>
          <a href="fan-submissions.php" class="nav-item <?= is_active('submissions', $active_menu) ?>">
            <i class="fa-solid fa-inbox"></i>
            <span>Fan Submissions</span>
            <?php if (!empty($pending_submissions)): ?>
              <span class="nav-badge"><?= (int)$pending_submissions ?></span>
            <?php endif; ?>
          </a>
        </li>
        <li>
          <a href="feedback.php" class="nav-item <?= is_active('feedback', $active_menu) ?>">
            <i class="fa-regular fa-comment-dots"></i>
            <span>Feedback</span>
          </a>
        </li>
        <li>
          <a href="bookmarks.php" class="nav-item <?= is_active('bookmarks', $active_menu) ?>">
            <i class="fa-regular fa-bookmark"></i>
            <span>Bookmarks</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- SYSTEM -->
    <div class="nav-group">
      <p class="nav-group-label">System</p>
      <ul class="nav-list">
        <li>
          <a href="chatbot.php" class="nav-item <?= is_active('chatbot', $active_menu) ?>">
            <i class="fa-solid fa-robot"></i>
            <span>Chatbot FAQ</span>
          </a>
        </li>
        <li>
          <a href="settings.php" class="nav-item <?= is_active('settings', $active_menu) ?>">
            <i class="fa-solid fa-sliders"></i>
            <span>Settings</span>
          </a>
        </li>
      </ul>
    </div>

  </nav>

  <!-- Footer -->
  <div class="sidebar-foot">
    <div class="sidebar-user">
      <div class="avatar"><?= e($admin_initials) ?></div>
      <div class="user-meta">
        <span class="user-name"><?= e($admin_name) ?></span>
        <span class="user-role">Administrator</span>
      </div>
    </div>
  </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>