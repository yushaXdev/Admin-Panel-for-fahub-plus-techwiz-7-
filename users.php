<?php
session_start();
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit;
}

$page_title  = "Users";
$active_menu = "users";
$page_css    = "page-users.css";
$page_js     = "page-users.js";

include __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

// demo data — Laravel: User::paginate(15)
$users = [
    ['id' => 1, 'name' => 'Mika Asa',     'email' => 'mika@fanhub.com',      'role' => 'user',   'status' => 'active',   'joined' => '2024-11-03'],
    ['id' => 2, 'name' => 'Tarnished 01', 'email' => 'tarnished@fanhub.com', 'role' => 'user',   'status' => 'active',   'joined' => '2024-11-12'],
    ['id' => 3, 'name' => 'ARMY Forever', 'email' => 'army@fanhub.com',      'role' => 'editor', 'status' => 'active',   'joined' => '2025-01-20'],
    ['id' => 4, 'name' => 'Chloe Arts',   'email' => 'chloe@fanhub.com',     'role' => 'user',   'status' => 'active',   'joined' => '2025-02-14'],
    ['id' => 5, 'name' => 'Otaku Sensei', 'email' => 'otaku@fanhub.com',     'role' => 'user',   'status' => 'banned',   'joined' => '2025-03-01'],
    ['id' => 6, 'name' => 'Nova Star',    'email' => 'nova@fanhub.com',      'role' => 'editor', 'status' => 'active',   'joined' => '2025-04-11'],
    ['id' => 7, 'name' => 'Pixel Wizard', 'email' => 'pixel@fanhub.com',     'role' => 'user',   'status' => 'inactive', 'joined' => '2025-05-02'],
    ['id' => 8, 'name' => 'Riko Tanaka',  'email' => 'riko@fanhub.com',      'role' => 'admin',  'status' => 'active',   'joined' => '2024-09-15'],
];
?>

<nav class="crumbs" aria-label="Breadcrumb">
  <a href="admin.php">Home</a>
  <i class="fa-solid fa-chevron-right"></i>
  <span>Users</span>
</nav>

<div class="page-header">
  <div>
    <h2 class="page-title">Users</h2>
    <p class="page-sub">Manage registered users and their permissions.</p>
  </div>
  <button class="btn btn-primary" id="addUserBtn">
    <i class="fa-solid fa-user-plus"></i>
    <span>Add User</span>
  </button>
</div>

<div class="filters-bar">
  <div class="filter-search">
    <i class="fa-solid fa-magnifying-glass"></i>
    <input type="search" id="userSearch" placeholder="Search by name or email...">
  </div>
  <select class="input filter-select" id="roleFilter">
    <option value="">All roles</option>
    <option value="user">User</option>
    <option value="editor">Editor</option>
    <option value="admin">Admin</option>
  </select>
  <select class="input filter-select" id="statusFilter">
    <option value="">All status</option>
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
    <option value="banned">Banned</option>
  </select>
</div>

<div class="panel">
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>User</th>
          <th>Role</th>
          <th>Status</th>
          <th>Joined</th>
          <th></th>
        </tr>
      </thead>
      <tbody id="usersTableBody">
        <?php foreach ($users as $u): ?>
          <tr data-name="<?= e(strtolower($u['name'])) ?>"
              data-email="<?= e(strtolower($u['email'])) ?>"
              data-role="<?= e($u['role']) ?>"
              data-status="<?= e($u['status']) ?>">
            <td>
              <a href="user-details.php?id=<?= (int)$u['id'] ?>" class="user-cell">
                <span class="avatar avatar-sm"><?= e(initials($u['name'])) ?></span>
                <span class="user-meta">
                  <strong><?= e($u['name']) ?></strong>
                  <span class="user-email"><?= e($u['email']) ?></span>
                </span>
              </a>
            </td>
            <td><span class="role-pill role-<?= e($u['role']) ?>"><?= e(ucfirst($u['role'])) ?></span></td>
            <td><?= status_badge($u['status']) ?></td>
            <td><span class="date-txt"><?= nice_date($u['joined']) ?></span></td>
            <td class="row-actions">
              <a href="user-details.php?id=<?= (int)$u['id'] ?>" class="icon-btn" aria-label="View">
                <i class="fa-regular fa-eye"></i>
              </a>
              <button class="icon-btn danger" data-confirm="Delete this user?" aria-label="Delete">
                <i class="fa-regular fa-trash-can"></i>
              </button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="empty hide" id="noResults">
    <i class="fa-regular fa-face-frown"></i>
    <p>No users match your filters.</p>
  </div>

  <div class="pagination">
    <span class="page-info">Showing <strong>1–8</strong> of <strong>12,480</strong></span>
    <div class="page-controls">
      <button class="page-btn" disabled><i class="fa-solid fa-chevron-left"></i></button>
      <button class="page-btn is-active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
  </div>
</div>

<!-- add user modal -->
<div class="modal" id="userModal" aria-hidden="true">
  <div class="modal-overlay" data-close></div>
  <div class="modal-panel">
    <header class="modal-head">
      <h3>Add User</h3>
      <button class="icon-btn" data-close aria-label="Close">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </header>
    <div class="modal-body">
      <form id="userForm" class="form-grid" autocomplete="off">
        <div class="field">
          <label for="userName">Full name</label>
          <input class="input" id="userName" name="name" type="text" required>
        </div>
        <div class="field">
          <label for="userEmail">Email</label>
          <input class="input" id="userEmail" name="email" type="email" required>
        </div>
        <div class="field">
          <label for="userRole">Role</label>
          <select class="input" id="userRole" name="role" required>
            <option value="user">User</option>
            <option value="editor">Editor</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="field">
          <label for="userPassword">Temporary password</label>
          <input class="input" id="userPassword" name="password" type="text" required>
        </div>
      </form>
    </div>
    <footer class="modal-foot">
      <button class="btn btn-ghost" data-close>Cancel</button>
      <button class="btn btn-primary" id="saveUser" type="button">
        <i class="fa-solid fa-check"></i>
        <span>Create User</span>
      </button>
    </footer>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>