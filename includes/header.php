<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = !empty($_SESSION['user_id']);
$userName = htmlspecialchars($_SESSION['name'] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Exchange</title>
    <link rel="stylesheet" href="/book-exchange/css/style.css?v=2">
</head>
<body>
    <header class="app-header">
        <div class="header-inner container">
            <a href="/book-exchange/pages/index.php" class="brand">BookExchange</a>
            <button class="nav-toggle" id="nav-toggle" aria-expanded="false" aria-controls="nav-links">
                <span class="visually-hidden">Toggle navigation</span>☰
            </button>
            <nav>
                <ul class="nav-links" id="nav-links">
                    <li><a href="/book-exchange/pages/index.php">Home</a></li>
                    <li><a href="/book-exchange/pages/browse.php">Browse</a></li>
                    <li><a href="/book-exchange/pages/sell-book.php">Sell</a></li>
                    <li class="nav-auth" id="auth-links" <?php echo $isLoggedIn ? 'hidden' : ''; ?> >
                        <a href="/book-exchange/pages/login.php">Login</a>
                        <a href="/book-exchange/pages/register.php">Register</a>
                    </li>
                    <li class="nav-user-menu" id="user-menu" <?php echo $isLoggedIn ? '' : 'hidden'; ?> >
                        <button class="menu-trigger" id="menu-trigger" aria-haspopup="true" aria-expanded="false">
                            <span class="user-icon">👤</span>
                            <span id="user-name"><?php echo $userName; ?></span>
                        </button>
                        <ul class="menu-list" id="user-menu-list" hidden>
                            <li><a href="/book-exchange/pages/dashboard.php">Dashboard</a></li>
                            <li><a href="/book-exchange/pages/my-listings.php">My Listings</a></li>
                            <li><a href="/book-exchange/pages/orders.php">Orders</a></li>
                            <li><a href="/book-exchange/pages/purchase-history.php">Purchase History</a></li>
                            <li><a href="#" id="logout-btn" class="logout-link">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="page-main container">
