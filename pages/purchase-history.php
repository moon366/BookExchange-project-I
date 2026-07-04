<?php include '../includes/header.php'; ?>

<section class="page-section">
    <h1 class="page-heading">Purchase History</h1>
    <p class="page-intro">Books you've bought and received, all in one place.</p>
    <div id="purchase-list" class="order-list"></div>
</section>

<script>
async function loadPurchaseHistory() {
    const container = document.getElementById('purchase-list');
    try {
        const purchases = await apiGet('get_purchased_books.php');
        container.innerHTML = purchases.length
            ? purchases.map(p => `
                <div class="order-item">
                    <img src="${p.image_url || '/book-exchange/uploads/placeholder.svg'}" alt="${p.title}" class="dash-item-img">
                    <div>
                        <p><strong>${p.title}</strong> by ${p.author || 'Unknown'}</p>
                        <p>Paid: $${parseFloat(p.purchase_price).toFixed(2)}
                        ${p.original_price ? ` (Orig: $${parseFloat(p.original_price).toFixed(2)})` : ''}</p>
                        <p>Seller: ${p.seller_name}</p>
                        ${p.location ? `<p>📍 ${p.location}</p>` : ''}
                        <p class="dash-date">Purchased on ${new Date(p.purchase_date).toLocaleDateString()}</p>
                    </div>
                </div>
            `).join('')
            : '<p>No completed purchases yet. <a href="browse.php">Browse books</a></p>';
    } catch (err) {
        container.innerHTML = `<p class="error">${err.message}</p>`;
    }
}
document.addEventListener('DOMContentLoaded', loadPurchaseHistory);
</script>
<?php include '../includes/footer.php'; ?>