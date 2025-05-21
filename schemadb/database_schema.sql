-- Database Schema for Crypto Transaction Website

-- Users Table
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    balance DECIMAL(16, 8) DEFAULT 1000.00, -- Default USDT balance
    btc_balance DECIMAL(16, 8) DEFAULT 0,
    eth_balance DECIMAL(16, 8) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP
);

-- Transactions Table
CREATE TABLE transactions (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id),
    type VARCHAR(10) NOT NULL CHECK (type IN ('buy', 'sell')),
    coin VARCHAR(10) NOT NULL CHECK (coin IN ('BTC', 'ETH')),
    amount DECIMAL(16, 8) NOT NULL,
    price DECIMAL(16, 8) NOT NULL,
    total DECIMAL(16, 8) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create index for faster queries
CREATE INDEX idx_transactions_user_id ON transactions(user_id);
CREATE INDEX idx_users_email ON users(email);

-- Optional: Create a view for user balances with current value
CREATE VIEW user_portfolio AS
SELECT 
    u.id,
    u.email,
    u.balance AS usdt_balance,
    u.btc_balance,
    u.eth_balance
FROM 
    users u;

-- Optional: Sample data for testing (uncomment if needed)
-- INSERT INTO users (email, password_hash) VALUES 
-- ('test@example.com', '$2y$10$abcdefghijklmnopqrstuv'), -- Replace with actual password hash
-- ('demo@example.com', '$2y$10$abcdefghijklmnopqrstuv'); -- Replace with actual password hash