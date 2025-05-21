<?php
// Main configuration file that includes all other configuration files

// Set default timezone
date_default_timezone_set('UTC');

// Include all configuration files
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/api.php';
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/formatting.php';

global $binance_api_url;


// Site settings
$site_name = 'Crypto Transaction Website';
$site_url = 'http://localhost/Web_programming_project_2025/';
$debug_mode = true; // Set to false in production

// Set error reporting based on debug mode
if ($debug_mode) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>