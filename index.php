<?php
$page_title = "Portfolio Dashboard";
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

// Calculate total portfolio value
$btcValue = $user['btc_balance'] * $btcPrice;
$ethValue = $user['eth_balance'] * $ethPrice;
$totalValue = $user['balance'] + $btcValue + $ethValue;

// Calculate average buy price and PnL for each coin
$btcAvgBuyPrice = calculateAverageBuyPrice($_SESSION['user_id'], 'BTC');
$ethAvgBuyPrice = calculateAverageBuyPrice($_SESSION['user_id'], 'ETH');
$btcPnL = calculatePnL($_SESSION['user_id'], 'BTC', $btcPrice);
$ethPnL = calculatePnL($_SESSION['user_id'], 'ETH', $ethPrice);

include 'includes/header.php';
?>

<h2>Welcome to Your Dashboard</h2>
<p>View your balances and monitor cryptocurrency prices in real-time.</p>

<div class="dashboard-grid">
    <div class="card">
        <h3 class="card-title">USDT Balance</h3>
        <div class="balance-value"><?php echo formatCrypto($user['balance'], 'USDT'); ?></div>
    </div>
    
    <div class="card">
        <h3 class="card-title">BTC Balance</h3>
        <div class="balance-value"><?php echo formatCrypto($user['btc_balance'], 'BTC'); ?></div>
        <div class="balance-converted">Value: <?php echo formatCrypto($btcValue, 'USDT'); ?></div>
        <div class="balance-converted">Avg. Buy Price: <?php echo formatCrypto($btcAvgBuyPrice, 'USDT'); ?></div>
        <div class="balance-converted">PnL: <?php echo formatCrypto($btcPnL, 'USDT'); ?></div>
    </div>
    
    <div class="card">
        <h3 class="card-title">ETH Balance</h3>
        <div class="balance-value"><?php echo formatCrypto($user['eth_balance'], 'ETH'); ?></div>
        <div class="balance-converted">Value: <?php echo formatCrypto($ethValue, 'USDT'); ?></div>
        <div class="balance-converted">Avg. Buy Price: <?php echo formatCrypto($ethAvgBuyPrice, 'USDT'); ?></div>
        <div class="balance-converted">PnL: <?php echo formatCrypto($ethPnL, 'USDT'); ?></div>
    </div>
    
    <div class="card">
        <h3 class="card-title">Total Portfolio</h3>
        <div class="balance-value"><?php echo formatCrypto($totalValue, 'USDT'); ?></div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
