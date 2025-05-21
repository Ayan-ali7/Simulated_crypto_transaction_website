<?php
$page_title = "Trading Chart";
define('WEBSITE_INITIALIZED', true);
require_once 'config/config.php';
require_once 'includes/functions.php';

startSession();
requireLogin();

// You might want to fetch some user data or other info here if needed
// $user = getUserInfo($_SESSION['user_id']);

include 'includes/header.php';
?>

<h2>Trading Chart</h2>
<p>Explore charts for various cryptocurrencies and assets.</p>

<!-- TradingView Widget BEGIN -->
<div class="tradingview-widget-container">
  <div id="tradingview_full_chart_widget"></div>
  <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
  <script type="text/javascript">
  new TradingView.widget(
  {
  "width": "100%", // Use percentage for responsiveness
  "height": 600, // Adjust height as needed
  "symbol": "BINANCE:BTCUSDT", // Default symbol to display
  "interval": "D",
  "timezone": "Etc/UTC",
  "theme": "light", // Or "dark"
  "style": "1",
  "locale": "en",
  "enable_publishing": false,
  "allow_symbol_change": true, // This is key to allow users to change symbols
  "container_id": "tradingview_full_chart_widget"
}
  );
  </script>
</div>
<!-- TradingView Widget END -->

<?php include 'includes/footer.php'; ?>
