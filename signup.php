<?php
// signup.php
require_once 'config/db.php';
require_once 'includes/auth.php';

if (getCurrentUser()) {
    header('Location: index.php');
    exit;
}

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['firstName']       ?? '');
    $last_name  = trim($_POST['lastName']        ?? '');
    $email      = trim($_POST['email']           ?? '');
    $password   = $_POST['password']             ?? '';
    $confirm    = $_POST['confirmPassword']      ?? '';
    $terms      = $_POST['terms']                ?? '';

    // ── Validation ────────────────────────────────────────────
    if (!$first_name || !$last_name || !$email || !$password || !$confirm) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (!$terms) {
        $error = 'You must agree to the Terms of Service.';
    } else {
        // Check if email already exists
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $check->execute([$email]);
        if ($check->fetch()) {
            $error = 'An account with that email already exists. <a href="login.php">Log in?</a>';
        } else {
            // ✅ Insert new user
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $ins  = $pdo->prepare(
                "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)"
            );
            $ins->execute([$first_name, $last_name, $email, $hash]);

            // Store flash message for login page, then redirect after delay
            $_SESSION['flash_success'] = "Welcome, {$first_name}! Your account is ready. Please log in.";
            $success = "Account created successfully! Redirecting you to login…";
            header('refresh:1;url=login.php');
        }
    }
}

$page_title = 'Sign Up – CodeCurate';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?= $page_title ?></title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<link rel="stylesheet" href="css/style.css"/>
<style>
main{flex:1;display:flex;align-items:center;justify-content:center;padding:48px 20px;position:relative;overflow:hidden}
main::before{content:'';position:absolute;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(59,130,246,.12),transparent 70%);top:-100px;right:-100px;pointer-events:none}
main::after{content:'';position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(96,165,250,.08),transparent 70%);bottom:-80px;left:-80px;pointer-events:none}
.auth-card{background:var(--bg3);border:1px solid var(--border);border-radius:24px;padding:44px 48px;width:100%;max-width:480px;box-shadow:0 32px 80px rgba(0,0,0,.5);position:relative;z-index:1}
.auth-logo{display:flex;align-items:center;gap:8px;justify-content:center;font-family:'Syne',sans-serif;font-weight:800;font-size:1.3rem;color:var(--accent);margin-bottom:28px}
.auth-logo span{color:var(--text)}.auth-logo svg{width:24px;height:24px}
.auth-title{font-family:'Syne',sans-serif;font-weight:900;font-size:1.65rem;letter-spacing:-.02em;margin-bottom:6px;text-align:center}
.auth-sub{font-size:.88rem;color:var(--muted2);text-align:center;margin-bottom:32px}
.auth-sub a{color:var(--accent);font-weight:600}
.form-row2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:18px}
.form-label{font-size:.8rem;font-weight:700;color:var(--muted2);letter-spacing:.05em;text-transform:uppercase}
.input-wrap{position:relative;display:flex;align-items:center}
.input-wrap i.icon{position:absolute;left:14px;color:var(--muted);font-size:.85rem;pointer-events:none}
.form-input{width:100%;background:var(--bg2);border:1px solid var(--border);border-radius:10px;padding:11px 14px 11px 40px;font-family:inherit;font-size:.9rem;color:var(--text);outline:none;transition:border-color .2s,box-shadow .2s}
.form-input:focus{border-color:var(--accent);box-shadow:0 0 0 3px rgba(59,130,246,.15)}
.form-input::placeholder{color:var(--muted)}
.toggle-pw{position:absolute;right:14px;color:var(--muted);font-size:.85rem;cursor:pointer;background:none;border:none;padding:0;display:flex;align-items:center}
/* password strength */
.pw-strength{margin-top:6px}
.pw-bars{display:flex;gap:4px;margin-bottom:4px}
.pw-bar{flex:1;height:3px;border-radius:2px;background:var(--border);transition:background .3s}
.pw-bar.weak{background:#ef4444}.pw-bar.fair{background:#f59e0b}.pw-bar.good{background:#22c55e}
.pw-label{font-size:.72rem;color:var(--muted2)}
.terms-wrap{display:flex;align-items:flex-start;gap:10px;margin-bottom:24px;cursor:pointer}
.terms-wrap input{width:16px;height:16px;margin-top:2px;accent-color:var(--accent);flex-shrink:0}
.terms-wrap span{font-size:.83rem;color:var(--muted2);line-height:1.5}
.terms-wrap a{color:var(--accent);font-weight:600}
.btn-submit{width:100%;padding:13px;border-radius:12px;border:none;font-family:inherit;font-size:.97rem;font-weight:700;cursor:pointer;background:var(--accent);color:#fff;transition:all .25s;box-shadow:0 8px 24px rgba(59,130,246,.3);display:flex;align-items:center;justify-content:center;gap:10px}
.btn-submit:hover{background:var(--accent2);transform:translateY(-2px)}
.divider{display:flex;align-items:center;gap:12px;margin:24px 0;color:var(--muted);font-size:.78rem}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border)}
.social-btns{display:flex;gap:10px}
.btn-social{flex:1;padding:10px;border-radius:10px;border:1px solid var(--border);background:transparent;font-family:inherit;font-size:.83rem;font-weight:600;color:var(--muted2);cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px}
.btn-social:hover{border-color:var(--accent);color:var(--text)}
.alert{padding:10px 14px;border-radius:9px;font-size:.83rem;margin-bottom:18px;display:flex;align-items:center;gap:8px}
.alert.error{background:#2d1515;border:1px solid #7f1d1d;color:#fca5a5}
.alert.success{background:#14231a;border:1px solid #14532d;color:#86efac}
@media(max-width:500px){.auth-card{padding:32px 20px}.form-row2{grid-template-columns:1fr}}

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
<body style="display:flex;flex-direction:column;min-height:100vh">

<nav>
  <a href="index.php" class="logo">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
      <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
    </svg>Code<span>Curate</span>
  </a>
  <a href="index.php" style="font-size:.85rem;color:var(--muted2);margin-left:8px">
    <i class="fas fa-home"></i> Home
  </a>
  <div class="nav-actions" style="margin-left:auto;font-size:.85rem;color:var(--muted2)">
    Already have an account?
    <a href="login.php" style="color:var(--accent);font-weight:600;margin-left:4px">Log In</a>
  </div>
</nav>

<main>
  <div class="auth-card">
    <div class="auth-logo">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>
      </svg>Learn<span>Code</span>
    </div>

    <h1 class="auth-title">Create your account</h1>
    <p class="auth-sub">Already have one? <a href="login.php">Log in here</a></p>

    <?php if ($success): ?>
      <div class="alert success alert-big">
        <div class="alert-icon-wrap"><i class="fas fa-circle-check"></i></div>
        <div>
          <div class="alert-title">Account Created!</div>
          <div class="alert-msg"><?= htmlspecialchars($success) ?></div></div>
      </div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert error">
        <i class="fas fa-circle-exclamation"></i>
        <span><?= $error /* may contain a safe link */ ?></span>
      </div>
    <?php endif; ?>

    <form method="POST" action="signup.php" <?= $success ? 'style="display:none"' : '' ?>>
      <div class="form-row2">
        <div class="form-group">
          <label class="form-label" for="firstName">First Name</label>
          <div class="input-wrap">
            <i class="fas fa-user icon"></i>
            <input type="text" class="form-input" id="firstName" name="firstName"
                   placeholder="John" required
                   value="<?= htmlspecialchars($_POST['firstName'] ?? '') ?>"/>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label" for="lastName">Last Name</label>
          <div class="input-wrap">
            <i class="fas fa-user icon"></i>
            <input type="text" class="form-input" id="lastName" name="lastName"
                   placeholder="Doe" required
                   value="<?= htmlspecialchars($_POST['lastName'] ?? '') ?>"/>
          </div>
        </div>
      </div>

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
                 placeholder="Min. 8 characters" required
                 oninput="checkStrength(this.value)"/>
          <button type="button" class="toggle-pw" onclick="togglePw('password','pwEye')" aria-label="Toggle">
            <i class="fas fa-eye" id="pwEye"></i>
          </button>
        </div>
        <div class="pw-strength">
          <div class="pw-bars">
            <div class="pw-bar" id="b1"></div>
            <div class="pw-bar" id="b2"></div>
            <div class="pw-bar" id="b3"></div>
            <div class="pw-bar" id="b4"></div>
          </div>
          <span class="pw-label" id="pwLabel">Enter a password</span>
        </div>
      </div>

      <div class="form-group">
        <label class="form-label" for="confirmPassword">Confirm Password</label>
        <div class="input-wrap">
          <i class="fas fa-lock icon"></i>
          <input type="password" class="form-input" id="confirmPassword" name="confirmPassword"
                 placeholder="Repeat your password" required/>
          <button type="button" class="toggle-pw" onclick="togglePw('confirmPassword','cpwEye')" aria-label="Toggle">
            <i class="fas fa-eye" id="cpwEye"></i>
          </button>
        </div>
      </div>

      <label class="terms-wrap">
        <input type="checkbox" name="terms" id="terms" required/>
        <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
      </label>

      <button type="submit" class="btn-submit">
        Create Account <i class="fas fa-arrow-right"></i>
      </button>
    </form>

    <div class="divider">or continue with</div>
    <div class="social-btns">
      <button class="btn-social" onclick="alert('OAuth not configured — use email signup.')">
        <i class="fab fa-google" style="color:#ea4335"></i> Google
      </button>
      <button class="btn-social" onclick="alert('OAuth not configured — use email signup.')">
        <i class="fab fa-github"></i> GitHub
      </button>
    </div>
  </div>
</main>


<script>
function togglePw(fieldId, iconId){
  const i=document.getElementById(fieldId);
  const icon=document.getElementById(iconId);
  i.type=i.type==='password'?'text':'password';
  icon.classList.toggle('fa-eye');icon.classList.toggle('fa-eye-slash');
}

function checkStrength(pw){
  const bars=[document.getElementById('b1'),document.getElementById('b2'),
               document.getElementById('b3'),document.getElementById('b4')];
  const label=document.getElementById('pwLabel');
  bars.forEach(b=>b.className='pw-bar');
  if(!pw){label.textContent='Enter a password';return;}
  let score=0;
  if(pw.length>=8)score++;
  if(/[A-Z]/.test(pw))score++;
  if(/[0-9]/.test(pw))score++;
  if(/[^A-Za-z0-9]/.test(pw))score++;
  const cls=score<=1?'weak':score===2?'fair':'good';
  const labels=['','Weak','Fair','Good','Strong'];
  bars.slice(0,score).forEach(b=>b.classList.add(cls));
  label.textContent=labels[score]||'';
}
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
