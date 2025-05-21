<?php
// Display formatting functions

// Format cryptocurrency amount for display
function formatCrypto($amount, $currency = 'USDT') {
    switch ($currency) {
        case 'BTC':
            return number_format($amount, 8) . ' BTC';
        case 'ETH':
            return number_format($amount, 8) . ' ETH';
        case 'USDT':
            return '$' . number_format($amount, 2);
        default:
            return number_format($amount, 2);
    }
}

// Format date and time for display
function formatDateTime($timestamp) {
    return date('Y-m-d H:i:s', strtotime($timestamp));
}
?>