<?php
// Start session if not already started
if (!defined('WEBSITE_INITIALIZED')) {
    require_once 'config/config.php';
}
startSession();

// Get crypto prices for the header
$btcPrice = getCryptoPrice('BTCUSDT');
$ethPrice = getCryptoPrice('ETHUSDT');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? $site_name; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1 class="site-logo"><?php echo $site_name; ?></h1>
            <?php if (isLoggedIn()): ?>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="chart.php">Charts</a></li>
                    <li><a href="buy_sell.php">Buy/Sell</a></li>
                    <li><a href="transactions.php">Transactions</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
            <div class="live-prices">
                <span class="price btc-price">BTC: $<?php echo number_format($btcPrice, 2); ?></span>
                <span class="price eth-price">ETH: $<?php echo number_format($ethPrice, 2); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </header>
    <main class="container">
