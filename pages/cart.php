<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include '../includes/header.php';
?>

<section class="page-section">
    <h1 class="page-heading">My Purchases</h1>
    <div id="cart-list" class="order-list"></div>
</section>

<script src="/book-exchange/js/cart.js"></script>
<script>document.addEventListener('DOMContentLoaded', loadCart);</script>
<?php include '../includes/footer.php'; ?>
