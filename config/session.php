<?php
// Session management

/**
 * Start a secure session
 */
function startSession() {
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

// Automatically start session when this file is included
startSession();

/**
 * Check if user is logged in
 * 
 * @return bool True if user is logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Redirect to login page if user is not logged in
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * End user session (logout)
 */
function logout() {
    // Start the session if not already started
    startSession();
    
    // Unset all session variables
    $_SESSION = [];
    
    // Delete the session cookie
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    
    // Destroy the session
    session_destroy();
}
?>