<?php
/**
 * Website Settings
 * 
 * General settings for the crypto transaction website
 */

// Prevent direct access to this file
if (!defined('WEBSITE_INITIALIZED')) {
    die('Direct access to this file is not allowed.');
}

$debug_mode = true;  // Set to false in production

// Define debug mode as constant for use in other files
define('DEBUG_MODE', $debug_mode);

// Set error reporting based on debug mode
if ($debug_mode) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}
?>
