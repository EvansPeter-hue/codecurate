<?php
// includes/auth.php
// ─────────────────────────────────────────────────────────────
// Central auth helper. Include this ONCE per page (after db.php).
// Stores the logged-in user as $_SESSION['cc_user'] array.
// ─────────────────────────────────────────────────────────────

if (session_status() === PHP_SESSION_NONE) session_start();

/**
 * Returns the current logged-in user array, or null if not logged in.
 * Array keys: id, name, email, first_name, last_name
 */
function getCurrentUser(): ?array {
    return $_SESSION['cc_user'] ?? null;
}

/**
 * Log a user in — call after verifying password.
 */
function loginUser(array $dbRow): void {
    $_SESSION['cc_user'] = [
        'id'         => $dbRow['id'],
        'first_name' => $dbRow['first_name'],
        'last_name'  => $dbRow['last_name'],
        'name'       => $dbRow['first_name'] . ' ' . $dbRow['last_name'],
        'email'      => $dbRow['email'],
    ];
}

/**
 * Destroy the session completely.
 */
function logoutUser(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

/**
 * Redirect to login if not authenticated.
 */
function requireLogin(string $redirectTo = 'login.php'): void {
    if (!getCurrentUser()) {
        header("Location: $redirectTo");
        exit;
    }
}
