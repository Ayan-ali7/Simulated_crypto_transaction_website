<?php
define('WEBSITE_INITIALIZED', true);
require_once 'config/config.php';

startSession();

// Perform logout
logout();

// Redirect to login page
header('Location: login.php');
exit;
?>
