<?php
session_start();

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: admin.php');
    exit;
}

$error = '';
$old_username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Please enter username and password.';
        $old_username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    } else {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username']  = $username;
        header('Location: admin.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>lOGIN | ADMIN PANEL</title>

<link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet" href="assets/css/admin-login.css">
</head>
<body class="login-body">

<main class="login-shell">

  <!-- LEFT: brand -->
  <section class="brand-panel" aria-hidden="true">
    <a class="brand-mark" href="admin-login.php">
      <span class="brand-glyph"><i class="fa-solid fa-bolt"></i></span>
      <span class="brand-name">Fan Hub <em>Plus</em></span>
    </a>

    <div class="brand-hero">
      <h1 class="brand-headline">
        Every fandom.<br>
        <span class="gradient-text">One control room.</span>
      </h1>
      <p class="brand-sub">Curate, moderate, and publish across 8 universes.</p>
    </div>

    <footer class="brand-foot">
      <span>© <?= date('Y') ?> Fan Hub Plus</span>
      <span class="mono">v1.0</span>
    </footer>
  </section>

  <!-- RIGHT: form -->
  <section class="form-panel">
    <div class="form-inner">

      <header class="form-head">
        <h2>Sign in</h2>
        <p>Welcome back. Enter your credentials.</p>
      </header>

      <?php if ($error): ?>
        <div class="alert alert-error" role="alert">
          <i class="fa-solid fa-circle-exclamation"></i>
          <span><?= htmlspecialchars($error) ?></span>
        </div>
      <?php endif; ?>

      <form method="POST" action="admin-login.php" class="login-form" novalidate>

        <div class="field">
          <label for="username">Username</label>
          <div class="input-wrap">
            <i class="fa-regular fa-user input-icon"></i>
            <input type="text"
                   id="username"
                   name="username"
                   placeholder="admin@fanhubplus.com"
                   value="<?= $old_username ?? '' ?>"
                   autocomplete="username"
                   autofocus
                   required>
          </div>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <div class="input-wrap">
            <i class="fa-solid fa-lock input-icon"></i>
            <input type="password"
                   id="password"
                   name="password"
                   placeholder="Enter your password"
                   autocomplete="current-password"
                   required>
            <button type="button" class="pw-toggle" data-target="password" aria-label="Show password">
              <i class="fa-regular fa-eye"></i>
            </button>
          </div>
        </div>

        <label class="check">
          <input type="checkbox" name="remember" checked>
          <span class="check-box" aria-hidden="true">
            <i class="fa-solid fa-check"></i>
          </span>
          <span>Keep me signed in</span>
        </label>

        <button type="submit" class="btn-primary" id="submitBtn">
          <span class="btn-label">
            Sign in
            <i class="fa-solid fa-arrow-right"></i>
          </span>
          <span class="btn-spinner" aria-hidden="true"></span>
        </button>

      </form>

      <footer class="form-foot">
        <i class="fa-solid fa-circle-info"></i>
        <span>Demo build — any credentials work.</span>
      </footer>

    </div>
  </section>

</main>

<script src="assets/js/admin-login.js"></script>
</body>
</html>