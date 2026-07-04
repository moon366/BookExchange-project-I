<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
include '../includes/header.php';
?>

<section class="page-section">
    <h1 class="page-heading">Orders</h1>
    <div class="order-tabs">
        <button class="tab active" data-role="buyer">Purchases</button>
        <button class="tab" data-role="seller">Sales</button>
    </div>
    <div id="order-list" class="order-list"></div>
</section>

<script src="/book-exchange/js/orders.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    loadOrders('buyer');
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            loadOrders(tab.dataset.role);
        });
    });
});
</script>
<?php include '../includes/footer.php'; ?>
