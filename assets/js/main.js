/**
 * Main JavaScript file for Crypto Transaction Website
 */


function updatePrices() {
    fetch('get_prices.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector('.btc-price').textContent = `BTC: $${parseFloat(data.btc).toFixed(2)}`;
                document.querySelector('.eth-price').textContent = `ETH: $${parseFloat(data.eth).toFixed(2)}`;
            }
        })
        .catch(error => console.error('Error fetching prices:', error));
}

// Calculate total for buy/sell form
function calculateTotal() {
    const amountField = document.getElementById('amount');
    const priceField = document.getElementById('price');
    const totalField = document.getElementById('total');
    
    if (amountField && priceField && totalField) {
        const amount = parseFloat(amountField.value) || 0;
        const price = parseFloat(priceField.value) || 0;
        const total = amount * price;
        
        totalField.value = total.toFixed(2);
    }
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    // Set up interval for price updates
    updatePrices();
    setInterval(updatePrices, 10000); // Update every 10 seconds

    
    // Set up event listeners for buy/sell form
    const amountField = document.getElementById('amount');
    const priceField = document.getElementById('price');
    const coinSelect = document.getElementById('coin');
    
    if (amountField && priceField) {
        amountField.addEventListener('input', calculateTotal);
        priceField.addEventListener('input', calculateTotal);
    }
    
    if (coinSelect) {
        coinSelect.addEventListener('change', function() {
            fetch(`get_coin_price.php?coin=${this.value}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && priceField) {
                        priceField.value = data.price;
                        calculateTotal();
                    }
                })
                .catch(error => console.error('Error fetching coin price:', error));
        });
    }
});
