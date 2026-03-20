<?php
// login.php
require_once 'config/db.php';
require_once 'includes/auth.php';

// Already logged in → redirect home
if (getCurrentUser()) {
    header('Location: index.php');
    exit;
}

$error   = '';
$success = '';

// Pick up flash message set by signup page
if (!empty($_SESSION['flash_success'])) {
    $success = $_SESSION['flash_success'];
    unset($_SESSION['flash_success']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = $_POST['password']      ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            loginUser($user);   // stores full profile in session via auth.php
            $success = "Login successful! Welcome back, {$user['first_name']}. Redirecting…";
            header('refresh:3;url=index.php');
        } else {
            $error = 'Invalid email or password. Please try again.';
        }
    }
}

$pageTitle = 'Log In – CodeCurate';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?= $pageTitle ?></title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<link rel="stylesheet" href="css/style.css"/>
<style>
/* Auth-page specific overrides */
body{display:flex;flex-direction:column;min-height:100vh}
main{flex:1;display:flex;align-items:center;justify-content:center;padding:48px 20px;position:relative;overflow:hidden}
main::before{content:'';position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(59,130,246,.12),transparent 70%);top:-100px;left:-100px;pointer-events:none}
main::after{content:'';position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(96,165,250,.08),transparent 70%);bottom:-80px;right:-80px;pointer-events:none}
.auth-card{background:var(--bg3);border:1px solid var(--border);border-radius:24px;padding:44px 48px;width:100%;max-width:440px;box-shadow:0 32px 80px rgba(0,0,0,.5);position:relative;z-index:1}
.auth-logo{display:flex;align-items:center;gap:8px;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:1.3rem;color:var(--accent);margin-bottom:28px}
.auth-logo span{color:var(--text)}
.auth-logo svg{width:24px;height:24px}
.auth-title{font-family:'Syne',sans-serif;font-weight:900;font-size:1.65rem;letter-spacing:-.02em;margin-bottom:6px;text-align:center}
.auth-sub{font-size:.88rem;color:var(--muted2);text-align:center;margin-bottom:32px}
.auth-sub a{color:var(--accent);font-weight:600;transition:color .2s}
.auth-sub a:hover{color:var(--accent2)}
.form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:18px}
.form-label{font-size:.8rem;font-weight:700;color:var(--muted2);letter-spacing:.05em;text-transform:uppercase}
.input-wrap{position:relative;display:flex;align-items:center}
.input-wrap i.icon{position:absolute;left:14px;color:var(--muted);font-size:.85rem;pointer-events:none}
.form-input{width:100%;background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:11px 14px 11px 40px;font-family:inherit;font-size:.9rem;color:var(--text);outline:none;transition:border-color .2s,box-shadow .2s}
.form-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(59,130,246,.15)}
.form-input::placeholder{color:var(--muted)}
.toggle-pw{position:absolute;right:14px;color:var(--muted);font-size:.85rem;cursor:pointer;transition:color .2s;background:none;border:none;padding:0;line-height:1;display:flex;align-items:center}
.toggle-pw:hover{color:var(--text)}
.form-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px}
.checkbox-wrap{display:flex;align-items:center;gap:8px;cursor:pointer}
.checkbox-wrap input{width:16px;height:16px;accent-color:var(--accent);cursor:pointer}
.checkbox-wrap span{font-size:.83rem;color:var(--muted2)}
.forgot-link{font-size:.83rem;color:var(--accent);font-weight:600;transition:color .2s}
.forgot-link:hover{color:var(--accent2)}
.btn-submit{width:100%;padding:13px;border-radius:12px;border:none;font-family:inherit;font-size:.97rem;font-weight:700;cursor:pointer;background:var(--accent);color:#fff;transition:all .25s;box-shadow:0 8px 24px rgba(59,130,246,.3);display:flex;align-items:center;justify-content:center;gap:10px}
.btn-submit:hover{background:var(--accent2);transform:translateY(-2px)}
.divider{display:flex;align-items:center;gap:12px;margin:24px 0;color:var(--muted);font-size:.78rem}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}
.alert{padding:10px 14px;border-radius:9px;font-size:.83rem;margin-bottom:18px;display:flex;align-items:center;gap:8px}
.alert.error{background:#2a1e2e;border:1px solid rgba(239,68,68,.3);color:#ffd5d5}
.alert.success{background:#1a2a28;border:1px solid rgba(34,197,94,.3);color:#c8ffd8}
@media(max-width:500px){.auth-card{padding:32px 24px}}

/* ── Success alert (big) ── */
.alert-big{
  padding:18px 16px;border-radius:14px;margin-bottom:22px;
  display:flex;align-items:flex-start;gap:14px;
  background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.3);color:#c8ffd8;
  animation:alertIn .4s cubic-bezier(.34,1.56,.64,1);
}
@keyframes alertIn{from{opacity:0;transform:translateY(-10px) scale(.97)}to{opacity:1;transform:none}}
.alert-icon-wrap{
  width:38px;height:38px;border-radius:50%;flex-shrink:0;
  background:rgba(34,197,94,.15);display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;color:#22c55e;
}
.alert-title{font-family:'Syne',sans-serif;font-weight:800;font-size:.95rem;color:#4ade80;margin-bottom:3px}
.alert-msg{font-size:.82rem;color:#86efac;line-height:1.5;margin-bottom:8px}

to{width:100%}

</style>
</head>
<body>

<!-- Minimal nav for auth pages -->
<nav>
  <a href="index.php" class="logo">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
      <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
    </svg>Code<span>Curate</span>
  </a>
  <a href="index.php" class="nav-links" style="margin-left:12px;font-size:.875rem;color:var(--muted2);padding:6px 14px;border-radius:8px;">
    ← Home
  </a>
  <div class="nav-actions" style="margin-left:auto;">
    <span style="font-size:.85rem;color:var(--muted2)">Don't have an account?</span>
    <a href="signup.php" class="btn-primary">Sign Up</a>
  </div>
</nav>

<main>
  <div class="auth-card">
    <div class="auth-logo">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
      </svg>Learn<span>Code</span>
    </div>

    <h1 class="auth-title">Welcome back</h1>
    <p class="auth-sub">New here? <a href="signup.php">Create a free account</a></p>

    <?php if ($success): ?>
      <div class="alert success alert-big">
        <div class="alert-icon-wrap"><i class="fas fa-circle-check"></i></div>
        <div>
          <div class="alert-title"><?= strpos($success, 'Welcome back') !== false ? 'Login Successful!' : 'Welcome to CodeCurate!' ?></div>
          <div class="alert-msg"><?= htmlspecialchars($success) ?></div></div>
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert error"><i class="fas fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" <?= $success ? 'style="display:none"' : '' ?>>
      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <div class="input-wrap">
          <i class="fas fa-envelope icon"></i>
          <input type="email" class="form-input" id="email" name="email"
                 placeholder="you@example.com" required
                 value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"/>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock icon"></i>
          <input type="password" class="form-input" id="password" name="password"
                 placeholder="Enter your password" required/>
          <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="Toggle password">
            <i class="fas fa-eye" id="pwIcon"></i>
          </button>
        </div>
      </div>

      <div class="form-row">
        <label class="checkbox-wrap">
          <input type="checkbox" name="remember"/>
          <span>Remember me</span>
        </label>
        <a href="#" class="forgot-link">Forgot password?</a>
      </div>

      <button type="submit" class="btn-submit">
        Log In <i class="fas fa-arrow-right"></i>
      </button>
    </form>

    <div class="divider">or continue with</div>
    <div style="display:flex;gap:10px">
      <button class="btn-submit" style="flex:1;background:transparent;border:1px solid var(--border);color:var(--muted2);box-shadow:none;" type="button">
        <i class="fab fa-google" style="color:#ea4335"></i> Google
      </button>
      <button class="btn-submit" style="flex:1;background:transparent;border:1px solid var(--border);color:var(--muted2);box-shadow:none;" type="button">
        <i class="fab fa-github"></i> GitHub
      </button>
    </div>
  </div>
</main>

<?php
// Minimal footer for auth pages
$rootPath = '';
include 'includes/footer.php';
?>

<script>
function togglePw() {
  const pw   = document.getElementById('password');
  const icon = document.getElementById('pwIcon');
  if (pw.type === 'password') { pw.type = 'text'; icon.classList.replace('fa-eye','fa-eye-slash'); }
  else                        { pw.type = 'password'; icon.classList.replace('fa-eye-slash','fa-eye'); }
}
</script>
</body>
</html>
