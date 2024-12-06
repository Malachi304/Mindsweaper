<?php
session_start(); // Start or resume the session

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Clear the PHPSESSID cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000, // Expire in the past
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Return a JSON response
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>
