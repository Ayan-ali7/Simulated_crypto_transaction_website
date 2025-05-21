<?php
/**
 * Additional helper functions for the crypto website
 */

// Prevent direct access to this file
if (!defined('WEBSITE_INITIALIZED')) {
    die('Direct access to this file is not allowed.');
}

/**
 * Sanitize input data
 *
 * @param string $data Data to sanitize
 * @return string Sanitized data
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Get user information from database
 *
 * @param int $user_id User ID
 * @return array|false User data or false if not found
 */
function getUserInfo($user_id) {
    $db = getDbConnection();
    $stmt = $db->prepare("SELECT id, email, balance, btc_balance, eth_balance FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    return $stmt->fetch();
}

/**
 * Update user's balance after a transaction
 *
 * @param int $user_id User ID
 * @param string $currency Currency to update (balance, btc_balance, eth_balance)
 * @param float $amount New balance amount
 * @return bool True on success, false on failure
 */
function updateUserBalance($user_id, $currency, $amount) {
    $db = getDbConnection();
    $valid_currencies = ['balance', 'btc_balance', 'eth_balance'];
    
    if (!in_array($currency, $valid_currencies)) {
        return false;
    }
    
    $sql = "UPDATE users SET $currency = ? WHERE id = ?";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$amount, $user_id]);
}

/**
 * Record a transaction in the database
 *
 * @param int $user_id User ID
 * @param string $type Transaction type ('buy' or 'sell')
 * @param string $coin Cryptocurrency ('BTC' or 'ETH')
 * @param float $amount Amount of crypto
 * @param float $price Price at time of transaction
 * @param float $total Total value in USDT
 * @return bool True on success, false on failure
 */
function recordTransaction($user_id, $type, $coin, $amount, $price, $total) {
    $db = getDbConnection();
    $sql = "INSERT INTO transactions (user_id, type, coin, amount, price, total) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$user_id, $type, $coin, $amount, $price, $total]);
}

/**
 * Calculate the average buy price for a specific coin
 *
 * @param int $user_id User ID
 * @param string $coin Cryptocurrency ('BTC' or 'ETH')
 * @return float Average buy price
 */
function calculateAverageBuyPrice($user_id, $coin) {
    $db = getDbConnection();
    $stmt = $db->prepare("
        SELECT AVG(price) as avg_price 
        FROM transactions 
        WHERE user_id = ? AND coin = ? AND type = 'buy'
    ");
    $stmt->execute([$user_id, $coin]);
    $result = $stmt->fetch();
    return $result['avg_price'] ?? 0;
}

/**
 * Calculate the profit/loss for a specific coin
 *
 * @param int $user_id User ID
 * @param string $coin Cryptocurrency ('BTC' or 'ETH')
 * @param float $currentPrice Current price of the coin
 * @return float Profit/Loss
 */
function calculatePnL($user_id, $coin, $currentPrice) {
    $db = getDbConnection();
    $stmt = $db->prepare("
        SELECT SUM(CASE WHEN type = 'buy' THEN amount ELSE -amount END) as total_amount,
               SUM(CASE WHEN type = 'buy' THEN total ELSE -total END) as total_spent
        FROM transactions 
        WHERE user_id = ? AND coin = ?
    ");
    $stmt->execute([$user_id, $coin]);
    $result = $stmt->fetch();
    $totalAmount = $result['total_amount'] ?? 0;
    $totalSpent = $result['total_spent'] ?? 0;
    $currentValue = $totalAmount * $currentPrice;
    return $currentValue - $totalSpent;
}
?>
