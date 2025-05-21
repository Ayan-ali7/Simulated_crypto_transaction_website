# Crypto Transaction Website

A web-based platform for simulating cryptocurrency trading with real-time price tracking from Binance API.

## Features

- **User Authentication**: Secure registration and login system
- **Real-time Dashboard**: Dark-themed interface showing your USDT, BTC, and ETH balances
- **Live Price Updates**: BTC and ETH prices fetched from Binance API in real-time
- **Interactive Charts**: Toggle between line charts and candlestick charts for market analysis
- **Trading Simulation**: Buy and sell crypto with your virtual balance
- **Transaction History**: Complete record of all your trading activities

## How It Works

### 1. User Login
- Register a new account or login with existing credentials
- Secure password hashing and session management
- User authentication protects all trading features

### 2. Dashboard
- **Dark-themed** interface designed for extended viewing
- Displays your current **USDT** balance along with **BTC** and **ETH** holdings
- Real-time price updates from Binance API refresh every few seconds
- Interactive charts for visualizing price trends
- Mobile-responsive design works across devices

### 3. Buy/Sell Functionality
- Intuitive trading form to simulate cryptocurrency purchases and sales
- Buy crypto using your USDT balance
- Sell your crypto holdings to increase your USDT balance
- All transactions are recorded in the database for reporting
- Real-time balance updates

### 4. User Experience
- Fast, responsive interface with minimal loading times
- Session-based authentication for security
- Logout functionality to protect your account

## Tech Stack

### Front-End
- HTML5, CSS3 with custom dark theme
- JavaScript (ES6+)
- Chart.js for interactive price charts
- Responsive design with CSS Grid/Flexbox

### Back-End
- PHP for server-side logic and API integration
- MySQL database for storing user data and transactions
- Session management for user authentication

### External Integrations
- Binance API for real-time cryptocurrency price data

## Installation

### Prerequisites
- Web server with PHP 7.4+ support (Apache, Nginx, etc.)
- MySQL 5.7+ or MariaDB 10.3+
- PHP with cURL and mysqli extensions enabled

