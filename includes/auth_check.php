<?php

session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /auth/login.php');
    exit;
}

// Define allowed roles for the page (pass as array)
// Example usage: define('ALLOWED_ROLES', ['admin', 'manager']);
if (!defined('ALLOWED_ROLES')) {
    // If no roles defined for the page, allow all logged-in users
    return;
}

// Check user role against allowed roles
if (!in_array($_SESSION['user_role'], ALLOWED_ROLES)) {
    // Role not authorized
    http_response_code(403);
    echo '<div class="container mt-5">';
    echo '<h3 class="text-danger">403 Forbidden - You do not have permission to access this page.</h3>';
    echo '<a href="/dashboard/index.php" class="btn btn-primary mt-3">Back to Dashboard</a>';
    echo '</div>';
    exit;
}
