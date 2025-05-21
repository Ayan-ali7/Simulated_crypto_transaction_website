<?php
$page_title = "Buy/Sell Crypto";
define('WEBSITE_INITIALIZED', true);
require_once 'config/config.php';
require_once 'includes/functions.php';

startSession();
requireLogin();

// Get user data
$user = getUserInfo($_SESSION['user_id']);

// Get current crypto prices
$btcPrice = getCryptoPrice('BTCUSDT');
$ethPrice = getCryptoPrice('ETHUSDT');

$error = '';
$success = '';

// Process buy/sell form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coin = sanitizeInput($_POST['coin'] ?? '');
    $type = sanitizeInput($_POST['type'] ?? '');
    $amount = floatval($_POST['amount'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $total = floatval($_POST['total'] ?? 0);
    
    // Validate inputs
    if (!in_array($coin, ['BTC', 'ETH'])) {
        $error = 'Invalid cryptocurrency selected.';
    } elseif (!in_array($type, ['buy', 'sell'])) {
        $error = 'Invalid transaction type.';
    } elseif ($amount <= 0) {
        $error = 'Amount must be greater than zero.';
    } elseif ($price <= 0) {
        $error = 'Price must be greater than zero.';
    } else {
        $db = getDbConnection();
        
        // Determine current price based on coin
        $currentPrice = $coin === 'BTC' ? $btcPrice : $ethPrice;
        
        // Re-calculate total to ensure it's correct
        $total = $amount * $currentPrice;
        
        // Process buy transaction
        if ($type === 'buy') {
            // Check if user has enough USDT
            if ($user['balance'] < $total) {
                $error = 'Insufficient USDT balance for this purchase.';
            } else {
                // Update balances: decrease USDT, increase crypto
                $newBalance = $user['balance'] - $total;
                $cryptoField = strtolower($coin) . '_balance';
                $newCryptoBalance = $user[$cryptoField] + $amount;
                
                // Start transaction
                $db->beginTransaction();
                
                try {
                    // Update user's USDT balance
                    updateUserBalance($_SESSION['user_id'], 'balance', $newBalance);
                    
                    // Update user's crypto balance
                    updateUserBalance($_SESSION['user_id'], $cryptoField, $newCryptoBalance);
                    
                    // Record the transaction
                    recordTransaction($_SESSION['user_id'], 'buy', $coin, $amount, $currentPrice, $total);
                    
                    // Commit transaction
                    $db->commit();
                    
                    $success = "Successfully purchased $amount $coin at $currentPrice USDT per coin.";
                    
                    // Refresh user data
                    $user = getUserInfo($_SESSION['user_id']);
                    
                } catch (Exception $e) {
                    // Roll back transaction on error
                    $db->rollBack();
                    $error = 'Transaction failed: ' . $e->getMessage();
                }
            }
        }
        // Process sell transaction
        else if ($type === 'sell') {
            $cryptoField = strtolower($coin) . '_balance';
            
            // Check if user has enough crypto
            if ($user[$cryptoField] < $amount) {
                $error = "Insufficient $coin balance for this sale.";
            } else {
                // Update balances: increase USDT, decrease crypto
                $newBalance = $user['balance'] + $total;
                $newCryptoBalance = $user[$cryptoField] - $amount;
                
                // Start transaction
                $db->beginTransaction();
                
                try {
                    // Update user's USDT balance
                    updateUserBalance($_SESSION['user_id'], 'balance', $newBalance);
                    
                    // Update user's crypto balance
                    updateUserBalance($_SESSION['user_id'], $cryptoField, $newCryptoBalance);
                    
                    // Record the transaction
                    recordTransaction($_SESSION['user_id'], 'sell', $coin, $amount, $currentPrice, $total);
                    
                    // Commit transaction
                    $db->commit();
                    
                    $success = "Successfully sold $amount $coin at $currentPrice USDT per coin.";
                    
                    // Refresh user data
                    $user = getUserInfo($_SESSION['user_id']);
                    
                } catch (Exception $e) {
                    // Roll back transaction on error
                    $db->rollBack();
                    $error = 'Transaction failed: ' . $e->getMessage();
                }
            }
        }
    }
}

include 'includes/header.php';
?>

<h2>Buy/Sell Cryptocurrency</h2>
<p>Current Balances: 
   USDT: <?php echo formatCrypto($user['balance'], 'USDT'); ?> | 
   BTC: <?php echo formatCrypto($user['btc_balance'], 'BTC'); ?> | 
   ETH: <?php echo formatCrypto($user['eth_balance'], 'ETH'); ?>
</p>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="form-card">
    <h3 class="form-title">Trade Cryptocurrency</h3>
    
    <form method="post" action="buy_sell.php">
        <div class="form-group">
            <label for="type">Transaction Type</label>
            <select id="type" name="type" required>
                <option value="buy">Buy</option>
                <option value="sell">Sell</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="coin">Cryptocurrency</label>
            <select id="coin" name="coin" required>
                <option value="BTC">Bitcoin (BTC)</option>
                <option value="ETH">Ethereum (ETH)</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="price">Current Price (USDT)</label>
            <input type="number" id="price" name="price" value="<?php echo $btcPrice; ?>" readonly>
        </div>
        
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" id="amount" name="amount" step="0.00000001" required>
            <small class="form-text">Enter the amount of cryptocurrency to buy/sell</small>
        </div>
        
        <div class="form-group">
            <label for="total">Total Cost (USDT)</label>
            <input type="number" id="total" name="total" readonly>
        </div>
        
        <button type="submit" class="btn btn-block">Execute Trade</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
