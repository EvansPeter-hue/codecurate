<?php
// logout.php
require_once 'config/db.php';
require_once 'includes/auth.php';

logoutUser();   // fully clears session via auth helper

// Redirect to login after 2 seconds via meta refresh
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<meta http-equiv="refresh" content="2;url=index.php"/>
<title>Logging Out – CodeCurate</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<link rel="stylesheet" href="css/style.css"/>
<style>
body{display:flex;align-items:center;justify-content:center;min-height:100vh;background:var(--bg)}
.logout-card{background:var(--bg3);border:1px solid var(--border);border-radius:24px;padding:56px 52px;max-width:420px;width:90%;text-align:center;box-shadow:0 32px 80px rgba(0,0,0,.5)}
.done-icon{width:72px;height:72px;border-radius:50%;background:rgba(34,197,94,.12);border:1px solid rgba(34,197,94,.25);display:flex;align-items:center;justify-content:center;margin:0 auto 24px}
.done-icon i{font-size:1.6rem;color:var(--green)}
.logout-title{font-family:'Syne',sans-serif;font-weight:900;font-size:1.6rem;letter-spacing:-.02em;margin-bottom:8px}
.logout-sub{font-size:.9rem;color:var(--muted2);line-height:1.6;margin-bottom:28px}
.progress-wrap{background:var(--bg2);border-radius:99px;height:4px;overflow:hidden;margin-bottom:24px}
.progress-bar{height:100%;background:linear-gradient(90deg,var(--accent),var(--accent2));border-radius:99px;animation:fill 2s linear forwards}
@keyframes fill{from{width:0}to{width:100%}}
.btn-link{display:inline-block;padding:10px 24px;border-radius:10px;background:var(--accent);color:#fff;font-family:inherit;font-weight:700;font-size:.9rem;transition:all .2s}
.btn-link:hover{background:var(--accent2);transform:translateY(-2px)}
.logo-link{display:inline-flex;align-items:center;gap:8px;font-family:'Syne',sans-serif;font-weight:800;font-size:1.1rem;color:var(--accent);margin-bottom:28px}
.logo-link span{color:var(--text)}
.logo-link svg{width:20px;height:20px}
</style>
</head>
<body>
<div class="logout-card">
  <a href="index.php" class="logo-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
      <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
    </svg>Code<span>Curate</span>
  </a>
  <div class="done-icon"><i class="fas fa-check"></i></div>
  <h1 class="logout-title">You're logged out</h1>
  <p class="logout-sub">Your session has been cleared. Redirecting you to the homepage…</p>
  <div class="progress-wrap"><div class="progress-bar"></div></div>
  <a href="index.php" class="btn-link">Go to Homepage</a>
</div>
</body>
</html>
