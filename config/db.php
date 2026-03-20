<?php
$host = getenv('MYSQLHOST') ?: 'localhost';
$port = getenv('MYSQLPORT') ?: '3306';
$db   = getenv('MYSQLDATABASE') ?: 'codecurate';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: '';

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
         PDO::ATTR_EMULATE_PREPARES => false]
    );
} catch (PDOException $e) {
    die('
    <div style="font-family:sans-serif;max-width:540px;margin:80px auto;
                background:#1a2236;border:1px solid #ef4444;border-radius:12px;padding:28px;color:#fca5a5;">
      <h2 style="margin:0 0 10px;color:#ef4444;">Database Connection Failed</h2>
      <p style="margin:0 0 14px;">Could not connect to MySQL. Please check your <code>config/db.php</code> settings.</p>
      <code style="font-size:.8rem;color:#94a3b8;">' . htmlspecialchars($e->getMessage()) . '</code>
    </div>');
}