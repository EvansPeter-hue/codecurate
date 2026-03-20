<?php
// config/db.php  — Database connection
// ────────────────────────────────────────
// Automatically uses Railway env variables in production,
// falls back to XAMPP settings for local development

define('DB_HOST', getenv('MYSQLHOST') ?: 'localhost');
define('DB_PORT', getenv('MYSQLPORT') ?: '3306');
define('DB_NAME', getenv('MYSQLDATABASE') ?: 'codecurate');
define('DB_USER', getenv('MYSQLUSER') ?: 'root');
define('DB_PASS', getenv('MYSQLPASSWORD') ?: '');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE,            PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,   false);
} catch (PDOException $e) {
    // Show a friendly error instead of leaking credentials
    die('
    <div style="font-family:sans-serif;max-width:540px;margin:80px auto;
                background:#1a2236;border:1px solid #ef4444;border-radius:12px;padding:28px;color:#fca5a5;">
      <h2 style="margin:0 0 10px;color:#ef4444;">Database Connection Failed</h2>
      <p style="margin:0 0 14px;">Could not connect to MySQL. Please check your <code>config/db.php</code> settings.</p>
      <code style="font-size:.8rem;color:#94a3b8;">' . htmlspecialchars($e->getMessage()) . '</code>
    </div>');
}