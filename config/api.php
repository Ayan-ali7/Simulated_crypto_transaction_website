<?php
// Binance API settings 
$GLOBALS['binance_api_url'] = 'https://api.binance.com/api/v3/';

// Function to get cryptocurrency price
function getCryptoPrice($symbol) {
    $url = $GLOBALS['binance_api_url'] . 'ticker/price?symbol=' . $symbol;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        return false;
    }
    
    $data = json_decode($response, true);
    return isset($data['price']) ? (float)$data['price'] : false;
}

// Function to get Binance API URL (for use in other files)
function getBinanceApiUrl() {
    return $GLOBALS['binance_api_url'];
}
?>