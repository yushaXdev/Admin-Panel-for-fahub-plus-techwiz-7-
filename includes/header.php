<!-- Universal header — included by every admin page -->
<?php
if (!function_exists('e')) {
    require_once __DIR__ . '/functions.php';
}

if (!isset($page_title))  $page_title  = 'Admin';
if (!isset($active_menu)) $active_menu = '';

$admin_name = $_SESSION['admin_username'] ?? 'Admin';
$admin_initials = initials($admin_name);
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($page_title) ?> | Fan Hub Plus</title>

<link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<link rel="stylesheet" href="assets/css/admin-core.css">
<link rel="stylesheet" href="assets/css/admin-layout.css">
<link rel="stylesheet" href="assets/css/admin-components.css">
<link rel="stylesheet" href="assets/css/admin-sidebar.css">
<link rel="stylesheet" href="assets/css/admin-navbar.css">
<link rel="stylesheet" href="assets/css/admin-responsive.css">

<?php if (!empty($page_css)): ?>
  <link rel="stylesheet" href="assets/css/<?= e($page_css) ?>">
<?php endif; ?>
</head>
<body class="admin-body">

<div class="shell">

<?php include __DIR__ . '/sidebar.php'; ?>

<main class="main">

<?php include __DIR__ . '/navbar.php'; ?>

<div class="content">