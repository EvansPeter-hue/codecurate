<?php
// includes/header.php
// Requires $pdo + includes/auth.php to be loaded by the calling page.
$pageTitle  = $pageTitle  ?? 'Online Tutorials for Developers';
$activeSlug = $activeSlug ?? '';
$rootPath   = $rootPath   ?? '';

// Fetch all courses for nav (runs once per request)
$navCourses = $pdo->query("SELECT id, name, slug, fa_icon FROM courses ORDER BY sort_order")->fetchAll();

$currentUser = getCurrentUser();   // defined in includes/auth.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <link rel="stylesheet" href="<?= $cssPath ?? 'css/style.css' ?>"/>
</head>
<body>

<!-- ── NAVBAR ───────────────────────────────────────── -->
<nav>
  <a href="<?= $rootPath ?? '' ?>index.php" class="logo">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
      <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
    </svg>Learn<span>Code</span>
  </a>

  <div class="nav-links">
    <a href="<?= $rootPath ?? '' ?>index.php"             <?= $activeSlug === 'home'       ? 'class="active"' : '' ?>>Home</a>
    <a href="<?= $rootPath ?? '' ?>index.php#categories"  <?= $activeSlug === 'categories' ? 'class="active"' : '' ?>>Categories</a>
    <a href="<?= $rootPath ?? '' ?>index.php#trending"    <?= $activeSlug === 'trending'   ? 'class="active"' : '' ?>>Tutorials</a>
  </div>

  <div class="search-bar" id="searchTrigger" >
    <i class="fas fa-search"></i>
    <input type="text" placeholder="Search tutorials…" readonly/>
  </div>

  <div class="nav-actions">
    <?php if ($currentUser): ?>

      <!-- ── PROFILE DROPDOWN (hover) ── -->
      <div class="profile-wrap">

        <!-- Trigger: avatar circle + name + chevron -->
        <div class="profile-trigger">
          <div class="profile-avatar">
            <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
          </div>
          <span class="profile-trigger-name">
            <?= htmlspecialchars(explode(' ', $currentUser['name'])[0]) ?>
          </span>
          <i class="fas fa-chevron-down profile-chevron"></i>
        </div>

        <!-- Dropdown card -->
        <div class="profile-dropdown">

          <!-- Header -->
          <div class="pd-header">
            <div class="pd-avatar-lg">
              <?= strtoupper(substr($currentUser['name'], 0, 1)) ?>
            </div>
            <div class="pd-info">
              <div class="pd-name"><?= htmlspecialchars($currentUser['name']) ?></div>
              <div class="pd-email"><?= htmlspecialchars($currentUser['email'] ?? 'member@codecurate.com') ?></div>
              <span class="pd-badge"><i class="fas fa-circle-check"></i> Active Member</span>
            </div>
          </div>

          <div class="pd-divider"></div>

          <div class="pd-divider"></div>

          <!-- Logout -->
          <a href="<?= $rootPath ?? '' ?>logout.php" class="pd-logout">
            <i class="fas fa-arrow-right-from-bracket"></i>
            Log Out
          </a>

        </div><!-- /.profile-dropdown -->
      </div><!-- /.profile-wrap -->

    <?php else: ?>
      <a href="<?= $rootPath ?? '' ?>login.php"  class="btn-outline">Log In</a>
      <a href="<?= $rootPath ?? '' ?>signup.php" class="btn-primary">Sign Up</a>
    <?php endif; ?>
  </div>
</nav>

<!-- Search Overlay -->
<dialog class="search-overlay" id="searchOverlay" aria-label="Search">

</dialog>

<div class="toast" id="toast"><i class="fas fa-check-circle"></i><span id="toastMsg">Done!</span></div>

<script>
// ── Profile dropdown — click to open, click outside to close ──
(function () {
  const wrap = document.querySelector('.profile-wrap');
  if (!wrap) return;                          // not logged in — skip

  const trigger = wrap.querySelector('.profile-trigger');

  // Toggle on trigger click
  trigger.addEventListener('click', function (e) {
    e.stopPropagation();
    wrap.classList.toggle('open');
  });

  // Close when clicking anywhere outside the dropdown
  document.addEventListener('click', function (e) {
    if (!wrap.contains(e.target)) {
      wrap.classList.remove('open');
    }
  });

  // Close on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') wrap.classList.remove('open');
  });
})();
</script>
