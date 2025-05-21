<?php
// Database connection settings for PostgreSQL
$host = 'localhost';       // PostgreSQL server address
$port = '5432';            // PostgreSQL default port
$dbname = 'crypto_transaction'; // Your database name
$db_user = 'postgres';     // PostgreSQL username
$db_pass = 'alhanali123'; // PostgreSQL password

// Create global database connection
try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $db_user, $db_pass);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

/**
 * Get database connection
 * Returns the existing PDO connection
 * 
 * @return PDO Database connection object
 */
function getDbConnection() {
    global $conn;
    return $conn;
}
?>