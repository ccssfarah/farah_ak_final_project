<?php
// Start or resume session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is already authenticated
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    // Already logged in -> redirect to main dashboard
    header("Location: dashboard.php");
    exit;
} else {
    // Not logged in -> redirect to login page
    header("Location: login.php");
    exit;
}
?>